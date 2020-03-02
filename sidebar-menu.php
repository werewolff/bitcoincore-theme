<?php

if (is_active_sidebar('sidebar-menu')) { // если в сайдбаре есть что выводить
    dynamic_sidebar('sidebar-menu'); // выводим сайдбар, имя определено в functions.php
}
