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

class Feedback extends AbstractFeedback {

	/**
	 * Adds the required scripts
	 * @return void
	 */
	public function addScripts() {

		if ( ! Utilities::isPluginsPage() ) {
			return;
		}

		if ( ! wp_script_is( 'ignitekit-wpdf', 'registered' ) ) {
			wp_register_script( 'ignitekit-micromodal', $this->configuration->public_url . 'assets/micromodal/micromodal.min.js', [], null, false );
			wp_register_script( 'ignitekit-wpdf', $this->configuration->public_url . 'assets/script.js', [ 'ignitekit-micromodal' ], '1.0.0', true );
			wp_register_style( 'ignitekit-wpdf', $this->configuration->public_url . 'assets/style.css', [], '1.0.0', 'all' );
		}

		wp_enqueue_style( 'ignitekit-wpdf' );
		wp_enqueue_script( 'ignitekit-wpdf' );
		wp_add_inline_script( 'ignitekit-wpdf', 'document.addEventListener("DOMContentLoaded", function(){ new IgniteKitDeactivateFeedback.FormHandler(' . json_encode( $this->configuration->toArray() ) . ') })' );

	}

	/**
	 * Creates modal form view
	 * @return void
	 */
	public function addView() {

		if ( ! Utilities::isPluginsPage() ) {
			return;
		}

		$path = $this->configuration->public_path . 'views/form.php';
		if ( $path ) {
			$configuration = $this->configuration;
			include( $path );
		}

	}

	/**
	 * Handle the feedback submission
	 * @return void
	 */
	public function handleSubmission() {

		if ( ! check_ajax_referer( $this->configuration->getNonceKey(), '_wpnonce', false ) ) {
			wp_send_json_error( [ 'message' => 'Permission denied (1)' ] );
			exit;
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error( [ 'message' => 'Permission denied (2)' ] );
			exit;
		}

		$deactivation_reason = isset( $_POST['deactivation_reason'] ) ? sanitize_text_field( $_POST['deactivation_reason'] ) : '';
		$additional_feedback = isset( $_POST[ $deactivation_reason . '_additional_feedback' ] ) ? sanitize_text_field( $_POST[ $deactivation_reason . '_additional_feedback' ] ) : '';

		$deactivation_reason_title = '';
		foreach($this->configuration->reasons as $value) {
			if($value['id'] === $deactivation_reason) {
				$deactivation_reason_title = $value['title'];
			}
		}

		if ( empty( $deactivation_reason_title ) ) {
			wp_send_json_error( [ 'message' => 'Reason not found' ] );
			exit;
		}

		$feedback = [
			'reason_key'   => $deactivation_reason,
			'reason_title' => $deactivation_reason_title,
			'reason_text'  => $additional_feedback,
			'plugin'       => $this->configuration->slug,
			'version'      => $this->configuration->version,
		];

		foreach ( $this->configuration->data as $key ) {
			if ( isset( $feedback[ $key ] ) ) {
				continue;
			}
			$value = $this->feedbackData->get( $key );
			if ( ! empty( $value ) ) {
				$feedback[ $key ] = $value;
			}
		}

		wp_remote_post( $this->configuration->api_url, wp_parse_args( $this->configuration->http, [
			'body'        => $feedback,
			'blocking'    => false,
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
		] ) );

		wp_send_json_success();

		exit;

	}

	/**
	 * Registers the plugin functionality
	 * @return void
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'addScripts' ] );
		add_action( 'admin_footer', [ $this, 'addView' ], 9999 );
		add_action( 'wp_ajax_' . $this->configuration->prefix . 'deactivate_plugin_feedback', [
			$this,
			'handleSubmission'
		] );
	}

}