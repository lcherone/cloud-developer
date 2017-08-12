<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Modules <small> - Create</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/module"><i class="fa fa-folder-o"></i> Modules</a></li>
            <li class="active"><i class="fa fa-folder-o"></i> Create</li>
        </ol>
    </div>
</div>

<?php if (!empty($form['errors']['global'])): ?>
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <?= $form['errors']['global'] ?>
</div>
<?php endif ?>
<?php if (!empty($form['errors']['success'])): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?= $form['errors']['success'] ?>
    </div>
<?php endif ?>

<form class="form-horizontal" method="post" action="/admin/module/create">
    <input type="hidden" name="csrf" value="<?= $csrf ?>">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-folder-o fa-fw"></i> Module Details</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-name" class="control-label">Name</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Enter module name... e.g: Blog">
                                        <!--<span class="input-group-btn">-->
                                        <!--    <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>-->
                                        <!--</span>-->
                                    </div>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['name'] ?></span><?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="form-group">
                                <td class="text-right"></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Before Load
                    <div class="btn-group pull-right">
                        <?php if (!empty($snippets)): ?>
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'beforeload') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    </h3>
                </div>
                <div class="panel-body nopadding">
                    <div class="">
                        <textarea class="form-control form-textarea" rows="10" id="input-beforeload" name="beforeload"><?= (!empty($form['values']['beforeload']) ? $form['values']['beforeload'] : '') ?></textarea>
                        <div id="beforeload" style="position: relative;height: 380px;width: 100%"></div>
                        <?php if (!empty($form['errors']['beforeload'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                        <?php if (!empty($form['errors']['beforeload'])): ?><span class="help-block"><?= $form['errors']['beforeload'] ?></span><?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php ob_start() ?>
<script src="https://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        //
        var textareaA = $('textarea[name="beforeload"]').hide(),
            editorA = ace.edit("beforeload"),
            editorSessionA = editorA.getSession();

        editorA.setTheme("ace/theme/eclipse");
        editorA.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionA.setUseWorker(false);
        editorSessionA.setMode("ace/mode/php");
        editorSessionA.setValue(textareaA.val());
        editorSessionA.on('change', function() {
            textareaA.val(editorSessionA.getValue());
        });
        
        $(document).on('click', '.fetch-snippet', function(){
            var id = $(this).data('id');
            var type = $(this).data('type');
            $.ajax({
                type: "GET",
                url: '/admin/snippet/get/'+id,
                dataType: "text",
                success: function(data) {
                    if (type == 'beforeload') {
                        editorSessionA.insert(editorA.getCursorPosition(), data);
                    }
                    
                    if (type == 'body') {
                        editorSession.insert(editor.getCursorPosition(), data);
                    }
                    
                    if (type == 'javascript') {
                        editorSessionJS.insert(editorJS.getCursorPosition(), data);
                    }
                    
                    if (type == 'css') {
                        editorSession.insert(editor.getCursorPosition(), data);
                    }
                }
            });
        });

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        $('[type="submit"]').trigger('click');
                    break;
                }
            }
        });
        
        // load.script('/js/tasks.js', function() {
        //     tasks.view();
        // });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
