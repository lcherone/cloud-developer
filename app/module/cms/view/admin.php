<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta name="robots" content="noindex, nofollow">

        <title><?= $meta['name'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css?developer" rel="stylesheet" />

        <!-- Animation library for notifications -->
        <link href="/css/animate.min.css?developer" rel="stylesheet"/>

        <!--  Paper Dashboard core CSS -->
        <link href="/css/paper-dashboard.css?developer" rel="stylesheet"/>

        <!--  Cloud Developer App CSS -->
        <link href="/css/app.css?developer" rel="stylesheet" />

        <!--  Fonts and icons -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
        <link href="/css/themify-icons.css?developer" rel="stylesheet">
        <?= $f3->decode($css) ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar" data-background-color="<?= ($f3->get('setting.side_nav_color') == 'light' ? 'white' : 'black') ?>" data-active-color="<?= $f3->get('setting.active_color') ?>">
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="/" class="simple-text">
                            <i class="fa fa-cloud"></i> <?= $meta['name'] ?>
                        </a>
                    </div>
                    <ul class="nav">
                        <?php if (!empty($_SESSION['developer'])): ?>
                        <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><a href="/admin" class="ajax-link"><i class="fa fa-fw fa-dashboard"></i><p>Dashboard</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/module')) === '/admin/module' ? ' class="active"' : '') ?>><a href="/admin/module" class="ajax-link"><i class="fa fa-fw fa-folder-o"></i><p>Modules</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/page')) === '/admin/page' ? ' class="active"' : '') ?>><a href="/admin/page" class="ajax-link"><i class="fa fa-fw fa-file"></i><p>Pages</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/menu')) === '/admin/menu' ? ' class="active"' : '') ?>><a href="/admin/menu" class="ajax-link"><i class="fa fa-fw fa-list"></i><p>Menu</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/objects')) === '/admin/objects' ? ' class="active"' : '') ?>><a href="/admin/objects" class="ajax-link"><i class="fa fa-fw fa-code"></i><p>Objects</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/snippet')) === '/admin/snippet' ? ' class="active"' : '') ?>><a href="/admin/snippet" class="ajax-link"><i class="fa fa-fw fa-code"></i><p>Snippets</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/template')) === '/admin/template' ? ' class="active"' : '') ?>><a href="/admin/template" class="ajax-link"><i class="fa fa-fw fa-columns"></i><p>Templates</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/tasks')) === '/admin/tasks' ? ' class="active"' : '') ?>><a href="/admin/tasks" class="ajax-link"><i class="fa fa-fw fa-tasks"></i><p>Tasks</p></a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/settings')) === '/admin/settings' ? ' class="active"' : '') ?>><a href="/admin/settings" class="ajax-link"><i class="fa fa-fw fa-cogs"></i><p>Settings</p></a></li>
                        <li><a href="/admin/sign-out"><i class="fa fa-fw fa-sign-out"></i><p>Sign Out</p></a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <!-- -->
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar bar1"></span>
                                <span class="icon-bar bar2"></span>
                                <span class="icon-bar bar3"></span>
                            </button>
                            <a class="navbar-brand" href="#"><?= (!empty($page['title']) ? $page['title'] : '') ?></a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <form class="navbar-form navbar-left navbar-search-form" role="search">
    	    					<div class="input-group">
    	    						<span class="input-group-addon"><i class="fa fa-search"></i></span>
    	    						<input type="text" value="" id="search-value" class="form-control" placeholder="Search...">
    	    					</div>
    	    				</form>
                            <ul class="nav navbar-nav navbar-right">
                                
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="ti-panel"></i>
                                        <p>Stats</p>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="ti-bell"></i>
                                        <p class="notification">5</p>
                                        <p>Notifications</p>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Notification 1</a></li>
                                        <li><a href="#">Notification 2</a></li>
                                        <li><a href="#">Notification 3</a></li>
                                        <li><a href="#">Notification 4</a></li>
                                        <li><a href="#">Another notification</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="ti-settings"></i>
                                        <p>Settings</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- -->
                <div class="content">
                    <div class="container-fluid ajax-container">
                        <?= $f3->decode($page['body']) ?>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </body>

    <!--   Core JS Files   -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
    
    <!--   Plugin JS Files   -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js" integrity="sha256-0dCrNKhVyiX4bBpScyU5PT/iZpxzlxjn2oyaR7GQutE=" crossorigin="anonymous"></script>
    <script src="//ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="/js/bootstrap-checkbox-radio.js?developer"></script>

    <!--  Charts Plugin -->
    <script src="/js/chartist.min.js?developer"></script>

    <!--  Notifications Plugin -->
    <script src="/js/bootstrap-notify.js?developer"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="/js/paper-dashboard.js?developer"></script>

    <!-- App JS -->
    <script src="/js/app.js?developer"></script>
    <?= $f3->decode($javascript) ?>

</html>