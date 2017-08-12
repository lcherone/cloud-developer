<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin <small> - menu - Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/menu"><i class="fa fa-list"></i> Menu</a></li>
            <li class="active"><i class="fa fa-pencil"></i> Create</li>
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
                <h3 class="panel-title"><i class="fa fa-list fa-fw"></i> Edit menu</h3>
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
                    
                    <div class="form-group<?= (!empty($form['errors']['icon']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-icon" class="control-label col-xs-2">Icon</label>
                        <div class="col-xs-8">
                            <input list="input-icon" class="form-control" name="icon" value="<?= (!empty($form['values']['icon']) ? htmlentities($form['values']['icon']) : '') ?>">
                            <datalist id="input-icon"></datalist>
                            <?php if (!empty($form['errors']['icon'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['icon'])): ?><span class="help-block"><?= $form['errors']['icon'] ?></span><?php endif ?>
                        </div>
                    </div>

                    <div class="form-group<?= (!empty($form['errors']['slug']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-slug" class="control-label col-xs-2">Slug</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-slug" name="slug" value="<?= (!empty($form['values']['slug']) ? htmlentities($form['values']['slug']) : '') ?>" placeholder="slug...">
                            <?php if (!empty($form['errors']['slug'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['slug'])): ?><span class="help-block"><?= $form['errors']['slug'] ?></span><?php endif ?>
                        </div>
                    </div>

                    <div class="form-group<?= (!empty($form['errors']['visibility']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-visibility" class="control-label col-xs-2">Visibility</label>
                        <div class="col-xs-8">
                            <select class="form-control" id="input-visibility" name="visibility">
                                <option value="1"<?= ($form['values']['visibility'] == '1' ? ' selected' : '') ?>>Always</option>
                                <option value="2"<?= ($form['values']['visibility'] == '2' ? ' selected' : '') ?>>When not signed in</option>
                                <option value="3"<?= ($form['values']['visibility'] == '3' ? ' selected' : '') ?>>When signed in</option>
                                <option value="4"<?= ($form['values']['visibility'] == '4' ? ' selected' : '') ?>>When developer</option>
                            </select>
                            <?php if (!empty($form['errors']['visibility'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['visibility'])): ?><span class="help-block"><?= $form['errors']['visibility'] ?></span><?php endif ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-yaml/3.6.0/js-yaml.min.js"></script>
<script>
    $(document).ready(function() {
        $.get('https://rawgit.com/FortAwesome/Font-Awesome/master/src/icons.yml', function(data){    
            var parsedYaml = jsyaml.load(data);
            var select = $('datalist#input-icon');
            var selected = select.data('value');
            
            $.each(parsedYaml.icons, function(index, icon) {
            	select.append('<option value="fa fa-' + icon.id + '"' + (selected === 'fa fa-' + icon.id ? ' selected' : '') + '></option>');
            });
        });

        // load.script('/js/module/tasks.js', function() {
        //     nodes.init();
        // });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
