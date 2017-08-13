<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Pages <small> - New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/page"><i class="fa fa-file-o"></i> Pages</a></li>
            <li class="active"><i class="fa fa-plus"></i> New</li>
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

<form class="form-horizontal" method="post">
    <input type="hidden" name="csrf" value="<?= $csrf ?>">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-file-o fa-fw"></i> Page Details</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['title']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-title" class="control-label">Title</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-title" name="title" value="<?= (!empty($form['values']['title']) ? htmlentities($form['values']['title']) : '') ?>" placeholder="Enter page title... e.g: My Page">
                                        <!--<span class="input-group-btn">-->
                                        <!--    <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>-->
                                        <!--</span>-->
                                    </div>
                                    <?php if (!empty($form['errors']['title'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['title'])): ?><span class="help-block"><?= $form['errors']['title'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['slug']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-slug" class="control-label">Slug</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-slug" name="slug" value="<?= (!empty($form['values']['slug']) ? htmlentities($form['values']['slug']) : '') ?>" placeholder="Enter page slug... e.g: /my-page">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" href="javascript:;" data-type="popup" data-url="<?= (!empty($form['values']['slug']) ? htmlentities($form['values']['slug']) : '') ?>" data-name="<?= (!empty($form['values']['title']) ? htmlentities($form['values']['title']) : '') ?>"><i class="fa fa-external-link"></i> Open</button>
                                        </span>
                                    </div>
                                    <?php if (!empty($form['errors']['slug'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['slug'])): ?><span class="help-block"><?= $form['errors']['slug'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['module_id']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-module_id" class="control-label">Module</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" name="module_id" id="input-module_id">
                                            <option value="-">-</option>
                                            <?php foreach ($modules as $row): ?>
                                            <option value="<?= $row->id ?>"<?= ($form['values']['module_id'] == $row->id ? ' selected' : '') ?>><?= $row->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <!--<span class="input-group-btn">-->
                                        <!--    <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>-->
                                        <!--</span>-->
                                    </div>
                                    <?php if (!empty($form['errors']['module_id'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['module_id'])): ?><span class="help-block"><?= $form['errors']['module_id'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['visibility']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-visibility" class="control-label">Visibility</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" id="input-visibility" name="visibility">
                                            <option value="1"<?= ($form['values']['visibility'] == '1' ? ' selected' : '') ?>>Always</option>
                                            <option value="2"<?= ($form['values']['visibility'] == '2' ? ' selected' : '') ?>>When not signed in</option>
                                            <option value="3"<?= ($form['values']['visibility'] == '3' ? ' selected' : '') ?>>When signed in</option>
                                            <option value="4"<?= ($form['values']['visibility'] == '4' ? ' selected' : '') ?>>When developer</option>
                                        </select>
                                    </div>
                                    <?php if (!empty($form['errors']['visibility'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['visibility'])): ?><span class="help-block"><?= $form['errors']['visibility'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['template_id']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-template_id" class="control-label">Template</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" name="template_id" id="input-template_id">
                                            <?php foreach ($templates as $row): ?>
                                            <option value="<?= $row->id ?>"><?= $row->title ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <?php if (!empty($form['errors']['template_id'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['template_id'])): ?><span class="help-block"><?= $form['errors']['template_id'] ?></span><?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="form-group">
                                <td class="text-right"></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <button type="submit" class="btn btn-primary">Save</button> <span class="text-muted" style="margin-left:15px"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Tip: You can also use Ctrl-s to save your changes.</span>
                                    </div>
                                    <?php if (!empty($form['errors']['template_id'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['template_id'])): ?><span class="help-block"><?= $form['errors']['template_id'] ?></span><?php endif ?>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Body
                    <div class="btn-group pull-right">
                        <?php if (!empty($snippets)): ?>
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'body') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    </h3>
                </div>
                <div class="panel-body nopadding">
                    <div class="">
                        <textarea class="form-control form-textarea" rows="10" id="input-body" name="body"><?= (!empty($form['values']['body']) ? $form['values']['body'] : '') ?></textarea>
                        <div id="body" style="position: relative;height: 380px;width: 100%"></div>
                        <?php if (!empty($form['errors']['body'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                        <?php if (!empty($form['errors']['body'])): ?><span class="help-block"><?= $form['errors']['body'] ?></span><?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Javascript
                    <div class="btn-group pull-right">
                        <?php if (!empty($snippets)): ?>
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'javascript') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    </h3>
                </div>
                <div class="panel-body nopadding">
                    <div class="">
                        <textarea class="form-control form-textarea" rows="10" id="input-javascript" name="javascript"><?= (!empty($form['values']['javascript']) ? $form['values']['javascript'] : '') ?></textarea>
                        <div id="javascript" style="position: relative;height: 380px;width: 100%"></div>
                        <?php if (!empty($form['errors']['javascript'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                        <?php if (!empty($form['errors']['javascript'])): ?><span class="help-block"><?= $form['errors']['javascript'] ?></span><?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!--<div class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">-->
<!--                <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i> Page Preview <small>(note: PHP and JavaScript is NOT rendered in preview)</small></h3>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <div id="page-preview"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php ob_start() ?>
<script>
    $(document).ready(function() {

        var textareaJS = $('textarea[name="javascript"]').hide(),
            editorJS = ace.edit("javascript"),
            editorSessionJS = editorJS.getSession();

        editorJS.setTheme("ace/theme/eclipse");
        editorJS.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSessionJS.setUseWorker(false);
        editorSessionJS.setMode("ace/mode/php");
        editorSessionJS.setValue(textareaJS.val());
        editorSessionJS.on('change', function() {
            textareaJS.val(editorSessionJS.getValue());
        });

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

        var textarea = $('textarea[name="body"]').hide(),
            editor = ace.edit("body"),
            editorSession = editor.getSession();

        editor.setTheme("ace/theme/eclipse");
        editor.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSession.setUseWorker(false);
        editorSession.setMode("ace/mode/php");
        editorSession.setValue(textarea.val());
        editorSession.on('change', function() {
            textarea.val(editorSession.getValue());

            //console.log('sorry <script> tags wont work on live preview.');
            //$('#page-preview').html($('<div/>').html(editorSession.getValue()).find('script').remove().end().contents());
        });
        //$('#page-preview').html($('<div/>').html(editorSession.getValue()).find('script').remove().end().contents());
        
        
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

        // load.script('/js/module/tasks.js', function() {
        //     nodes.init();
        // });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
