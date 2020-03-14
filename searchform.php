<?php
/**
 * Шаблон формы поиска (searchform.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
?>
<form role="search" class="search-form form-inline my-2 my-lg-0 ml-auto"
      action="<?php echo home_url('/'); ?>">
    <input type="search" id="search-field" placeholder="Search"
           value="<?php echo get_search_query() ?>" name="s">
    <button></button>
</form>