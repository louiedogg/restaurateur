<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    restaurateur
 * @subpackage restaurateur/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    restaurateur
 * @subpackage restaurateur/includes
 * @author     Lou admin@louiedogg.com
 */
 
 /** This was added by admin@louiedogg.com **/
 
 /**
 * The database version number. Update this every time you make a change to the database structure.
 *
 * @access   protected
 * @var      string    $db_version   The database version number
 */
 
protected static $db_version = 1;

/** */

class restaurateur_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		/** This was added by admin@louiedogg.com **/
		
		// Update database if db version has increased
		$current_db_version = get_option( 'restaurateur-db-version' );
		if ( ! $current_db_version ) {
			$current_db_version = 0;
		}
	 
		if ( intval( $current_db_version ) < restaurateur_Activator::$db_version ) {
			if ( restaurateur_Activator::create_or_upgrade_db() ) {
				update_option( 'restaurateur-db-version', restaurateur_Activator::$db_version );
			}
		}
			
	}
		
		
	/**
	 * Creates the database tables required for the plugin if
	 * they don't exist. Otherwise updates them as needed.
	 *
	 * @return bool true if update was successful.
	 */
	private static function create_or_upgrade_db() {
		global $wpdb;
	 
		$table_name = $wpdb->prefix . 'product_licenses';
			 
		$charset_collate = '';
		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE {$wpdb->collate}";
		}
	 
		$sql = "CREATE TABLE " . $table_name . "("
			 . "id mediumint(9) NOT NULL AUTO_INCREMENT, "
			 . "product_id mediumint(9) DEFAULT 0 NOT NULL,"
			 . "license_key varchar(48) NOT NULL, "
			 . "email varchar(48) NOT NULL, "
			 . "valid_until datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, "
			 . "created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, "
			 . "updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, "
			 . "UNIQUE KEY id (id)"
			 . ")" . $charset_collate. ";";
	 
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	 
		return true;
	}

}
