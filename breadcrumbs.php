<?php

function breadcrumbs()
{
    if (is_front_page()) {
        return;
    }
    $separator = '';
    $path = array_filter(explode('/', parse_url(urldecode($_SERVER['REQUEST_URI']), PHP_URL_PATH)));
    $base_url = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $breadcrumbs = array("<li><a href=\"$base_url\"><span class=\"dashicons dashicons-admin-home\"></span></a></li>");

    $last = end(array_keys($path));

    if (is_search()) {
        $breadcrumbs[] = '<li>Search</li>';
    } elseif (is_404()) {
        $breadcrumbs[] = '<li>404</li>';
    } else {
        foreach ($path as $x => $crumb) {
            $title = ucwords(str_replace(array('.php', '_'), Array('', ' '), $crumb));
            if ($x != $last) {
                $breadcrumbs[] = '<li><a href="' . $base_url . $crumb . '">' . $title . '</a></li>';
            } else {
                $breadcrumbs[] = '<li>' . $title . '</li>';
            }
        }
    }
    $breadcrumb_list = implode($separator, $breadcrumbs);
    $breadcrumb_block = '<div class="row"> 
                            <div class="col-12 p-0">
                                <nav class="breadcrumbs">
                                    <ul>' . $breadcrumb_list . '</ul>
                                </nav>
                            </div>
                        </div>';
    echo $breadcrumb_block;
}