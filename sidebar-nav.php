<?php

if (is_active_sidebar('sidebar-nav')) { // если в сайдбаре есть что выводить
    dynamic_sidebar('sidebar-nav'); // выводим сайдбар, имя определено в functions.php
}
