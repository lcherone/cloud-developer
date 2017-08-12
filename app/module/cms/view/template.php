<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $meta['description'] ?>">
        <meta name="author" content="<?= $meta['author'] ?>">

        <title><?= $setting['sitename'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <!-- bootstrap core css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=" crossorigin="anonymous" />

        <!-- custom styles for this template -->
        <link href="/css/styles.css" rel="stylesheet">
        
        <?= $f3->decode($css) ?>
    </head>
    <body>

        <div id="wrapper">
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <?php if (!empty($_SESSION['user'])): ?>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php endif ?>
                    <a class="navbar-brand" href="/" class="ajax-link"><?= $setting['sitename'] ?></a>
                </div>
                <div class="collapse navbar-collapse navbar-collapse">
                    <ul class="nav navbar-nav side-nav">
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
                        <li<?= ($PATH == $row->slug ? ' class="active"' : '') ?>><a href="<?= $row->slug ?>"><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?><?= $row->title ?></a></li>
                        <?php endforeach ?>
                        <?php if (!empty($_SESSION['user'])): ?>
                        <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><a href="/admin"><i class="fa fa-user-secret"></i> Admin</a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper">
                <?php if (!empty($_SESSION['user'])): ?>
                <div class="admin-btns text-right" style="margin-bottom:0px;z-index:9999">
                    <a href="/admin/page/edit/<?= $page['page_id'] ?>" class="btn btn-xs btn-danger">Edit</a>
                </div>
                <?php endif ?>
                <div class="container-fluid ajax-container">
                    <?= $f3->decode($page['body']) ?>
                </div>
            </div>
        </div>

        <!-- scripts - placed at the end of the document so the pages load faster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
        
        <script src="/js/app.js"></script>

        <?= $f3->decode($javascript) ?>
    </body>
</html>