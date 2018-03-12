<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/template"><i class="fa fa-columns"></i> Templates</a></li>
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

<form class="form-horizontal" method="post" action="/admin/template/edit/<?= (!empty($form['values']['id']) ? htmlentities($form['values']['id']) : '') ?>">
    <input type="hidden" name="csrf" value="<?= $csrf ?>">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-columns fa-fw"></i> Template Details</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-name" class="control-label">Name</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Enter template name... e.g: Default">
                                    </div>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['name'] ?></span><?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="form-group">
                                <td class="text-right"></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <button type="submit" class="btn btn-primary save-details ajax_save">Save</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-eye fa-fw"></i> Preview <small>- Links are disabled!</small></h3>
                </div>
                <div class="panel-body nopadding" style="height:350px">
                    <div class="embed-responsive embed-responsive-16by9" style="height:350px">
                        <iframe class="embed-responsive-item" id="template-preview" src="" data-src="/admin/template/preview/<?= $f3->get('PARAMS.sub_action_id') ?>" style="height:350px" height="350px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-files-o" aria-hidden="true"></i> Files</h3>
                    <div class="panel-form">
                         <form class="form-inline">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-xs btn-danger remove-file hidden"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                </span>
                                <input type="text" class="form-control col-xs-4" style="height:25px" id="new-file-name" value="" placeholder="Enter filename.ext&hellip;" >
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-xs btn-success new-file"><i class="fa fa-file" aria-hidden="true"></i> New File</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="panel-buttons text-right">
                        <div class="btn-group-xs">
                            <a href="#" role="button" class="btn btn-link btn-xs label-btn hidden" id="file-saved" aria-disabled="true"><span class="text-success">File saved!</span></a>
                            <?php $snippets = $getsnippets('template'); if (!empty($snippets)): ?>
                            <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                            <?php foreach ($snippets as $row): if ($row->type != 'template') {
    continue;
} ?>
                            <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                            <?php endforeach ?>
                            <?php endif ?>
                            <button type="button" class="btn btn-xs btn-success save-file" data-file="template.php"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body nopadding">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2 nopadding">
                        <div id="fileList" style="width:100%"></div>
                        <form action="/admin/template/upload-file/<?= $f3->get('PARAMS.sub_action_id') ?>" class="dropzone" role="form"></form>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10 nopadding">
                        <textarea class="form-control form-textarea" rows="10" id="input-source" name="source"><?= (!empty($form['values']['source']) ? $form['values']['source'] : '') ?></textarea>
                        <div id="source" style="position:relative;min-height:750px;width:100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form> 

<?php
$db = new \Framework\Model('servers');

$server =  $db->findOne('id = ?', [1]);

try {
    $error = [];
    $tasks = new Plinker\Core\Client(
        $server->endpoint,
        'Tasks\Manager',
        $server->public_key,
        $server->private_key,
        json_decode($server->config, true),
        $server->encrypted // enable encryption [default: true]
    );
    $files = json_encode((array) $tasks->files(getcwd().'/tmp/template/'.(int) $f3->get('PARAMS.sub_action_id')));
} catch (\Exception $e) {
    $files = '{}';
}
?>

<?php ob_start() ?>
<script>
Dropzone.autoDiscover = false;
$(document).ready(function() {
    load.script('/js/module/template.js?developer', function(){
        template.edit({
            route_id: '<?= (int) $f3->get('PARAMS.sub_action_id') ?>',
            files: <?= $files ?>
        });
    });
 });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
