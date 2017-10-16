<div class="row">
    <div class="col-lg-12">
        <!--<h1 class="page-header">-->
        <!--    Tasks <small> - New</small>-->
        <!--</h1>-->
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/tasks"><i class="fa fa-tasks"></i> Tasks</a></li>
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
                    <h3 class="panel-title"><i class="fa fa-tasks fa-fw"></i> New Task</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-name" class="control-label">Name</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Enter name... e.g: My Task">
                                    </div>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['name'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['description']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-description" class="control-label">Description</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-description" name="description" value="<?= (!empty($form['values']['description']) ? htmlentities($form['values']['description']) : '') ?>" placeholder="Description...">
                                    </div>
                                    <?php if (!empty($form['errors']['description'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['description'])): ?><span class="help-block"><?= $form['errors']['description'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['type']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-type" class="control-label">Type</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <select class="form-control" name="type" id="input-type">
                                            <option value="php-raw"<?= ($form['values']['type']  == 'php-raw' ? ' selected' : '') ?>>PHP Raw</option>
                                            <option value="php-closure"<?= ($form['values']['type']  == 'php-closure' ? ' selected' : '') ?>>PHP Closure</option>
                                            <option value="bash"<?= ($form['values']['type']  == 'bash' ? ' selected' : '') ?>>Bash</option>
                                        </select>
                                    </div>
                                    <?php if (!empty($form['errors']['type'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['type'])): ?><span class="help-block"><?= $form['errors']['type'] ?></span><?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group<?= (!empty($form['errors']['params']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-params" for="field1" class="control-label">Parameter Keys</label></td>
                                <td>
                                    <div class="input-group col-xs-10" id="fields">
                                        <div class="input-group entry">
                                            <input class="form-control" autocomplete="off" name="params[]" type="text" placeholder="Passed to $params = [...];"/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success add-row" type="button"><i class="fa fa-plus"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <?php if (!empty($form['errors']['visibility'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['visibility'])): ?><span class="help-block"><?= $form['errors']['slug'] ?></span><?php endif ?>
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
