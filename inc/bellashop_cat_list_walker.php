<?php

include_once WC()->plugin_path().'/includes/walkers/class-wc-product-cat-list-walker.php';

class Bellashop_cat_list_walker extends WC_Product_Cat_List_Walker
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   will only append content if style argument value is 'list'
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        if ('list' !== $args['style']) {
            return;
        }

        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='children'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   will only append content if style argument value is 'list'
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        if ('list' !== $args['style']) {
            return;
        }

        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string $output            Passed by reference. Used to append additional content.
     * @param object $cat               category
     * @param int    $depth             depth of category in reference to parents
     * @param array  $args              arguments
     * @param int    $current_object_id current object ID
     */
    public function start_el(&$output, $cat, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $cat_id = intval($cat->term_id);

        $output .= '<li class="cat-item cat-item-'.$cat_id;

        if ($args['current_category'] === $cat_id) {
            $output .= ' current-cat';
        }

        if ($args['has_children'] && $args['hierarchical'] && (empty($args['max_depth']) || $args['max_depth'] > $depth + 1)) {
            $output .= ' has-children expanded cat-parent';
        }

        if ($args['current_category_ancestors'] && $args['current_category'] && in_array($cat_id, $args['current_category_ancestors'], true)) {
            $output .= ' current-cat-parent';
        }

        $output .= '"><a href="'.get_term_link($cat_id, $this->tree_type).'">'.apply_filters('list_product_cats', $cat->name, $cat).'</a>';

        if ($args['show_count']) {
            $output .= ' <span class="count">('.$cat->count.')</span>';
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $cat    category
     * @param int    $depth  Depth of category. Not used.
     * @param array  $args   only uses 'list' for whether should append to output
     */
    public function end_el(&$output, $cat, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max.
     * depth and no ignore elements under that depth. It is possible to set the.
     * max depth to include all depths, see walk() method.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @since 2.5.0
     *
     * @param object $element           data object
     * @param array  $children_elements list of elements to continue traversing
     * @param int    $max_depth         max depth to traverse
     * @param int    $depth             depth of current element
     * @param array  $args              arguments
     * @param string $output            Passed by reference. Used to append additional content.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        if (!$element || (0 === $element->count && !empty($args[0]['hide_empty']))) {
            return;
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
