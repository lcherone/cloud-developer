<div class="row">
    <div class="col-lg-12">
        <!--<h1 class="page-header">-->
        <!--    Templates-->
        <!--</h1>-->
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-columns"></i> Templates</li>
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
                <h3 class="panel-title"><i class="fa fa-columns fa-fw"></i> All Templates</h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <a href="/admin/template/new" class="btn btn-success ajax-link"><i class="fa fa-plus"></i> New Template</a>
                    </div>
                </div>
            </div>
            <?php if (!empty($templates)): ?>
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
                            <?php foreach ($templates as $row): ?>
                            <tr>
                                <td><a href="/admin/template/edit/<?= $row->id ?>"><?= $row->name ?></a></td>
                                <td><?= count($row->ownPage) ?></td>
                                <td>
                                    <div class="btn-group" style="display:flex">
                                        <a href="/admin/template/clone/<?= $row->id ?>" title="Clone" class="btn btn-xs btn-default"><i class="fa fa-code-fork"></i></a>
                                        <a href="/admin/template/delete/<?= $row->id ?>" title="Remove" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="panel-body">
                No tasks have been created.
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
