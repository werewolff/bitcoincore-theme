<?php
/**
 * Запись в цикле (loop.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
?>

<article class="m-3" id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
    <h3><a href="<?php the_permalink(); ?>" class="text-break"><?php
            $meta_title = get_post_meta($post->ID, '_aioseop_title', true);
            if (!empty($meta_title)) {
                echo $meta_title;
            } else {
                the_title();
            } ?></a></h3> <?php // заголовок поста и ссылка на его полное отображение (single.php) ?>
    <div class="row">
        <?php if (has_post_thumbnail()) { ?>
            <div class="col-sm-3">
                <a href="<?php the_permalink(); ?>" class="thumbnail">
                    <?php the_post_thumbnail(); ?>
                </a>
            </div>
        <?php } ?>
        <div class="<?php if (has_post_thumbnail()) { ?>col-sm-9 text-break<?php } else { ?>col-sm-12 text-break<?php } // разные классы в зависимости есть ли миниатюра ?>">
            <?php
            $content = get_the_content();
            $content = wp_filter_nohtml_kses($content);
            if (strlen($content) > 150) {
                $content = substr($content, 0, 150) . '...';
            }
            if (!is_blockchain()) {
                $content = apply_filters('the_content', $content);
                echo $content;
            }
            ?>
        </div>
    </div>
</article>