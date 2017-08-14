<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Modules <small> - Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/module"><i class="fa fa-list"></i> Modules</a></li>
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
                <h3 class="panel-title"><i class="fa fa-list fa-fw"></i> Edit Module</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">

                    <div class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                        <label for="input-name" class="control-label col-xs-2">Name</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Enter module name..">
                            <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['title'] ?></span><?php endif ?>
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
