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

namespace IgniteKit\WP\DeactivateFeedbackClient\Abstracts;

use IgniteKit\WP\DeactivateFeedbackClient\Configuration;

abstract class AbstractFeedbackData {

	/**
	 * The configuration
	 * @var Configuration
	 */
	protected $configuration;

	/**
	 * The configuration
	 *
	 * @param Configuration $config
	 */
	public function __construct( $config ) {
		$this->configuration = $config;
	}

	/**
	 * Returns abstract feedback data for key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	abstract public function get( $key );

}