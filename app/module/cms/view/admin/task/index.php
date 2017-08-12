<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Tasks
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-tasks"></i> Tasks</li>
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
                <h3 class="panel-title"><i class="fa fa-tasks fa-fw"></i> All Tasks</h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <a href="/admin/tasks/create" class="btn btn-success ajax-link"><i class="fa fa-plus"></i> New Tasks</a>
                    </div>
                </div>
            </div>
            <?php if (!empty($tasksources)): ?>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="width:1%">ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Source Size (bytes)</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Tasks</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((array) $tasksources as $row): ?>
                            <tr>
                                <td><?= $row->id ?></td>
                                <td><a href="/admin/tasks/view/<?= $row->id ?>"><?= $row->name ?></a></td>
                                <td><?= $row->type ?></td>
                                <td><?= strlen($row->source) ?></td>
                                <td><?= date_create($row->created)->format('F jS Y, g:ia') ?></td>
                                <td><?= date_create($row->updated)->format('F jS Y, g:ia') ?></td>
                                <td><a href="/admin/tasks/view/<?= $row->id ?>#task-queue"><?= count($row->ownTasks) ?></a></td>
                                <td>
                                    <div class="btn-group" style="display:flex">
                                        <a href="/admin/tasks/run/<?= $row->id ?>" class="btn btn-xs btn-success ajax-link"><i class="fa fa-play"></i></a>
                                        <a href="/admin/tasks/edit/<?= $row->id ?>" class="btn btn-xs btn-primary ajax-link"><i class="fa fa-pencil"></i></a>
                                        <a href="/admin/tasks/remove/<?= $row->id ?>" class="btn btn-xs btn-danger ajax-link"><i class="fa fa-times"></i></a>
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
