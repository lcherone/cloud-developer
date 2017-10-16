<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="robots" content="noindex, nofollow"/>
        <title></title>
    </head>
    <body>
        <div class="ajax-container">
            <?= $f3->decode($css) ?>
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
            <?= $f3->decode($javascript) ?>
            <script>document.title = '<?= $meta['name'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?>';</script>
        </div>
    </body>
</html>