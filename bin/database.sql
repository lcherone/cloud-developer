SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint(1) unsigned DEFAULT NULL,
  `visibility` tinyint(1) unsigned DEFAULT NULL,
  `site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `menu`;
INSERT INTO `menu` (`id`, `title`, `icon`, `slug`, `order`, `visibility`, `site`) VALUES
(1,	'Home',	'fa fa-home',	'/',	1,	1,	'');

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hide` int(11) unsigned DEFAULT NULL,
  `template_id` int(11) unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `views` int(11) unsigned DEFAULT NULL,
  `module_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` tinyint(1) unsigned DEFAULT NULL,
  `beforeload` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `javascript` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_count` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_page_template` (`template_id`),
  KEY `index_foreignkey_page_module` (`module_id`),
  CONSTRAINT `c_fk_page_module_id` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_page_template_id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `page`;
INSERT INTO `page` (`id`, `site`, `slug`, `hide`, `template_id`, `body`, `views`, `module_id`, `title`, `visibility`, `beforeload`, `css`, `javascript`, `line_count`) VALUES
(1,	'',	'/',	0,	5,	'<div class=\"row\">\n    <div class=\"col-lg-12\">\n        <h1 class=\"page-header\">\n            Welcome <small> - to my little website.</small>\n        </h1>\n        <ol class=\"breadcrumb\">\n            <li class=\"active\"><i class=\"fa fa-dashboard\"></i> Home</li>\n        </ol>\n    </div>\n</div>\n\n<p>You can edit me by signing in <a href=\"/admin\">here</a> as <strong>admin:admin</strong>.</p>',	1,	1,	'Home',	1,	'',	'',	'',	4);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `settings`;
INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1,	'sitename',	'My Website'),
(2,	'autogenerate',	'1'),
(3,	'composer',	'{\r\n    \"name\": \"lcherone/cloud-developer\",\r\n    \"description\": \"Code your project or system directly through the CMS, inception style!\",\r\n    \"type\": \"project\",\r\n    \"license\": \"MIT\",\r\n    \"authors\": [\r\n        {\r\n            \"name\": \"Lawrence Cherone\",\r\n            \"role\": \"Developer\"\r\n        }\r\n    ],\r\n    \"minimum-stability\": \"dev\",\r\n    \"prefer-stable\": true,\r\n    \"config\": {\r\n        \"optimize-autoloader\": true,\r\n        \"sort-packages\": true\r\n    },\r\n    \"require\": {\r\n        \"bcosca/fatfree-core\": \"^3.6\",\r\n        \"brandonwamboldt/utilphp\": \"1.1.*\",\r\n        \"gabordemooij/redbean\": \">=4.2\",\r\n        \"league/climate\": \"@dev\",\r\n        \"monolog/monolog\": \"^1.19\",\r\n        \"plinker/core\": \">=v0.1\",\r\n        \"plinker/redbean\": \">=v0.1\",\r\n        \"plinker/system\": \">=v1.0.1\",\r\n        \"plinker/tasks\": \"dev-master\"\r\n    },\r\n    \"autoload\": {\r\n        \"psr-4\": {\r\n            \"Tasks\\\\\": \"tasks\"\r\n        }\r\n    },\r\n    \"scripts\": {\r\n        \"post-create-project-cmd\": \"bash ./bin/setup.sh\",\r\n        \"setup\": \"bash ./bin/setup.sh\",\r\n        \"backup\": \"bash ./bin/backup.sh\"\r\n    }\r\n}\r\n'),
(4,	'error_template',	'1');

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` text COLLATE utf8mb4_unicode_ci,
  `site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `template`;
INSERT INTO `template` (`id`, `title`, `source`, `site`, `name`) VALUES
(1,	NULL,	'<!DOCTYPE html>\n<html lang=\"en\">\n    <head>\n        <meta charset=\"utf-8\">\n        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <meta name=\"description\" content=\"<?= $meta[\'description\'] ?>\">\n        <meta name=\"author\" content=\"<?= $meta[\'author\'] ?>\">\n\n        <title><?= $setting[\'sitename\'] ?><?= (!empty($page[\'title\']) ? \' - \'.$page[\'title\'] : \'\') ?></title>\n\n        <!-- bootstrap core css -->\n        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css\" integrity=\"sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=\" crossorigin=\"anonymous\" />\n\n        <!-- custom styles for this template -->\n        <link href=\"/css/styles.css\" rel=\"stylesheet\">\n        \n        <?= $f3->decode($css) ?>\n    </head>\n    <body>\n\n        <div id=\"wrapper\">\n            <nav class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">\n                <div class=\"navbar-header\">\n                    <?php if (!empty($_SESSION[\'user\'])): ?>\n                    <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\n                        <span class=\"sr-only\">Toggle navigation</span>\n                        <span class=\"icon-bar\"></span>\n                        <span class=\"icon-bar\"></span>\n                        <span class=\"icon-bar\"></span>\n                    </button>\n                    <?php endif ?>\n                    <a class=\"navbar-brand\" href=\"/\" class=\"ajax-link\"><?= $setting[\'sitename\'] ?></a>\n                </div>\n                <div class=\"collapse navbar-collapse navbar-collapse\">\n                    <ul class=\"nav navbar-nav side-nav\">\n                        <?php foreach ($menus as $row): ?>\n                        <?php \n                        // check for admin only\n                        if (empty($f3->get(\'SESSION.user\')) && $row->visibility == 4) {\n                            continue;\n                        }\n                        ?>\n                        <li<?= ($PATH == $row->slug ? \' class=\"active\"\' : \'\') ?>><a href=\"<?= $row->slug ?>\"><?= (!empty($row->icon) ? \'<i class=\"\'.$row->icon.\'\"></i> \' : \'\') ?><?= $row->title ?></a></li>\n                        <?php endforeach ?>\n                        <?php if (!empty($_SESSION[\'user\'])): ?>\n                        <li<?= ($PATH == \'/admin\' ? \' class=\"active\"\' : \'\') ?>><a href=\"/admin\"><i class=\"fa fa-user-secret\"></i> Developer</a></li>\n                        <?php endif ?>\n                    </ul>\n                </div>\n            </nav>\n            <div id=\"page-wrapper\">\n                <div class=\"container-fluid ajax-container\">\n                    <?= $f3->decode($page[\'body\']) ?>\n                </div>\n            </div>\n        </div>\n\n        <!-- scripts - placed at the end of the document so the pages load faster -->\n        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js\" integrity=\"sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=\" crossorigin=\"anonymous\"></script>\n        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=\" crossorigin=\"anonymous\"></script>\n        \n        <script src=\"/js/app.js\"></script>\n\n        <?= $f3->decode($javascript) ?>\n    </body>\n</html>',	'',	'Default');
