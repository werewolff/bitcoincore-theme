<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); // вывод атрибутов языка ?>>
<head>
    <meta charset="<?php bloginfo('charset'); // кодировка ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php /* RSS и всякое */ ?>
    <link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="Comments RSS"
          href="<?php bloginfo('comments_rss2_url'); ?>">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php /* Все скрипты и стили теперь подключаются в functions.php */ ?>

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php wp_head(); // необходимо для работы плагинов и функционала ?>
</head>
<body <?php body_class(); // все классы для body ?>>
<?
$locations = get_nav_menu_locations();
$top_menu = wp_get_nav_menu_object($locations['top']);
?>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-dark <? echo $top_menu->count ? '' : 'justify-content-center' ?>">
                    <a class="navbar-brand" href="<? echo get_bloginfo('url') ?>">
                        <? include(get_template_directory() . '/img/btc.svg');
                        echo get_bloginfo('name')
                        ?>
                    </a>
                    <? if ($top_menu->count) { ?>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topnav"
                                aria-controls="topnav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    <? } ?>

                    <div class="collapse navbar-collapse" id="topnav">
                        <?php $args = array( // опции для вывода верхнего меню, чтобы они работали, меню должно быть создано в админке
                            'theme_location' => 'top', // идентификатор меню, определен в register_nav_menus() в functions.php
                            'container' => false, // обертка списка, тут не нужна
                            'menu_id' => 'top-nav-ul', // id для ul
                            'items_wrap' => '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
                            'menu_class' => 'top-menu', // класс для ul, первые 2 обязательны
                            'walker' => new bootstrap_menu(true) // верхнее меню выводится по разметке бутсрапа, см класс в functions.php, если по наведению субменю не раскрывать то передайте false
                        );
                        wp_nav_menu($args); // выводим верхнее меню
                        ?>
                    </div>
                    <? get_sidebar('menu'); ?>
                </nav>
            </div>
        </div>
    </div>
</header>
