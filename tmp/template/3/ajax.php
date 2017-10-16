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
            <?= $f3->decode($page['body']) ?>
            <?= $f3->decode($javascript) ?>
            <script>document.title = '<?= $meta['name'] ?><?= (!empty($page['title']) ? ' - '.$page['title'] : '') ?>';</script>
        </div>
    </body>
</html>