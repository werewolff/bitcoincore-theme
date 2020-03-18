<?php
/**
 * Шаблон поиска (search.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
get_header(); // подключаем header.php ?>
    <section>
        <div class="container-fluid bg-white rounded">
            <div class="row h-100">
                <div id="menu-left" class="col col-md-4 col-lg-3 ml-n3 d-md-block">
                    <?php get_sidebar('nav'); ?>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="<?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
                            <h1><?php printf('Search: %s', get_search_query()); // заголовок поиска ?></h1>
                            <?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
                                <?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
                            <?php endwhile; // конец цикла
                            else: echo '<p>Nothing found</p>'; endif; // если записей нет?>
                            <?php pagination(); // пагинация, функция нах-ся в function.php ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); // подключаем footer.php ?>