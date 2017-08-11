<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Pages <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-file-o"></i> Pages</li>
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
                <h3 class="panel-title"><i class="fa fa-file-o fa-fw"></i> All Pages</h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <a href="/admin/page/create" class="btn btn-success ajax-link"><i class="fa fa-plus"></i> New Page</a>
                    </div>
                </div>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Template</th>
                                <th>Module</th>
                                <th>Slug</th>
                                <th>Lines</th>
                                <th>Views</th>
                                <th>Visibility</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $line_count = 0; foreach ($pages as $row): ?>
                            <tr>
                                <td><a href="/admin/page/edit/<?= $row->id ?>"><?= $row->title ?></a></td>
                                <td><a href="/admin/template/edit/<?= $row->template->id ?>"><?= $row->template->title ?></a></td>
                                <td><a href="/admin/module/view/<?= $row->module->id ?>"><?= $row->module->name ?></a></td>
                                <td><a href="javascript:;" data-type="popup" data-url="<?= htmlentities($row->slug) ?>" data-name="<?= htmlentities($row->slug) ?>"><?= htmlentities($row->slug) ?></a></td>
                                <td><?= (int) $row->line_count ?></td>
                                <td><?= (int) $row->views ?></td>
                                <td><a href="#" data-toggle="tooltip" title="<?= (!empty($row->admin_only) ? 'When signed in' : 'Always') ?>"><i class="fa fa-<?= (!empty($row->admin_only) ? 'lock text-warning' : 'unlock text-success') ?>"></i></a></td>
                                <td><a href="/admin/page/delete/<?= $row->id ?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <?php $line_count = $line_count + (int) $row->line_count; endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total Lines:</td>
                                <td colspan="4"><?= $line_count ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
