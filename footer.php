<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage bitcointheme
 */
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col text-center align-self-center mb-sm-0 mb-4">
                <span><? echo get_bloginfo('name') ?> © 2020</span>
            </div>
            <div class="col-sm-auto text-center order-first order-sm-2 footer-donate">
                <h5>Donate</h5>
                <div>
                    <div>
                        <? include(get_template_directory() . '/img/btc.svg') ?>
                        <p class="text-break">18e5aXfp2gBny56fM5ZqddYgYbZfwZebsu</p>
                    </div>
                    <div>
                        <? include(get_template_directory() . '/img/btccash.svg') ?>
                        <p class="text-break">qrr4nl9x2hrel637wqz0fz2u7pl082z4zsss6872rr</p>
                    </div>
                    <div>
                        <? include(get_template_directory() . '/img/ethereum.svg') ?>
                        <p class="text-break">0x7F239Ff79c3151b29461A608F95ecfD4F994956E</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>