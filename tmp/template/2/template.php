<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
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

        <!-- CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link href="/css/mdb.min.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <?= $f3->decode($css) ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <!-- Google Ads -->
        <!--<meta name="google-site-verification" content="qjr0XvdW9T9prNA14hzOVyTg9ApqJjPX_K1ZZIJdjJE" />-->
        <!--<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
    </head>

    <body>
        <div id="backdrop-wrap">
            <div id="backdrop"></div>
        </div>
        <div class="ajax-container">
            <header class="container">
                <div class="d-flex justify-content-center">
                    <h1 class="logo">Disposable Email Lists</h1>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-xs-12 centered-pills top-links">
                        <ul class="nav nav-pills">
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
                            <li<?= ($PATH == $row->slug ? ' class="active"' : '') ?>><a class="ajax-link btn<?= ($PATH == $row->slug ? ' btn-outline-success' : ($row->slug == '/auth/sign-out' ? ' btn-outline-danger' : ' btn-outline-info')) ?>" href="<?= $row->slug.(!empty($_GET['redirect']) ? '?redirect='.htmlentities($_GET['redirect']) : '') ?>"><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?><?= $row->title ?></a></li>
                            <?php endforeach ?>
                            <?php if (!empty($f3->get('SESSION.developer')) ): ?>
                            <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><a class="btn btn-warning" href="/admin"><i class="fa fa-user-secret"></i> Admin</a></li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="container">
                <?= $f3->decode($page['body']) ?>
            </div>
        </div>
        <nav class="fab-container"> 
            <a href="#ajax-modal" data-url="/contact-us" data-size="modal-lg" data-toggle="modal" class="ajax-modal buttons btn-primary" tooltip="Contact Us"><i class="fa fa-envelope-o"></i></a>
            <a href="/faq" class="buttons btn-primary" tooltip="FAQ’s"><i class="fa fa-question"></i></a>
            <a href="/ai/ask" class="buttons btn-primary" tooltip="Ask Bot"><i class="fa fa-android"></i></a>
            <a href="https://community.lxc.systems/" target="_blank" class="buttons btn-primary" tooltip="Community"><i class="fa fa-users"></i></a>
            <span class="buttons btn-primary"><i class="fa fa-plus"></i></span>
        </nav>
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
        <!-- JavaScript -->
        <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="/js/popper.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/mdb.min.js"></script>
        <script src="/js/app.js"></script>
        <?= $f3->decode($javascript) ?>
    </body>
</html>