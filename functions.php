<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage bitcointheme
 */

add_theme_support('title-tag'); // теперь тайтл управляется самим вп

$menus = array(
    'top' => 'Верхнее', // Верхнее
);

register_nav_menus($menus);

add_theme_support('post-thumbnails'); // включаем поддержку миниатюр
set_post_thumbnail_size(250, 150); // задаем размер миниатюрам 250x150
add_image_size('big-thumb', 400, 400, true); // добавляем еще один размер картинкам 400x400 с обрезкой

register_sidebar(array( // регистрируем бар в меню
    'name' => 'Справа в меню', // Название в админке
    'id' => "sidebar-menu", // идентификатор для вызова в шаблонах
    'description' => 'Для поиска', // Описалово в админке
    'before_widget' => '<div id="search" class="m-auto mr-md-0 ml-lg-auto">', // разметка до вывода каждого виджета
    'after_widget' => "</div>\n", // разметка после вывода каждого виджета
    'before_title' => '<span class="widget-title">', //  разметка до вывода заголовка виджета
    'after_title' => "</span>\n", //  разметка после вывода заголовка виджета
));

register_sidebar(array( // регистрируем правую колонку
    'name' => 'Сайдбар', // Название в админке
    'id' => "sidebar", // идентификатор для вызова в шаблонах
    'description' => 'Обычная колонка в сайдбаре', // Описалово в админке
    'before_widget' => '', // разметка до вывода каждого виджета
    'after_widget' => '', // разметка после вывода каждого виджета
    'before_title' => '<strong class="versions-title">', //  разметка до вывода заголовка виджета
    'after_title' => "</strong>\n", //  разметка после вывода заголовка виджета
));

register_sidebar(array( // регистрируем левую колонку
    'name' => 'Виджет навигации', // Название в админке
    'id' => "sidebar-nav", // идентификатор для вызова в шаблонах
    'description' => 'Для виджета навигации', // Описалово в админке
    'before_widget' => '', // разметка до вывода каждого виджета
    'after_widget' => '', // разметка после вывода каждого виджета
    'before_title' => '<strong class="widget-title">', //  разметка до вывода заголовка виджета
    'after_title' => "</strong>\n", //  разметка после вывода заголовка виджета
));

if (!class_exists('clean_comments_constructor')) { // если класс уже есть в дочерней теме - нам не надо его определять
    class clean_comments_constructor extends Walker_Comment
    { // класс, который собирает всю структуру комментов
        public function start_lvl(&$output, $depth = 0, $args = array())
        { // что выводим перед дочерними комментариями
            $output .= '<ul class="children">' . "\n";
        }

        public function end_lvl(&$output, $depth = 0, $args = array())
        { // что выводим после дочерних комментариев
            $output .= "</ul><!-- .children -->\n";
        }

        protected function comment($comment, $depth, $args)
        { // разметка каждого комментария, без закрывающего </li>!
            $classes = implode(' ', get_comment_class()) . ($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : ''); // берем стандартные классы комментария и если коммент пренадлежит автору поста добавляем класс author-comment
            echo '<li id="comment-' . get_comment_ID() . '" class="' . $classes . ' media">' . "\n"; // родительский тэг комментария с классами выше и уникальным якорным id
            echo '<div class="media-left">' . get_avatar($comment, 64, '', get_comment_author(), array('class' => 'media-object')) . "</div>\n"; // покажем аватар с размером 64х64
            echo '<div class="media-body">';
            echo '<span class="meta media-heading">Автор: ' . get_comment_author() . "\n"; // имя автора коммента
            //echo ' '.get_comment_author_email(); // email автора коммента, плохой тон выводить почту
            echo ' ' . get_comment_author_url(); // url автора коммента
            echo ' Добавлено ' . get_comment_date('F j, Y в H:i') . "\n"; // дата и время комментирования
            if ('0' == $comment->comment_approved) echo '<br><em class="comment-awaiting-moderation">Ваш комментарий будет опубликован после проверки модератором.</em>' . "\n"; // если комментарий должен пройти проверку
            echo "</span>";
            comment_text() . "\n"; // текст коммента
            $reply_link_args = array( // опции ссылки "ответить"
                'depth' => $depth, // текущая вложенность
                'reply_text' => 'Ответить', // текст
                'login_text' => 'Вы должны быть залогинены' // текст если юзер должен залогинеться
            );
            echo get_comment_reply_link(array_merge($args, $reply_link_args)); // выводим ссылку ответить
            echo '</div>' . "\n"; // закрываем див
        }

        public function end_el(&$output, $comment, $depth = 0, $args = array())
        { // конец каждого коммента
            $output .= "</li><!-- #comment-## -->\n";
        }
    }
}


function my_pagination_rewrite() { // Перезапись адреса для поиска
    add_rewrite_rule('page/?([0-9]{1,})/?$', 'index.php?paged=$matches[1]', 'top');
}
add_action('init', 'my_pagination_rewrite');

if (!function_exists('pagination')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function pagination()
    { // функция вывода пагинации
        global $wp_query; // текущая выборка должна быть глобальной
        $big = 999999999; // число для замены
        $links = paginate_links(array( // вывод пагинации с опциями ниже
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
            'format' => 'page/%#%/', // формат, %#% будет заменено
            'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
            'type' => 'array', // нам надо получить массив
            'prev_text' => 'Back', // текст назад
            'next_text' => 'Next', // текст вперед
            'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
            'show_all' => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
            'end_size' => 2, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
            'mid_size' => 2, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
            'add_args' => false, // массив GET параметров для добавления в ссылку страницы
            'add_fragment' => '',    // строка для добавления в конец ссылки на страницу
            'before_page_number' => '', // строка перед цифрой
            'after_page_number' => '' // строка после цифры
        ));
        if (is_array($links)) { // если пагинация есть
            echo '<nav class="m-4"><ul class="pagination justify-content-center">';
            foreach ($links as $link) {
                $link = str_replace('page-numbers', 'page-link', $link);
                if (strpos($link, 'current') !== false) echo "<li class='active page-item'>$link</li>"; // если это активная страница
                else echo "<li class='page-item'>$link</li>";
            }
            echo '</ul></nav>';
        }
    }
}

