<?php
/*
 * licenses_list.php
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
 * Renders the list of licenses menu page using the "licenses_list.php" partial.
 */
	public function render_licenses_menu_list() {
		$list_table = new Licenses_List_Table( $this->plugin_name );
		$list_table->prepare_items();
	 
		require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/licenses_list.php';
	} 

?>

