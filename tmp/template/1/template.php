<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $meta['description'] ?>">
        <meta name="author" content="<?= $meta['author'] ?>">

        <title><?= $setting['sitename'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Muli:400,300" type="text/css" />
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <link href="/css/styles.css" rel="stylesheet">

        <?= $f3->decode($css) ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="ajax-container mdl-layout mdl-js-layout mdl-color--grey-100">
            <header class="container-fluid text-center">
                <div class="row ">
                    <h1 class="logo"><img src="https://lxc.systems/img/logo.png" alt="LXC.systems"> LXC.systems</h1>
                </div>
                <div class="row">
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
                            /*<?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?>*/
                            ?>
                            <li<?= ($PATH == $row->slug ? ' class="active"' : '') ?> style="margin-right:10px">
                                <button href="<?= $row->slug ?>" class="ajax-link mdl-button mdl-js-button mdl-button--raised <?= ($PATH == $row->slug ? 'mdl-button--colored' : '') ?> mdl-js-ripple-effect"><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?> <?= $row->title ?></button></li>
                            <?php endforeach ?>
                            <?php if (!empty($f3->get('SESSION.developer')) ): ?>
                            <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><button href="/admin" class="ajax-link mdl-button mdl-js-button mdl-button--raised <?= ($PATH == $row->slug ? 'mdl-button--colored' : '') ?> mdl-js-ripple-effect"><i class="fa fa-user-secret"></i> Developer</button></li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </header>
    
            <div class="container">
                <div class="container-fluid">
                    <?= $f3->decode($page['body']) ?>
                </div>
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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>

        <script src="/js/app.js"></script>

        <?= $f3->decode($javascript) ?>
        
    </body>
</html>