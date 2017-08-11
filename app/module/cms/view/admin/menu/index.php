<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin <small> - Menu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-list"></i> Menu</li>
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
                <h3 class="panel-title"><i class="fa fa-list fa-fw"></i> Menus</h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <a href="/admin/menu/create" class="btn btn-success ajax-link">New Menu</a>
                    </div>
                </div>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="width:1%"></th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Visibility</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menus as $row): ?>
                            <tr>
                                <td><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i>' : '') ?></td>
                                <td><a href="/admin/menu/edit/<?= $row->id ?>"><?= $row->title ?></a></td>
                                <td><?= $row->slug ?></td>
                                <td><i class="fa fa-<?= (!empty($row->admin_only) ? 'check text-success' : 'times text-danger') ?>"></i></td>
                                <td><a href="/admin/menu/delete/<?= $row->id ?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
