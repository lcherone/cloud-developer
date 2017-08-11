<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $meta['description'] ?>">
        <meta name="author" content="<?= $meta['author'] ?>">

        <title><?= $setting['sitename'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=" crossorigin="anonymous" />
        <link href="/css/styles.css" rel="stylesheet">
        <?= $vars['css'] ?>
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
                        <li<?= ($PATH == $row->slug ? ' class="active"' : '') ?>><a href="<?= $row->slug ?>"><?= $row->title ?></a></li>
                        <?php endforeach ?>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
        <script src="/js/app.js"></script>
        <?= $vars['js'] ?>
    </body>
</html>




