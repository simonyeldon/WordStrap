<?php

class Wordstrap_Menu_Walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		
		if( !element ) {
			return;
		}

		$id_field = $this->db_fields['id'];

		if( is_array( $args[0] ) ) {
			$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
		}

		if( !empty($children_elements[$element->$id_field]) && ($max_depth == 0 || $max_depth > $depth+1 ) ) {
			array_push($element->classes, 'dropdown');
		}

		if( in_array('current-menu-item', $element->classes) || in_array('current-menu-ancestor', $element->classes) ) {
			array_push($element->classes, 'active');
		}

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[$id] as $child ) {

				if( !isset( $newlevel ) ) {
					$newlevel = true;
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if( isset( $newlevel ) && $newlevel ) {
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		//var_dump($output);
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		if($item->url == "##seperator##" && $item->title == "##seperator##") {
			$class_names = " class=\"divider-vertical\" ";
			$id = "";
			$value = "";
			$seperator = true;
		}

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if( in_array('dropdown', $item->classes) ) {
			$attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
		}
		if( !$seperator ) {
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if( in_array( 'dropdown', $item->classes ) ) { $item_output .= '<b class="caret"></b>';	}
			$item_output .= '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}
