<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Tasks <small> - Create</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/tasks"><i class="fa fa-columns"></i> Tasks</a></li>
            <li class="active"><i class="fa fa-plus"></i> Create</li>
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
                <h3 class="panel-title"><i class="fa fa-columns fa-fw"></i> Create Task</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">

                    <div class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-name" class="control-label col-xs-2">Name</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Name...">
                            <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['name'] ?></span><?php endif ?>
                        </div>
                    </div>
                    <div class="form-group<?= (!empty($form['errors']['description']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-description" class="control-label col-xs-2">Description</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-description" name="description" value="<?= (!empty($form['values']['description']) ? htmlentities($form['values']['description']) : '') ?>" placeholder="Description...">
                            <?php if (!empty($form['errors']['description'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['description'])): ?><span class="help-block"><?= $form['errors']['description'] ?></span><?php endif ?>
                        </div>
                    </div>
                    <div class="form-group<?= (!empty($form['errors']['type']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-type" class="control-label col-xs-2">Type</label>
                        <div class="col-xs-8">
                            <select class="form-control" name="type" id="input-type">
                                <option value="php-raw" selected>PHP Raw</option>
                                <option value="php-closure">PHP Closure</option>
                                <option value="bash">Bash</option>
                            </select>
                            <?php if (!empty($form['errors']['type'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['type'])): ?><span class="help-block"><?= $form['errors']['type'] ?></span><?php endif ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field1" class="control-label col-xs-2">Parameter Keys</label>
                        <div class="col-xs-8" id="fields">
                            <div class="input-group entry">
                                <input class="form-control" autocomplete="off" name="params[]" type="text" placeholder="Passed to $params = [...];"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group<?= (!empty($form['errors']['source']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-source" class="control-label col-xs-2">Task Code</label>
                        <div class="col-xs-8">
                            <textarea class="form-control form-textarea" rows="10" id="input-source" name="source"><?= (!empty($form['values']['source']) ? $form['values']['source'] : '') ?></textarea>
                            <div id="source" style="position: relative;height: 400px;width: 100%"></div>
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
<script src="https://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
<script>
    $(document).ready(function() {
        var textarea = $('textarea[name="source"]').hide();
        var editor = ace.edit("source");
        editor.getSession().setUseWorker(false);
        editor.setTheme("ace/theme/eclipse");
        editor.getSession().setMode("ace/mode/php");

        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function() {
            textarea.val(editor.getSession().getValue());
        });
        
        $(document).on('click', '.add-row', function(e) {
            e.preventDefault();

            var controlForm = $('#fields:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');

            controlForm.find('.entry:not(:last) .add-row')
                .removeClass('add-row').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<i class="fa fa-times"></i>')
                .closest('.input-group').css('paddingBottom', '10px');

        }).on('click', '.btn-remove', function(e) {
            e.preventDefault();
            $(this).parents('.entry:first').remove();
            return false;
        });
        
        load.script('/js/module/tasks.js', function() {
            nodes.init();
        });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
