<?php
/*
 * settings_page.php
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

?>

<?php
/**
 * The view for the plugin's options page.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/admin/partials
 */
?>
 
<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"></div>
 
    <h2>
        <?php _e( 'Restaurateur Settings', $this->plugin_name ); ?>
    </h2>
 
    <form action='options.php' method='post'>
        <?php
        settings_fields( $settings_group_id );
        do_settings_sections( $settings_group_id );
        submit_button();
        ?>
    </form>
</div>

