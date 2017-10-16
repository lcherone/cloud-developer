<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta name="robots" content="noindex, nofollow">

        <title><?= $meta['name'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?></title>
    </head>
    <body>
        <div class="container-fluid ajax-container">
            <?= $f3->decode($page['body']) ?>
            <?= $f3->decode($css) ?>
            <?= $f3->decode($javascript) ?>
        </div>
    </body>
</html>