add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_scripts()
    { // добавление скриптов
        if (is_admin()) return false; // если мы в админке - ничего не делаем
        wp_deregister_script('jquery'); // выключаем стандартный jquery
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '', '', true); // добавляем свой
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', '', '', true); // бутстрап
        wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', '', filemtime(get_theme_file_path('js/main.js')), true); // и скрипты шаблона
    }
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_styles()
    { // добавление стилей
        if (is_admin()) return false; // если мы в админке - ничего не делаем
        wp_enqueue_style('bs', get_template_directory_uri() . '/css/bootstrap.min.css'); // бутстрап
        wp_enqueue_style('main', get_template_directory_uri() . '/style.css', '', filemtime(get_theme_file_path('style.css'))); // основные стили шаблона
        wp_enqueue_style('dashicons');
    }
}

if (!class_exists('bootstrap_menu')) {
    class bootstrap_menu extends Walker_Nav_Menu
    { // внутри вывод
        private $open_submenu_on_hover; // параметр который будет определять раскрывать субменю при наведении или оставить по клику как в стандартном бутстрапе

        function __construct($open_submenu_on_hover = true)
        { // в конструкторе
            $this->open_submenu_on_hover = $open_submenu_on_hover; // запишем параметр раскрывания субменю
            add_filter('nav_menu_link_attributes', array($this, 'filter_nav_menu_link_attributes'), 10, 4);
        }

        function filter_nav_menu_link_attributes($atts, $item, $args, $depth)
        {
            $atts['class'] .= 'nav-link';
            return $atts;
        }

        function start_lvl(&$output, $depth = 0, $args = array())
        { // старт вывода подменюшек
            $output .= "\n<ul class=\"dropdown-menu\">\n"; // ул с классом
        }

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        { // старт вывода элементов

            $item_html = ''; // то что будет добавлять
            parent::start_el($item_html, $item, $depth, $args); // вызываем стандартный метод родителя
            if ($item->is_dropdown && $depth === 0) { // если элемент содержит подменю и это элемент первого уровня
                if (!$this->open_submenu_on_hover) $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"', $item_html); // если подменю не будет раскрывать при наведении надо добавить стандартные атрибуты бутстрапа для раскрытия по клику
                $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html); // ну это стрелочка вниз
            }
            $output .= $item_html; // приклеиваем теперь
        }

        function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
        { // вывод элемента
            if ($element->current)
                $element->classes[] = 'active'; // если элемент активный надо добавить бутстрап класс для подсветки
            $element->is_dropdown = !empty($children_elements[$element->ID]); // если у элемента подменю
            if ($element->is_dropdown) { // если да
                if ($depth === 0) { // если li содержит субменю 1 уровня
                    $element->classes[] = 'dropdown'; // то добавим этот класс
                    if ($this->open_submenu_on_hover) $element->classes[] = 'show-on-hover'; // если нужно показывать субменю по хуверу
                } elseif ($depth === 1) { // если li содержит субменю 2 уровня
                    $element->classes[] = 'dropdown-submenu'; // то добавим этот класс, стандартный бутстрап не поддерживает подменю больше 2 уровня по этому эту ситуацию надо будет разрешать отдельно
                }
            } else {
                $element->classes[] = 'nav-item';
            }
            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); // вызываем стандартный метод родителя
        }
    }
}

function is_blockchain()
{
    global $post;
    $id = $post->ID;
    if (get_post_meta($id, 'btc_page_type', true) === 'blockchain')
        return true;
    return false;
}

function is_version()
{
    global $post;
    $id = $post->ID;
    if (get_post_meta($id, 'btc_page_type', true) === 'version')
        return true;
    return false;
}

function is_method()
{
    global $post;
    $id = $post->ID;
    if (get_post_meta($id, 'btc_page_type', true) === 'method')
        return true;
    return false;
}

if (!function_exists('content_class_by_sidebar')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function content_class_by_sidebar()
    { // функция для вывода класса в зависимости от существования виджетов в сайдбаре
        $is_method_or_version_page = is_version() || is_method();
        if (is_active_sidebar('sidebar') && $is_method_or_version_page) { // если есть
            echo 'col-12 col-md'; // пишем класс на 80% ширины
        } else { // если нет
            echo 'col-12'; // контент на всю ширину
        }
    }
}

if (!function_exists('breadcrumbs')) {
    get_template_part('breadcrumbs');
}

add_action('pre_get_posts', 'search_filter'); // убираем из поиска версии
function search_filter($query)
{
    if (!is_admin()) {
        if ($query->is_search) {
            $query->set('meta_query', array(array(
                'key' => 'btc_page_type',
                'value' => 'version',
                'compare' => '!='
            )));
        }
    }
}

// Отключаем jquery-migrate
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

// Убираем с тега body классы
add_filter('body_class', 'my_class_names');
function my_class_names($classes)
{
    return array();
}

function has_items_in_nav_menu($location)
{
    $locations = get_nav_menu_locations();
    $top_menu = wp_get_nav_menu_object($locations[$location]);
    if (isset($top_menu))
        return $top_menu->count;
    else
        return 0;
}

?>
