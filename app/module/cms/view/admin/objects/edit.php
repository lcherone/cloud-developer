<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin <small> - Objects - Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/objects"><i class="fa fa-code"></i> Objects</a></li>
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

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-code fa-fw"></i> Edit Object</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">

                    <div class="form-group<?= (!empty($form['errors']['title']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-title" class="control-label col-xs-2">Title</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-title" name="title" value="<?= (!empty($form['values']['title']) ? htmlentities($form['values']['title']) : '') ?>" placeholder="title...">
                            <?php if (!empty($form['errors']['title'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['title'])): ?><span class="help-block"><?= $form['errors']['title'] ?></span><?php endif ?>
                        </div>
                    </div>

                    <div class="form-group<?= (!empty($form['errors']['source']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-source" class="control-label col-xs-2">Source</label>
                        <div class="col-xs-8">
                            <textarea class="form-control form-textarea" rows="10" id="input-source" name="source"><?= (!empty($form['values']['source']) ? $form['values']['source'] : '') ?></textarea>
                            <div id="source" style="position: relative;height: 380px;width: 100%"></div>

                            <?php if (!empty($form['errors']['source'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['source'])): ?><span class="help-block"><?= $form['errors']['source'] ?></span><?php endif ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
