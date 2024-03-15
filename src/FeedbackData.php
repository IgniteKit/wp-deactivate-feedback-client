<?php
/**
 * Copyright (C) 2024  Darko Gjorgjijoski. All Rights Reserved.
 * Copyright (C) 2024  IDEOLOGIX MEDIA DOOEL. All Rights Reserved.
 * Copyright (C) 2024  IgniteKit. All Rights Reserved.
 *
 * WP Deactivate Feedback is free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * WP Deactivate Feedback program is distributed in the hope that it
 * will be useful,but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License v3
 * along with this program;
 *
 * If not, see: https://www.gnu.org/licenses/gpl-2.0.en.html
 *
 * Code written, maintained by Darko Gjorgjijoski (https://darkog.com)
 */

namespace IgniteKit\WP\DeactivateFeedbackClient;

use IgniteKit\WP\DeactivateFeedbackClient\Abstracts\AbstractFeedbackData;

class FeedbackData extends AbstractFeedbackData {

	/**
	 * Returns abstract feedback data for key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get( $key ) {
		switch ( $key ) {
			case 'website':
				global $wp_version;

				return [
					'version'  => $wp_version,
					'language' => get_locale(),
					'url'      => home_url(),
				];
			case 'system':
				return [
					'os'  => PHP_OS,
					'php' => PHP_VERSION,
				];
			case 'contact':
				$user = wp_get_current_user();

				return [
					'website' => get_option( 'admin_email' ),
					'user'    => ! empty( $user->user_email ) ? $user->user_email : '',
				];
			default:
				return false;
		}
	}
}