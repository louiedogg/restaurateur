<?php
/*
 * WP_List_Table_add_on.php
 *  Do I parse this?
 * 
 * 
 * 
 * Copyright 2015 Louiedogg <admin@louiedogg.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */



/**
 * Populates the class fields for displaying the list of licenses.
 */
public function prepare_items() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'product_licenses';
 
    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();
 
    $this->_column_headers = array( $columns, $hidden, $sortable );
 
    // Pagination
    $licenses_per_page = 20;
    $total_items = $wpdb->get_var( "SELECT COUNT(id) FROM $table_name" );
 
    $offset = 0;
    if ( isset( $_REQUEST['paged'] ) ) {
        $page = max( 0, intval( $_REQUEST['paged'] ) - 1 );
        $offset = $page * $licenses_per_page;
    }
 
    $this->set_pagination_args(
        array(
            'total_items' => $total_items,
            'per_page' => $licenses_per_page,
            'total_pages' => ceil( $total_items / $licenses_per_page )
        )
    );
 
    // Sorting
    $order_by = 'email'; // Default sort key
    if ( isset( $_REQUEST['orderby'] ) ) {
        // If the requested sort key is a valid column, use it for sorting
        if ( in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns() ) ) ) {
            $order_by = $_REQUEST['orderby'];
        }
    }
 
    $order = 'asc'; // Default sort order
    if ( isset( $_REQUEST['order'] ) ) {
        if ( in_array( $_REQUEST['order'], array( 'asc', 'desc' ) ) ) {
            $order = $_REQUEST['order'];
        }
    }
 
    // Do the SQL query and populate items
    $this->items = $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM $table_name ORDER BY $order_by $order LIMIT %d OFFSET %d", $licenses_per_page, $offset ),
        ARRAY_A );
}

?>
