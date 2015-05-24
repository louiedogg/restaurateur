<?php
/*
 * class-restaurateur-S3.php
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
 * A wrapper for our Amazon S3 API actions.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/includes
 * @author     Jarkko Laine <jarkko@jarkkolaine.com>
 */
class Wp_License_Manager_S3 {
	
	/**
	 * Returns a signed Amazon S3 download URL.
	 *
	 * @param $bucket       string  Bucket name
	 * @param $file_name    string  File name (URI)
	 * @return string       The signed download URL
	 */
	public static function get_s3_url( $bucket, $file_name ) {
		$options = get_option( 'restaurateur-settings' );
	 
		$s3_client = Aws\S3\S3Client::factory(
			array(
				'key'    => $options['aws_key'],
				'secret' => $options['aws_secret']
			)
		);
	 
		return $s3_client->getObjectUrl( $bucket, $file_name, '+10 minutes' );
	}
 
}



?>

