<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $meta['description'] ?>">
        <meta name="author" content="<?= $meta['author'] ?>">

        <title><?= $setting['sitename'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>

        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="/css/blog.css" rel="stylesheet">
        <?= $f3->decode($css) ?>
    </head>

    <body>

        <div class="blog-masthead">
            <div class="container">
                <nav class="nav blog-nav">
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
                    <a class="nav-link<?= ($PATH == $row->slug ? ' active' : '') ?>" href="<?= $row->slug ?>"><?= (!empty($row->icon) ? '<i class="'.$row->icon.'"></i> ' : '') ?><?= $row->title ?></a>
                    <?php endforeach ?>
                    <?php if (!empty($f3->get('SESSION.developer'))): ?>
                    <a class="nav-link<?= ($PATH == '/admin' ? ' class="active"' : '') ?>" href="/admin"><i class="fa fa-user-secret"></i> Admin</a>
                    <?php endif ?>
                </nav>
            </div>
        </div>

        <div class="blog-header">
            <div class="container">
                <h1 class="blog-title">The <?= $setting['sitename'] ?> Blog</h1>
                <p class="lead blog-description">For updates, rants and all that jazz!</p>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-sm-8 blog-main">
                    <?php if (!empty($f3->get('SESSION.developer')) && !empty($page['page_id'])): ?>
                    <div class="admin-btns text-right" style="margin-bottom:0px;z-index:9999">
                        <a href="/admin/page/edit/<?= $page['page_id'] ?>" class="btn btn-xs btn-danger">Edit</a>
                    </div>
                    <?php endif ?>
                    <div class="ajax-container">
                        <?= $f3->decode($page['body']) ?>
                    </div>
                </div>

                <div class="col-sm-3 offset-sm-1 blog-sidebar">
                    <div class="sidebar-module sidebar-module-inset">
                        <h4>About</h4>
                        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    </div>
                    <div class="sidebar-module">
                        <h4>Archives</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">March 2014</a></li>
                            <li><a href="#">February 2014</a></li>
                            <li><a href="#">January 2014</a></li>
                            <li><a href="#">December 2013</a></li>
                            <li><a href="#">November 2013</a></li>
                            <li><a href="#">October 2013</a></li>
                            <li><a href="#">September 2013</a></li>
                            <li><a href="#">August 2013</a></li>
                            <li><a href="#">July 2013</a></li>
                            <li><a href="#">June 2013</a></li>
                            <li><a href="#">May 2013</a></li>
                            <li><a href="#">April 2013</a></li>
                        </ol>
                    </div>
                    <div class="sidebar-module">
                        <h4>Elsewhere</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ol>
                    </div>
                </div><!-- /.blog-sidebar -->

            </div><!-- /.row -->

        </div><!-- /.container -->

        <footer class="blog-footer">
            <p>&copy; <?= date('Y') ?> - <?= $setting['sitename'] ?></p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

        <script src="/js/ie10-viewport.js"></script>
        <?= $f3->decode($javascript) ?>
    </body>
</html>
