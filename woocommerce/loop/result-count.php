<?php
/**
 * Result Count.
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 *
 * @author 		WooThemes
 *
 * @version     3.3.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
            <span class="text-muted woocommerce-result-count">Showing:&nbsp;</span>
            <span>
                <?php
                if ($total <= $per_page || -1 === $per_page) {
                    /* translators: %d: total results */
                    printf(_n('The single result', 'All %d results', $total, 'woocommerce'), $total);
                } else {
                    $first = ($per_page * $current) - $per_page + 1;
                    $last = min($total, $per_page * $current);
                    /* translators: 1: first result 2: last result 3: total results */
                    printf(_nx('The single result', '%1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce'), $first, $last, $total);
                }
                ?>
            </span>
        </div> <!-- End div<class="shop-sorting"> -->
    </div> <!-- End div<class="column" -->

    <div class="column">
        <div class="shop-view">
            <a class="grid-view active" href="shop-grid-ls.html">
                <span></span>
                <span></span>
                <span></span>
            </a>
            <a class="list-view" href="shop-list-ls.html">
                <span></span><span>
                </span><span></span>
            </a>
        </div>
    </div>
    
</div> <!-- End div<class="shop-toolbar padding-bottom-1x mb-2" -->
