<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin <small> - Settings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-cogs"></i> Settings</li>
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
                <h3 class="panel-title"><i class="fa fa-cogs fa-fw"></i> Edit Settings</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">

                    <div class="form-group<?= (!empty($form['errors']['sitename']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-sitename" class="control-label col-xs-2">Site Name</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-sitename" name="sitename" value="<?= (!empty($helper['extractValue']('sitename')) ? htmlentities($helper['extractValue']('sitename')) : '') ?>" placeholder="title...">
                            <?php if (!empty($form['errors']['sitename'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                             <?php if (!empty($form['errors']['sitename'])): ?><span class="help-block"><?= $form['errors']['sitename'] ?></span><?php endif ?>
                        </div>
                    </div>

                    <div class="form-group<?= (!empty($form['errors']['autogenerate']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-autogenerate" class="control-label col-xs-2">Auto-Generate Pages</label>
                        <div class="col-xs-8">
                            <select class="form-control" id="input-autogenerate" name="autogenerate">
                                <?php $current = $helper['extractValue']('autogenerate'); ?>
                                <option value="1"<?= ($current  == '1' ? ' selected' : '') ?>>Yes</option>
                                <option value="0"<?= ($current  == '0' ? ' selected' : '') ?>>No</option>
                            </select>
                            <?php if (!empty($form['errors']['autogenerate'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['autogenerate'])): ?>
                                <span class="help-block"><?= $form['errors']['autogenerate'] ?></span>
                            <?php else: ?>
                                <?php if ($current  == '1'): ?>
                                <span class="help-block">Visit any url to automatically generate your pages.</span>
                                <?php else: ?>
                                <span class="help-block">Pages are not generated, and users will be shown a 404.</span>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    </div>
                    
                    <div class="form-group<?= (!empty($form['errors']['composer']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-composer" class="control-label col-xs-2">Composer</label>
                        <div class="col-xs-8">
                            <?php $current = file_get_contents('./composer.json'); ?>
                            <textarea class="form-control form-textarea" rows="10" id="input-composer" name="composer"><?= $current ?></textarea>
                            <div id="composer" style="position: relative;height: 380px;width: 100%"></div>

                            <?php if (!empty($form['errors']['composer'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['composer'])): ?><span class="help-block"><?= $form['errors']['composer'] ?></span><?php endif ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($form['values']['composer_result'])): ?>
                    <div class="form-group">
                        <label for="input-composer" class="control-label col-xs-2">Composer Result</label>
                        <div class="col-xs-8"><pre><?= print_r($form['values']['composer_result'], true) ?></pre></div>
                    </div>
                    <?php endif ?>
                    
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
        
        var textarea = $('textarea[name="composer"]').hide(),
            editor = ace.edit("composer"),
            editorSession = editor.getSession();

        editor.setTheme("ace/theme/eclipse");
        editor.setOptions({
            minLines: 20,
            maxLines: Infinity
        });

        editorSession.setUseWorker(false);
        editorSession.setMode("ace/mode/json");
        editorSession.setValue(textarea.val());
        editorSession.on('change', function() {
            textarea.val(editorSession.getValue());
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
