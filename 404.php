<?php
/**
 * Страница 404 ошибки (404.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
get_header(); // Подключаем header.php ?>
<section>
	<div class="container">
		<div class="row">
			<div class="d-flex align-items-center justify-content-center <?php content_class_by_sidebar(); // функция подставит класс в зависимости от того есть ли сайдбар, лежит в functions.php ?>">
				<h1>Page not found</h1>
			</div>
			<?php get_sidebar(); // подключаем sidebar.php ?>
		</div>
	</div>
</section>
<?php get_footer(); // подключаем footer.php ?>