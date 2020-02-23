<?php
/**
 * Шаблон обычной страницы (page.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
get_header(); // подключаем header.php ?>
    <section>
        <div class="container shadow p-3 bg-white rounded">
            <div class="row h-100">
                <div class="<?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
                    <?php if (have_posts()) while (have_posts()) : the_post(); // старт цикла ?>
                        <article
                            id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                            <?
                            if (is_method($post->ID))
                                $title_class = 'method-title ';
                            elseif (is_version($post->ID))
                                $title_class = 'version-title ';
                            else
                                $title_class = 'post-title'
                            ?>
                            <? echo (the_title(null, null, false) !== null) ? '<h1 class="' . $title_class . 'text-center text-break">' . the_title(null, null, false) . '</h1>' : '' ?>
                            <?php the_content(); // контент ?>
                        </article>
                    <?php endwhile; // конец цикла ?>
                </div>
                <?php !is_front_page() ? get_sidebar() : ''; // подключаем sidebar.php ?>
            </div>
        </div>
    </section>
<?php get_footer(); // подключаем footer.php ?>