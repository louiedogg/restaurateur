<?php
/*
 * class-licenses-list-table.php
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

/** This was added by admin@louiedogg.com **/

class Licenses_List_Table extends restaurateur_List_Table {
 
    /**
    * The plugin's text domain.
    *
    * @access  private
    * @var     string  The plugin's text domain. Used for localization.
    */
    private $text_domain;
 
    /**
     * Initializes the WP_List_Table implementation.
     *
     * @param $text_domain  string  The text domain used for localizing the plugin.
     */
    public function __construct( $text_domain ) {
        parent::__construct();
 
        $this->text_domain = $text_domain;
    }
	
	/** This was added by admin@louiedogg.com **/
	
	/**
	 * Defines the database columns shown in the table and a
	 * header for each column. The order of the columns in the
	 * table define the order in which they are rendered in the list table.
	 *
	 * @return array    The database columns and their headers for the table.
	 */
	public function get_columns() {
		return array(
			'license_key' => __( 'License Key', $this->text_domain ),
			'email'       => __( 'Email', $this->text_domain ),
			'product_id'  => __( 'Product', $this->text_domain ),
			'valid_until' => __( 'Valid Until', $this->text_domain ),
			'created_at'  => __( 'Created', $this->text_domain )
		);
	}
	
	/**
	 * Returns the names of columns that should be hidden from the list table.
	 *
	 * @return array    The database columns that should not be shown in the table.
	 */
	public function get_hidden_columns() {
		return array( 'created_at' );
	}
	
	/**
	 * Returns the columns that can be used for sorting the list table data.
	 *
	 * @return array    The database columns that can be used for sorting the table.
	 */
	public function get_sortable_columns() {
		return array(
			'email' => array( 'email', false ),
			'valid_until' => array( 'valid_until', false )
		);
	}
	
	/**
	 * Default rendering for table columns.
	 *
	 * @param $item         array   The database row being printed out.
	 * @param $column_name  string  The column currently processed.
	 * @return string       The text or HTML that should be shown for the column.
	 */
	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'email':
			case 'created_at':
				return $item[$column_name];
	 
			default:
				break;
		}
	 
		return '';
	}
	/**
	 * Custom renderer for the valid_until field.
	 *
	 * @param $item     array   The database row being printed out.
	 * @return string   The text or HTML that should be shown for the column.
	 */
	function column_valid_until( $item ) {
		$valid_until = $item['valid_until'];
	 
		if ($valid_until == '0000-00-00 00:00:00') {
			return __( 'Forever', $this->text_domain );
		}
	 
		return $valid_until;
	}



}

?>

