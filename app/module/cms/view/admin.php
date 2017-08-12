<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $meta['description'] ?>">
        <meta name="author" content="<?= $meta['author'] ?>">

        <title><?= $meta['name'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" integrity="sha256-Qo9dfxjSvWBpcONv1klYEjbmw13NfsOC+oARxiq49/A=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
        <link href="/css/styles.css?default" rel="stylesheet">
        <?= $f3->decode($css) ?>
    </head>
    <body>
        <div id="<?= (!empty($_SESSION['user']) ? 'wrapper' : '') ?>">
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
                    <a class="navbar-brand" href="/" class="ajax-link"><i class="fa fa-cloud"></i> <?= $meta['name'] ?></a>
                </div>

                <?php if (!empty($_SESSION['user'])): ?>
                <div class="collapse navbar-collapse navbar-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li<?= ($PATH == '/admin' ? ' class="active"' : '') ?>><a href="/admin" class="ajax-link"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/module')) === '/admin/module' ? ' class="active"' : '') ?>><a href="/admin/module" class="ajax-link"><i class="fa fa-fw fa-folder-o"></i> Modules</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/page')) === '/admin/page' ? ' class="active"' : '') ?>><a href="/admin/page" class="ajax-link"><i class="fa fa-fw fa-file"></i> Pages</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/menu')) === '/admin/menu' ? ' class="active"' : '') ?>><a href="/admin/menu" class="ajax-link"><i class="fa fa-fw fa-list"></i> Menu</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/objects')) === '/admin/objects' ? ' class="active"' : '') ?>><a href="/admin/objects" class="ajax-link"><i class="fa fa-fw fa-code"></i> Objects</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/snippet')) === '/admin/snippet' ? ' class="active"' : '') ?>><a href="/admin/snippet" class="ajax-link"><i class="fa fa-fw fa-code"></i> Snippets</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/template')) === '/admin/template' ? ' class="active"' : '') ?>><a href="/admin/template" class="ajax-link"><i class="fa fa-fw fa-columns"></i> Templates</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/tasks')) === '/admin/tasks' ? ' class="active"' : '') ?>><a href="/admin/tasks" class="ajax-link"><i class="fa fa-fw fa-tasks"></i> Tasks</a></li>
                        <li<?= (substr($PATH, 0, strlen('/admin/settings')) === '/admin/settings' ? ' class="active"' : '') ?>><a href="/admin/settings" class="ajax-link"><i class="fa fa-fw fa-cogs"></i> Settings</a></li>
                        <li><a href="/admin/sign-out"><i class="fa fa-fw fa-sign-out"></i> Sign Out</a></li>
                    </ul>
                </div>
                <?php endif ?>
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid ajax-container">
                    <?= $f3->decode($page['body']) ?>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js" integrity="sha256-0dCrNKhVyiX4bBpScyU5PT/iZpxzlxjn2oyaR7GQutE=" crossorigin="anonymous"></script>
        <script src="https://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
        <script src="/js/app.js"></script>
        <?= $f3->decode($javascript) ?>
    </body>
</html>