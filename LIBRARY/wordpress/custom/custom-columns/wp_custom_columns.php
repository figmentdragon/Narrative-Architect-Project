<?php

class WordPressColumn {

	/**
	 * Default definitions
	 * @var array
	 */
	public $defaults = array(
		'post_type' => 'post',
		'column_key' => '',
		'column_title' => '',
		'column_display' => 'column_key'
		);

	/**
	 * Container of our options for the column
	 * @var array
	 */
	public $options = array();

	/**
	 * Merge added options with the defaults. If the column key is not defined throw and exception.
	 * If we do not have a title for the column, create one from the column key
	 * @param array $options 
	 */
	public function __construct( $options ){

		$this->options = array_merge( $this->defaults, $options );

		if( $this->options['column_key'] == '' ){
			$message = __( 'Column key is not defined', 'yourtextdomain' );
			throw new Exception( $message );
		}

		if( $this->options['column_title'] == '' ) {
			$this->options['column_title'] = ucfirst( $this->options['column_key'] );
		}
	}

	/**
	 * Attach this column by using WordPress filters and actions
	 * If the post type is different from 'post' and 'page' then add a new word to filters and actions to dynamically target our columns
	 * If the post type is a page, then change the for_type variable so that the column is added to the pages section
	 * @return void 
	 */
	public function attach() {
		$post_type = '';
		if( $this->options['post_type'] != 'post' && $this->options['post_type'] != 'page'   ){
			$post_type = '_' . $this->options['post_type'];
		}

		$for_type = 'posts';
		if( $this->options['post_type'] == 'page' ) {
			$for_type = 'pages';
		}
		add_filter('manage' . $post_type . '_' . $for_type . '_columns' , array( $this, 'add_column' ) );

		add_action( 'manage' . $post_type . '_' . $for_type . '_custom_column', array( $this, 'column_data' ), 10, 2);

	}

	/**
	 * Add the column to the columns array
	 * @param array $columns
	 */
	public function add_column( $columns ) {
		$columns[ $this->options['column_key'] ] = $this->options['column_title'];
		return $columns;
	}

	/**
	 * Render a column
	 * @param  string $column  Column slug/key
	 * @param  string $post_id 
	 * @return void      
	 */
	public function column_data( $column, $post_id ){

		if( $column == $this->options['column_key'] ){
			if( $this->options['column_display'] == 'column_key' ){
				echo get_post_meta( $post_id, $this->options['column_key'], true );
			} else {
				$function_name = $this->options['column_display'];
				call_user_func_array($function_name, array( $post_id, $this->options['column_key'] ) );
			}
		}
	}

}

class WordPressColumns {

	public $columns = array();

	public function __construct( $columns ) {
		$this->columns = $columns;
	}

	public function add_columns() {
		foreach ( $this->columns as $column ) {

			$the_column = new WordPressColumn( $column );
			$the_column->attach();
		}
	}


}
