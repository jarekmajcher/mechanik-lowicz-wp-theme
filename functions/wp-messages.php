<?php
if (!defined('WPINC')) {
	die;
}

use Timber\Timber;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class Message_List_Table extends WP_List_Table {

	function __construct() {
		global $status, $page;

		parent::__construct([
			'singular' => 'wp_list_text_link',
			'plural'   => 'wp_list_test_links'
		]);
	}

	public function get_forms() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'messages';

		return $wpdb->get_results("SELECT form, COUNT(ID) as count FROM $table_name GROUP BY $table_name.form", ARRAY_A);
	}

	public function get_messages_count() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'messages';

		return $wpdb->get_var("SELECT COUNT(ID) FROM $table_name");
	}

	function column_default($item, $column_name) {
		if(in_array($column_name, ['id', 'email', 'time', 'form'])) {
			return $item[$column_name];
		}
		else {
			$data = json_decode($item['data'], true);
			return $data[$column_name];
		}
	}

	function column_email($item) {
		$data = json_decode($item['data'], true);

		return array_key_exists('email', $data ) ? $data['email'] : '-';
	}

	function get_columns() {
		$columns = [
			'id'    => 'ID',
			'time'  => 'Czas',
			'form'  => 'Formularz',
			'email' => 'Email',
		];

		if(array_key_exists('form', $_GET)) {
			$columns = apply_filters('messages_columns_' . $_GET['form'], $columns);
		}

		return $columns;
	}

	function get_sortable_columns() {
		$sortable_columns = [
			'id' => ['id', true],
			'time' => ['time', false],
			'form' => ['form', false],
			'email' => ['email', false],
		];

		if(array_key_exists('form', $_GET)) {
			$sortable_columns = apply_filters('messages_sortable_columns_' . $_GET['form'], $sortable_columns);
		}

		return $sortable_columns;
	}

	function prepare_items() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'messages';

		$per_page = 500;

		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		if(array_key_exists('form', $_GET)) {
			$total_items = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM $table_name WHERE $table_name.form = %s", $_GET['form']) );
		}
		else {
			$total_items = $wpdb->get_var("SELECT COUNT(ID) FROM $table_name" );
		}

		$paged   = isset( $_REQUEST['paged'] ) ? max( 0, intval( $_REQUEST['paged'] - 1 ) * $per_page ) : 0;
		$orderby = ( isset( $_REQUEST['orderby'] ) && in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns() ) ) ) ? $_REQUEST['orderby'] : 'id';
		$order   = ( isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], array(
				'asc',
				'desc'
			) ) ) ? $_REQUEST['order'] : 'asc';

		if(array_key_exists('form', $_GET)) {
			$this->items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE $table_name.form = %s ORDER BY $orderby $order LIMIT %d OFFSET %d", $_GET['form'], $per_page, $paged ), ARRAY_A );
		}
		else {
			$this->items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged ), ARRAY_A );
		}

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( $total_items / $per_page )
		) );
	}
}

class Theme_Wp_Messages {
	public function __construct() {
		add_action('after_switch_theme', [$this, 'create_table_messages']);
		add_action('admin_menu', [$this, 'messages_admin_menu']);
	}

	/**
	 * Create table
	 */
	public function create_table_messages(){
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$table_name = $wpdb->prefix . 'messages';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
    		id mediumint(9) NOT NULL AUTO_INCREMENT,
    		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  			form varchar(255) NOT NULL,
  			data text NOT NULL,
  			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta($sql);
	}

	/**
	 * Add menu page
	 */
	public function messages_admin_menu() {
		add_menu_page(
			'Wiadomości',
			'Wiadomości',
			'edit_posts',
			'messages',
			[$this, 'messages_page_contents'],
			'dashicons-buddicons-pm',
			59
		);
	}

	/**
	 * Messages page contents
	 */
	public function messages_page_contents() {
		$context = Timber::context();

		$table = new Message_List_Table();
		$table->prepare_items();
		ob_start();
		$table->display();
		$context['table'] = ob_get_clean();
		$context['forms'] = $table->get_forms();
		$context['messages_count'] = $table->get_messages_count();
		$context['current_form'] = array_key_exists('form', $_GET) ? $_GET['form'] : null;

		Timber::render('@admin/messages/table.twig', $context);
	}
}

new Theme_Wp_Messages();



