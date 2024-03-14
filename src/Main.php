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
 * If not, see: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Code written, maintained by Darko Gjorgjijoski (https://darkog.com)
 */

namespace IgniteKit\WP\DeactivateFeedbackClient;

use IgniteKit\WP\DeactivateFeedbackClient\Abstracts\AbstractFeedback;
use IgniteKit\WP\DeactivateFeedbackClient\Abstracts\AbstractFeedbackData;

class Main {

	/**
	 * The configuration
	 * @var Configuration
	 */
	protected $config;

	/**
	 * The feedback interface
	 * @var AbstractFeedback
	 */
	protected $feedback;

	/**
	 * Configuration
	 *
	 * @param array $config
	 *
	 * @throws \Exception
	 */
	public function __construct( $config = [] ) {

		$this->config = new Configuration( $config );

		if ( isset( $config['feedback'] ) && $config['feedback'] instanceof AbstractFeedback ) {
			$this->feedback = $config['feedback'];
		} else {
			$feedbackData = isset( $config['feedbackData'] ) && $config['feedbackData'] instanceof AbstractFeedbackData ? $config['feedback'] : new FeedbackData( $this->config );
			$this->feedback = new Feedback( $this->config, $feedbackData );
		}
	}

}