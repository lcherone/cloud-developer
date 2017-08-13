<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Snippets <small> - New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/snippet"><i class="fa fa-code"></i> Snippets</a></li>
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
                    <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Snippet Details</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['title']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-title" class="control-label">Title</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-title" name="title" value="<?= (!empty($form['values']['title']) ? htmlentities($form['values']['title']) : '') ?>" placeholder="Enter title... e.g: Blog">
                                        <!--<span class="input-group-btn">-->
                                        <!--    <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>-->
                                        <!--</span>-->
                                    </div>
                                    <?php if (!empty($form['errors']['title'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['title'])): ?><span class="help-block"><?= $form['errors']['title'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['type']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right"><label for="input-type" class="control-label">Type</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" id="input-type" name="type">
                                            <option value="beforeload"<?= ($form['values']['type'] == 'beforeload' ? ' selected' : '') ?>>Before Load</option>
                                            <option value="body"<?= ($form['values']['type'] == 'body' ? ' selected' : '') ?>>Body</option>
                                            <option value="javascript"<?= ($form['values']['type'] == 'javascript' ? ' selected' : '') ?>>Javascript</option>
                                            <option value="css"<?= ($form['values']['type'] == 'css' ? ' selected' : '') ?>>CSS</option>
                                        </select>
                                    </div>
                                    <?php if (!empty($form['errors']['type'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['type'])): ?><span class="help-block"><?= $form['errors']['type'] ?></span><?php endif ?>
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
                    <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Code</h3>
                </div>
                <div class="panel-body nopadding<?= (!empty($form['errors']['source']) ? ' has-error has-feedback' : '') ?>">
                    <textarea class="form-control form-textarea" rows="10" id="input-source" name="source"><?= (!empty($form['values']['source']) ? $form['values']['source'] : '') ?></textarea>
                    <div id="source" style="position: relative;height: 380px;width: 100%"></div>
                    <?php if (!empty($form['errors']['source'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                    <?php if (!empty($form['errors']['source'])): ?><span class="help-block" style="margin-left:10px"><?= $form['errors']['source'] ?></span><?php endif ?>
                </div>
            </div>
        </div>
    </div>
</form>

<?php ob_start() ?>
<script>
    $(document).ready(function() {
        
    var textarea = $('textarea[name="source"]').hide(),
            editor = ace.edit("source"),
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
        
        // load.script('/js/module/tasks.js', function() {
        //     nodes.init();
        // });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>