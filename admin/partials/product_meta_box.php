<?php
/*
 * untitled.php
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
 * The view for the plugin's product meta box. The product meta box is used for
 * entering additional product information (version, file bucket, file name).
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/admin/partials
 */
 
?>
<p>
    <label for="wp_restaurateur_product_version">
        <?php _e( 'Version:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_version"
           name="wp_restaurateur_product_version"
           value="<?php echo esc_attr( $product_meta['version'] ); ?>"
           size="25" >
</p>
<p>
    <label for="wp_restaurateur_product_tested">
        <?php _e( 'Tested with WordPress version:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_tested"
           name="wp_restaurateur_product_tested"
           value="<?php echo esc_attr( $product_meta['tested'] ); ?>"
           size="25" >
</p>
<p>
    <label for="wp_restaurateur_product_requires">
        <?php _e( 'Requires WordPress version:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_requires"
           name="wp_restaurateur_product_requires"
           value="<?php echo esc_attr( $product_meta['requires'] ); ?>"
           size="25" >
</p>
<p>
    <label for="wp_restaurateur_product_updated">
        <?php _e( 'Last updated:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_updated"
           name="wp_restaurateur_product_updated"
           value="<?php echo esc_attr( $product_meta['updated'] ); ?>"
           size="25" >
</p>
 
<p>
    <label for="wp_restaurateur_product_banner_low">
        <?php _e( 'Banner low:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_banner_low"
           name="wp_restaurateur_product_banner_low"
           value="<?php echo esc_attr( $product_meta['banner_low'] ); ?>"
           size="25" >
</p>
 
<p>
    <label for="wp_restaurateur_product_banner_high">
        <?php _e( 'Banner high:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_banner_high"
           name="wp_restaurateur_product_banner_high"
           value="<?php echo esc_attr( $product_meta['banner_high'] ); ?>"
           size="25" >
</p>
 
<h3>Download</h3>
 
<p>
    <label for="wp_restaurateur_product_bucket">
        <?php _e( 'Amazon S3 Bucket:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_bucket"
           name="wp_restaurateur_product_bucket"
           value="<?php echo esc_attr( $product_meta['file_bucket'] ); ?>"
           size="25" />
</p>
<p>
    <label for="wp_restaurateur_product_file_name">
        <?php _e( 'Amazon S3 File Name:', $this->plugin_name ); ?>
    </label>
    <input type="text" id="wp_restaurateur_product_file_name"
           name="wp_restaurateur_product_file_name"
           value="<?php echo esc_attr( $product_meta['file_name'] ); ?>"
           size="25" />
</p>
