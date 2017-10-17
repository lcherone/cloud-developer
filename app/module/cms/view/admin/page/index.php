<div class="row">
    <div class="col-lg-12">
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
                <h3 class="panel-title"><i class="fa fa-file-o fa-fw"></i> <span class="toggle-title">New & Uncompleted Pages</span></h3>
                <div class="panel-buttons text-right">
                    <div class="btn-group-xs">
                        <button class="btn btn-default toggle-hidden"><i class="fa fa-eye"></i> Show Completed Pages</button>
                        <a href="/admin/page/new" class="btn btn-success ajax-link"><i class="fa fa-plus"></i> New Page</a>
                    </div>
                </div>
            </div>
            <?php if (!empty($pages)): ?>
            <div class="panel-body nopadding active-pages">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th class="col-xs-3">Title</th>
                                <th class="col-xs-2">Template</th>
                                <th class="col-xs-2">Module</th>
                                <th class="col-xs-2">Slug</th>
                                <th class="col-xs-1">Lines</th>
                                <th class="col-xs-1">Views</th>
                                <th class="col-xs-1">Visibility</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody id="active-pages-body">
                            <?php $line_count = 0; foreach ($pages['active'] as $row): ?>
                            <tr data-id="<?= $row->id ?>">
                                <td><a href="/admin/page/edit/<?= $row->id ?>" class="ajax-link"><?= (!empty($row->title) ? $row->title : '-') ?></a></td>
                                <td><a href="/admin/template/edit/<?= $row->template->id ?>" class="ajax-link"><?= $row->template->name ?></a></td>
                                <td><a href="/admin/module/view/<?= $row->module->id ?>" class="ajax-link"><?= $row->module->name ?></a></td>
                                <td><a href="javascript:;" data-type="popup" data-url="<?= htmlentities($row->slug) ?>" data-name="<?= htmlentities($row->slug) ?>"><?= htmlentities($row->slug) ?></a></td>
                                <td><?= (int) $row->line_count ?></td>
                                <td><?= (int) $row->views ?></td>
                                <td><?= $visibilityname($row->visibility) ?></td>
                                <td>
                                    <div class="btn-group" style="display:flex">
                                        <a title="Mark Completed" href="/admin/page/hide/<?= $row->id ?>" class="btn btn-xs btn-default hide-page"><i class="fa fa-check-square-o"></i></a>
                                        <a href="/admin/page/delete/<?= $row->id ?>" class="btn btn-xs btn-danger remove-page"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
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
            <div class="panel-body nopadding hidden-pages hidden">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th class="col-xs-3">Title</th>
                                <th class="col-xs-2">Template</th>
                                <th class="col-xs-2">Module</th>
                                <th class="col-xs-2">Slug</th>
                                <th class="col-xs-1">Lines</th>
                                <th class="col-xs-1">Views</th>
                                <th class="col-xs-1">Visibility</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody id="hidden-pages-body">
                            <?php $line_count = 0; foreach ($pages['hidden'] as $row): ?>
                            <tr data-id="<?= $row->id ?>">
                                <td><a href="/admin/page/edit/<?= $row->id ?>" class="ajax-link"><?= (!empty($row->title) ? $row->title : '-') ?></a></td>
                                <td><a href="/admin/template/edit/<?= $row->template->id ?>" class="ajax-link"><?= $row->template->name ?></a></td>
                                <td><a href="/admin/module/view/<?= $row->module->id ?>" class="ajax-link"><?= $row->module->name ?></a></td>
                                <td><a href="javascript:;" data-type="popup" data-url="<?= htmlentities($row->slug) ?>" data-name="<?= htmlentities($row->slug) ?>"><?= htmlentities($row->slug) ?></a></td>
                                <td><?= (int) $row->line_count ?></td>
                                <td><?= (int) $row->views ?></td>
                                <td><?= $visibilityname($row->visibility) ?></td>
                                <td>
                                    <div class="btn-group" style="display:flex">
                                        <a title="Mark Uncompleted" href="/admin/page/unhide/<?= $row->id ?>" class="btn btn-xs btn-default unhide-page"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="/admin/page/delete/<?= $row->id ?>" class="btn btn-xs btn-danger remove-page"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
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
            <?php else: ?>
            <div class="panel-body">
                No pages have been added.
            </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
$(document).ready(function() {
    load.script('/js/module/page.js?developer', function(){
        page.index();
    });
 });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
