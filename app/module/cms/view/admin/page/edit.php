<?php
$formStyle = [
    'label' => '',
    'input' => ''
];
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Pages <small> - Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/page"><i class="fa fa-file-o"></i> Pages</a></li>
            <li class="active"><i class="fa fa-pencil"></i> Edit</li>
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
                                        <span class="input-group-btn">
                                            <a href="/admin/module/view/<?= (int) $form['values']['module_id'] ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a>
                                        </span>
                                    </div>
                                    <?php if (!empty($form['errors']['module_id'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['module_id'])): ?><span class="help-block"><?= $form['errors']['module_id'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['admin_only']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-admin_only" class="control-label">Visibility</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" id="input-admin_only" name="admin_only">
                                            <option value="1"<?= ($form['values']['admin_only'] == '1' ? ' selected' : '') ?>>When signed in</option>
                                            <option value="0"<?= ($form['values']['admin_only'] == '0' ? ' selected' : '') ?>>Always</option>
                                        </select>
                                    </div>
                                    <?php if (!empty($form['errors']['admin_only'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['admin_only'])): ?><span class="help-block"><?= $form['errors']['admin_only'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['template_id']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-template_id" class="control-label">Template</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" name="template_id" id="input-template_id">
                                            <?php foreach ($templates as $row): ?>
                                            <option value="<?= $row->id ?>"<?= ($form['values']['template_id'] == $row->id ? ' selected' : '') ?>><?= $row->title ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <span class="input-group-btn">
                                            <a href="/admin/template/edit/<?= (int) $form['values']['template_id'] ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a>
                                        </span>
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
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'beforeload') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
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
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'body') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
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
                        <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                        <?php foreach ($snippets as $row): if ($row->type != 'javascript') { continue; } ?>
                        <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                        <?php endforeach ?>
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

<?php ob_start() ?>
<script>
    $(document).ready(function() {

        //
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

        //
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

        // load.script('/js/module/tasks.js', function() {
        //     nodes.init();
        // });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
