<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
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
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-folder-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($modules) ?></div>
                        <h2>Modules</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/module">
                <div class="panel-footer">
                    <span class="pull-left">View Modules</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($pages) ?></div>
                        <h2>Pages</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/page">
                <div class="panel-footer">
                    <span class="pull-left">View Pages</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-code fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($objects) ?></div>
                        <h2>Objects</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/objects">
                <div class="panel-footer">
                    <span class="pull-left">View Objects</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-code fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($snippets) ?></div>
                        <h2>Snippets</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/snippet">
                <div class="panel-footer">
                    <span class="pull-left">View Snippets</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($tasks) ?></div>
                        <h2>Tasks</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/tasks">
                <div class="panel-footer">
                    <span class="pull-left">View Tasks</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($menus) ?></div>
                        <h2>Menu</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/menu">
                <div class="panel-footer">
                    <span class="pull-left">View Menu</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-columns fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($templates) ?></div>
                        <h2>Templates</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/template">
                <div class="panel-footer">
                    <span class="pull-left">View Templates</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-cogs fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">&nbsp;</div>
                        <h2>Settings</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/settings">
                <div class="panel-footer">
                    <span class="pull-left">View Settings</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i> System Information</h3>
    </div>
    <div class="panel-body nopadding">
        <div class="table-responsive">
            <table class="table table-condensed form-table">
                <tbody>
                    <?php
                    $taskResult = $getTaskResult(['hostname'], 86400);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['hostname'] : '-');
                    ?>
                    <tr>
                        <td>Hostname<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['uname'], 86400);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['uname'] : '-');
                    ?>
                    <tr>
                        <td>Uname<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['uptime'], 60);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['uptime'] : '-');
                    ?>
                    <tr>
                        <td>Uptime<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['ping', 'phive.free.lxd.systems'], 300);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['ping'] : '-');
                    ?>
                    <tr>
                        <td>Ping<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?>ms</td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['distro'], 86400);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['distro'] : '-');
                    ?>
                    <tr>
                        <td>Distro<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['arch'], 86400);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['arch'] : '-');
                    ?>
                    <tr>
                        <td>Arch<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['load'], 120);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['load'] : '-');
                    ?>
                    <tr>
                        <td>Load<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['server_cpu_usage'], 30);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['server_cpu_usage'] : '-');
                    ?>
                    <tr>
                        <td>CPU Usage<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td><td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" style="width: <?= $result ?>%">
                                <?= $result ?>%
                            </div>
                            <div class="progress-bar progress-bar-success" style="width: <?= 100-$result ?>%">
                                <?= 100-$result ?>%
                            </div>
                        </div>
                        </td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['memory_stats'], 30);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['memory_stats'] : '-');
                    ?>
                    <tr>
                        <td class="col-md-2">Memory stats<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td class="col-md-10">
                            <?php
                            $mem_used = @$result['used'];
                            $mem_cache = @$result['cache'];
                            $mem_free = 100 - $mem_used - $mem_cache;
                            ?>
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" style="width: <?= $mem_used ?>%">
                                    <?= $mem_used ?>%
                                </div>
                                <div class="progress-bar progress-bar-warning" style="width: <?= $mem_cache ?>%">
                                    <?= $mem_cache ?>%
                                </div>
                                <div class="progress-bar progress-bar-success" style="width: <?= $mem_free ?>%">
                                    <?= $mem_free ?>%
                                </div>
                            </div>
                        </td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['disk_space', '/'], 60);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['disk_space'] : '-');
                    ?>
                    <tr>
                        <td class="col-md-2">Diskspace<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td class="col-md-10">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" style="width: <?= 100-$result ?>%">
                                    <?= 100-$result ?>%
                                </div>
                                <div class="progress-bar progress-bar-success" style="width: <?= $result ?>%">
                                    <?= $result ?>%
                                </div>
                            </div>
                        </td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['memory_total'], 21600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['memory_total'] : '0');
                    ?>
                    <tr>
                        <td>Total Memory<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= \utilphp\util::size_format((int) $result * 1000, 2) ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['machine_id'], 86400);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['machine_id'] : '-');
                    ?>
                    <tr>
                        <td>Machine ID<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['netstat', '-pant'], 3600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['netstat'] : '-');
                    ?>
                    <tr>
                        <td>Netstat<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['logins'], 600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['logins'] : '-');
                    ?>
                    <tr>
                        <td>System Logins<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['pstree'], 600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['pstree'] : '-');
                    ?>
                    <tr>
                        <td>Process Tree<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['top'], 21600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['top'] : '-');
                    ?>
                    <tr>
                        <td>Top<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['cpuinfo'], 21600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['cpuinfo'] : '-');
                    ?>
                    <tr>
                        <td>CPU Information<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                    $taskResult = $getTaskResult(['disks'], 21600);
                    $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)['disks'] : '-');
                    ?>
                    <tr>
                        <td>Disks<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>