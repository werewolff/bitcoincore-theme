<?php
/**
 * Шаблон страницы blockchain (single-blockchain.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
get_header(); // подключаем header.php
?>
    <section>
        <div class="container-fluid bg-white rounded">
            <div class="row h-100">
                <div id="menu-left" class="col col-md-4 col-lg-3 ml-n3 d-md-block">
                    <?php get_sidebar('nav'); ?>
                </div>
                <div class="col">
                        <? breadcrumbs(); ?>
                    <div class="row">
                        <div class="py-3 <?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
                            <?php if (have_posts()) while (have_posts()) : the_post(); // старт цикла ?>
                                <article
                                        id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                                    <?
                                    if (is_method())
                                        $title_class = 'method-title';
                                    elseif (is_version())
                                        $title_class = 'version-title';
                                    elseif (is_blockchain())
                                        $title_class = 'blockchain-title';
                                    else
                                        $title_class = 'post-title'
                                    ?>
                                    <? echo (the_title(null, null, false) !== null) ? '<h1 class="' . $title_class . ' text-center text-break">' . the_title(null, null, false) . '</h1>' : '' ?>
                                    <?php the_content(); // контент ?>
                                </article>
                            <?php endwhile; // конец цикла ?>
                        </div>
                        <?php (is_method() || is_version()) ? get_sidebar() : ''; // подключаем sidebar.php ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); // подключаем footer.php ?>