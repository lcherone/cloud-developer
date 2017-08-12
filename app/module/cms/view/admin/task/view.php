<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Tasks <small> - View</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/tasks"><i class="fa fa-tasks"></i> Tasks</a></li>
            <li class="active"><i class="fa fa-tasks"></i> View</li>
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

<?php if (!file_exists(getcwd().'/tasks/pids/Daemon.pid')): ?>
<div class="alert alert-info">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    It appers the task runner is not currently running, <a href="" class="ajax-link alert-link">click here to reload</a>. If the problem persists, check you have applyed the following crontask.<br>
    <code class="code">* * * * * cd <?= realpath(getcwd().'/tasks') ?> && /usr/bin/php <?= realpath(getcwd().'/tasks') ?>/run.php >/dev/null 2>&1</code>
</div>
<?php endif ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i> Task Details</h3>
                <div class="panel-buttons text-right">
                    <a href="/admin/tasks/edit/<?= (int) $f3->get('PARAMS.sub_action_id') ?>" class="btn btn-xs btn-primary ajax-link"><i class="fa fa-pencil"></i> Edit Task</a>
                    <a href="/admin/tasks/remove/<?= (int) $f3->get('PARAMS.sub_action_id') ?>" class="btn btn-xs btn-danger ajax-link"><i class="fa fa-trash"></i> Remove Task</a>
                    <a href="/admin/tasks/run/<?= (int) $f3->get('PARAMS.sub_action_id') ?>" class="btn btn-xs btn-success ajax-link"><i class="fa fa-play"></i> Run Task</a>
                </div>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <?php foreach ($task as $col => $value): 
                            // extract source from closure
                            if ($col == 'source') {
                               preg_match('/"function";s:\d+:"(.*)";s:\d+:/smi', $value, $matches);
                               
                               $value = (!empty($matches[1]) ? $matches[1] : $value);
                            }
                            
                            if ($col == 'params') {
                                $col = 'Parameters';
                            }
                            ?>
                            <tr>
                                <td class="col-md-2"><?= ucfirst($col) ?></td>
                                <td class="col-md-10"><?= ($col == 'source' ? '
                                    <textarea class="form-control form-textarea" rows="10" id="input-source" name="source">'.$value.'</textarea>
                                    <div id="source" style="position: relative;height: 400px;width: 100%"></div>
                                ' : $value) ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i> Tasks Queue</h3>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parameters</th>
                                <th>Repeats</th>
                                <th>Sleep</th>
                                <th>Run Count</th>
                                <th>Run Last</th>
                                <th>Run Next</th>
                                <th>Completed</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((array) $tasklog as $row): 
                            // extract source from closure
                            // if ($col == 'source') {
                            //   preg_match('/"function";s:\d+:"(.*)";s:\d+:/smi', $value, $matches);
                            //   $value = $matches[1];
                            // }
                            $params = json_decode($row->params);
                            if (is_array($params)) {
                                $params = json_encode($params);
                            }
                            ?>
                            <tr>
                                <td><?= $row->id ?></td>
                                <td><?= htmlentities($row->name) ?></td>
                                <td><?= $params ?></td>
                                <td><a href="#" class="repeats-select" data-type="select" data-pk="<?= $row->id ?>" data-name="repeats" data-value="<?= $row->repeats ?>" data-url="/tasks/inline_update/queue/<?= $row->id ?>" data-title="Set sleep time in seconds."></a></td>
                                <td>
                                    <a href="#" class="editable-input" data-type="text" data-pk="<?= $row->id ?>" data-name="sleep" data-value="<?= $row->sleep ?>" data-url="/tasks/inline_update/queue/<?= $row->id ?>" data-title="Set sleep time in seconds."></a>
                                </td>
                                <td><?= (int) $row->run_count ?></td>
                                <td><?= (empty($row->run_last) ? '-' : date_create($row->run_last)->format('F jS Y, g:ia')) ?></td>
                                <td><?= (empty($row->run_next) ? '-' : date_create($row->run_next)->format('F jS Y, g:ia')) ?></td>
                                <td><?= (empty($row->completed) ? '-' : date_create($row->completed)->format('F jS Y, g:ia')) ?></td>
                                <td>
                                    <div class="btn-group btn-group-xs" style="display:flex">
                                        <a href="#" class="btn btn-info toggle-result" data-id="<?= $row->id ?>"><i class="fa fa-eye"></i></a>
                                        <a href="/admin/tasks/remove/<?= (int) $f3->get('PARAMS.sub_action_id') ?>" class="btn btn-danger ajax-link"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="result-<?= $row->id ?>">
                                <td colspan="10">
                                    <?php if (empty($row->completed) && empty($row->result)): ?>
                                    Task waiting in queue for completion, <a href="/admin/tasks/view/<?= (int) $f3->get('PARAMS.sub_action_id') ?>">click here to reload</a>.
                                    <?php else: ?>
                                    <pre><?= $row->result ?></pre>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ob_start() ?>
<script src="https://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        load.script('/js/tasks.js', function() {
            tasks.view();
        });
    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
