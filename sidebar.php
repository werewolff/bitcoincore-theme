<?php
/**
 * Шаблон сайдбара (sidebar.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
?>
<?php if (is_active_sidebar( 'sidebar' )) { // если в сайдбаре есть что выводить ?>
<aside class="col-12 col-md-3 col-xl-2 border-left my-3">
	<?php dynamic_sidebar('sidebar'); // выводим сайдбар, имя определено в functions.php ?>
</aside>
<?php } ?>