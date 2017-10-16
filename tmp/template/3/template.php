<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'/>
        
        <title><?= $meta['title'] ?></title>
        <meta name="keywords" content="cloud, servers, server, deploy, dply, deployment, linux, applications, test, testing, build, run, script, cloud-init, ubuntu, free, lxc, lxd, social, fun, easy" />
        <meta name="description" content="LXC.systems offers a simplified cloud server experience for both novice and advanced users. Our service provides an easy way to share and test your cloud applications as a deployment on your website, GitHub or social networks.">
        <meta name="author" content="Lawrence Cherone">
        
        <?php
        $meta['title'] = !empty($meta['title']) ? $meta['title'] : $setting['sitename'] . (!empty($page['title']) ? ' - '.$page['title'] : '');
        $meta['description'] = !empty($meta['description']) ? $meta['description'] : '';
        $meta['author'] = !empty($meta['author']) ? $meta['author'] : '';
        $meta['image'] = !empty($meta['image']) ? $meta['image'] : '';
        ?>
        <!-- Google+ -->
        <meta itemprop="name" content="<?= $meta['title'] ?>">
        <meta itemprop="description" content="<?= $meta['description'] ?>">
        <meta itemprop="image" content="<?= $meta['image'] ?>">
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="<?= $meta['title'] ?>">
        <meta name="twitter:description" content="<?= $meta['description'] ?>">
        <meta name="twitter:creator" content="@WightSystems">
        <meta name="twitter:image:src" content="<?= $meta['image'] ?>">
        <!-- Facebook -->
        <meta property="og:title" content="<?= $meta['title'] ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="https://deploy.lxc.systems" />
        <meta property="og:image" content="<?= $meta['image'] ?>" />
        <meta property="og:description" content="<?= $meta['description'] ?>" />
        <meta property="og:site_name" content="LXC.systems - Deploments" />
        <meta property="article:published_time" content="2013-09-17T05:59:00+01:00" />
        <meta property="article:modified_time" content="2013-09-16T19:08:47+01:00" />
        <meta property="article:section" content="<?= $meta['title'] ?>" />
        <meta property="article:tag" content="<?= $meta['title'] ?>" />
        <!--<meta property="fb:admins" content="0000000000" />-->
    
    
    
    
    
    <!-- Bootstrap core CSS     -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    
    <?= $f3->decode($css) ?>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="/img/sidebar-1.jpg">
            <div class="logo">
                <a href="/" class="simple-text">
                    LXD Web Panel
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <?php foreach ($menus as $row): ?>
                    <?php
                    // when not signed in
                    if (!empty($f3->get('SESSION.user')) && $row->visibility == 2) {
                        continue;
                    }
                    // when signed in
                    if (empty($f3->get('SESSION.user')) && $row->visibility == 3) {
                        continue;
                    }
                    // check for admin/developer
                    if (empty($f3->get('SESSION.developer')) && $row->visibility == 4) {
                        continue;
                    }
                    ?>
                    <li<?= ($PATH == $row->slug ? ' class="active"' : '') ?>><a class="ajax-link" href="<?= $row->slug.(!empty($_GET['redirect']) ? '?redirect='.htmlentities($_GET['redirect']) : '') ?>"><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?><?= $row->title ?></a></li>
                    <?php endforeach ?>
                    <?php if (!empty($f3->get('SESSION.developer')) ): ?>
                    <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><a href="/admin"><i class="fa fa-user-secret"></i> Admin</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><?= (!empty($page['title']) ? ucfirst($page['title']) : '') ?></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        
                        <ul class="nav navbar-nav navbar-right">
                            <!--
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            -->
                        </ul>
                        
                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="ajax-container">
                        <?= $f3->decode($page['body']) ?>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                    </p>
                </div>
            </footer>
        </div>
    </div>
    <div id="ajax-modal" class="modal fade">
        <div class="modal-dialog cascading-modal z-depth-1">
            <div class="modal-content">
                <div class="modal-header primary-color white-text">
                    <h4 class="modal-title">Loading...</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body slow-warning"><p>Please wait...</p></div>
            </div>
        </div>
    </div>
</body>

<!--   Core JS Files   -->
<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="/js/bootstrap-notify.js"></script>
<!--  Google Maps Plugin    -->
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!-- Material Dashboard javascript methods -->
<script src="/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<!--<script src="/js/demo.js"></script>-->
<!-- JavaScript -->
<script src="/js/app.js"></script>
<?= $f3->decode($javascript) ?>

</html>