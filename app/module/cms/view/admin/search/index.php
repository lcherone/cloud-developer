<div class="row">
    <div class="col-lg-12">
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
                <h3 class="panel-title"><i class="fa fa-search fa-fw"></i> Search</h3>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((array) $results as $type => $result): ?>
                            <?php foreach ($result as $row): ?>
                            <tr>
                                <td><a href="/admin/<?= ($type == 'task' ? 'tasks' : ($type == 'object' ? 'objects' : $type)) ?>/<?= ($type == 'task' ? 'view' : 'edit') ?>/<?= $row->id ?>" class="ajax-link"><?= $row->title ?></a></td>
                                <td><?= ucfirst($type) ?></td>
                                <td>
                                    <?php if (in_array($type, ['page', 'object', 'snippet', 'task', 'template'])): ?>
                                    <button type="button" class="btn btn-xs btn-primary show-code" data-id="<?= $row->id ?>"><i class="fa fa-eye"></i> Show Code</button>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php if (in_array($type, ['page', 'object', 'snippet', 'task', 'template'])): ?>
                            <tr class="hidden" id="code-<?= $row->id ?>">
                                <td colspan="3" class="nopadding" style="padding:0px">
                                    <textarea class="editor" data-id="<?= $row->id ?>" data-term="<?= $f3->get('GET.term') ?>" id="editor-<?= $row->id ?>"><?= $row->body ?></textarea>
                                </td>
                            </tr>
                            <?php endif ?>
                            <?php endforeach ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
$(document).ready(function() {
    load.script('/js/module/search.js?developer', function(){
        search.index();
    });
 });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
