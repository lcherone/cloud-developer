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
                        <i class="fa fa-server fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= count($servers) ?></div>
                        <h2>Servers</h2>
                    </div>
                </div>
            </div>
            <a href="/admin/servers">
                <div class="panel-footer">
                    <span class="pull-left">View Servers</span>
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
                            $key        = 'hostname';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Hostname<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'uname';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 86400);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Uname<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'uptime';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 60);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Uptime<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'ping';
                            $params     = [$key, 'phive.free.lxd.systems'];
                            $taskResult = $tasks->run('System Information', $params, 300);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Ping<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?>ms</td>
                    </tr>

                    <?php
                            $key        = 'distro';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 86400);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Distro<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'arch';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 86400);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Arch<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'load';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 120);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Load<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><?= $result ?></td>
                    </tr>

                    <?php
                            $key        = 'server_cpu_usage';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 15);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>CPU Usage<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td><td>
                        <div class="progress" data-placement="bottom" data-toggle="tooltip" href="#">
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
                            $key        = 'memory_stats';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 15);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td class="col-md-2">Memory stats<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td class="col-md-10">
                            <?php
                            $mem_used = @$result['used'];
                            $mem_cache = @$result['cache'];
                            $mem_free = 100 - $mem_used - $mem_cache;
                            ?>
                            <div class="progress" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Total memory:">
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
                            $key        = 'disk_space';
                            $params     = [$key, '/'];
                            $taskResult = $tasks->run('System Information', $params, 60);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td class="col-md-2">Diskspace<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td class="col-md-10">
                            <div class="progress" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Total disk space: ">
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
                            $key        = 'memory_total';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Total Memory<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'machine_id';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 86400);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Machine ID<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'netstat';
                            $params     = [$key, '-pant'];
                            $taskResult = $tasks->run('System Information', $params, 3600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Netstat<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'logins';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>System Logins<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'pstree';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Process Tree<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'top';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>Top<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'cpuinfo';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
                    ?>
                    <tr>
                        <td>CPU Information<?= (!empty($taskResult['run_last']) ? '<br><small class="text-muted">'.(empty($taskResult['run_last']) ? '-' : \utilphp\util::human_time_diff(strtotime($taskResult['run_last']))).'</small>' : '') ?></td>
                        <td><pre><?= $result ?></pre></td>
                    </tr>

                    <?php
                            $key        = 'disks';
                            $params     = [$key];
                            $taskResult = $tasks->run('System Information', $params, 21600);
                            $result     = (!empty($taskResult['result']) ? json_decode($taskResult['result'], true)[$key] : '-');
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