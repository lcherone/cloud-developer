<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-folder-o"></i> Modules</li>
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
                <h3 class="panel-title"><i class="fa fa-folder-o fa-fw"></i> All Modules</h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <a href="/admin/module/new" class="btn btn-success ajax-link"><i class="fa fa-plus"></i> New Module</a>
                    </div>
                </div>
            </div>
            <?php if (!empty($modules)): ?>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Pages</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $row): ?>
                            <tr>
                                <td><a href="/admin/module/view/<?= $row->id ?>" class="ajax-link"><?= $row->name ?></a></td>
                                <td><a href="/admin/module/view/<?= $row->id ?>#module-pages"><?= count($row->ownPage) ?></a></td>
                                <td><a href="/admin/module/delete/<?= $row->id ?>" class="btn btn-xs btn-danger remove-module"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>           
            <?php else: ?>
            <div class="panel-body">
                No modules have been added.
            </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
$(document).ready(function() {
    load.script('/js/module/module.js?developer', function(){
        module.index();
    });
 });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
