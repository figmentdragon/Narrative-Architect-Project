<?php
/**
 * Builds filterable classes throughout the theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'creativityarchitect_right_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_right_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_right_sidebar_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_right_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_right_sidebar_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_right_sidebar_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_left_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_left_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_left_sidebar_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_left_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_left_sidebar_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_left_sidebar_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_content_class' ) ) {
	/**
	 * Display the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_content_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_content_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_content_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_content_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_content_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_header_class' ) ) {
	/**
	 * Display the classes for the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_header_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_header_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_header_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_header_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_inside_header_class' ) ) {
	/**
	 * Display the classes for inside the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_inside_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_inside_header_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_inside_header_class' ) ) {
	/**
	 * Retrieve the classes for inside the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_inside_header_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_inside_header_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_container_class' ) ) {
	/**
	 * Display the classes for the container.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_container_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_container_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_container_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_container_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_container_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_navigation_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_navigation_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_navigation_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_navigation_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_navigation_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_navigation_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_inside_navigation_class' ) ) {
	/**
	 * Display the classes for the inner navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_inside_navigation_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters('creativityarchitect_inside_navigation_class', $classes, $class);

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_menu_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_menu_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_menu_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_menu_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_menu_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_menu_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_main_class' ) ) {
	/**
	 * Display the classes for the <main> container.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_main_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_main_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_main_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_main_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_main_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_footer_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', creativityarchitect_get_footer_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_get_footer_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function creativityarchitect_get_footer_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('creativityarchitect_footer_class', $classes, $class);
	}
}

if ( ! function_exists( 'creativityarchitect_inside_footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_inside_footer_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters( 'creativityarchitect_inside_footer_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}

if ( ! function_exists( 'creativityarchitect_top_bar_class' ) ) {
	/**
	 * Display the classes for the top bar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function creativityarchitect_top_bar_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters( 'creativityarchitect_top_bar_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}
