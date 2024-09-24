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

class Configuration {

	public $name;
	public $slug;
	public $version;
	public $prefix;
	public $context;
	public $public_path;
	public $public_url;
	public $api_url;
	public $reasons;
	public $data;
	public $http;

	public $i18n;

	/**
	 * Constructor
	 *
	 * @param $config
	 *
	 * @throws \Exception
	 */
	public function __construct( $config ) {

		$i18n_custom = ! empty( $config['i18n'] ) && is_array( $config['i18n'] ) ? $config['i18n'] : [];

		$this->i18n = wp_parse_args( $i18n_custom, [
			'form_title'                      => 'Quick Feedback',
			'form_close_label'                => 'Close modal',
			'form_description'                => 'If you have a moment, please share why you are deactivating <strong>%s</strong>:',
			'button_skip_deactivate'          => 'Skip & Deactivate',
			'button_submit_deactivate'        => 'Submit & Deactivate',
			'reason_temporary_deactivation'   => 'It\'s a temporary deactivation',
			'reason_found_better_plugin'      => 'I found a better plugin',
			'reason_found_better_plugin_text' => 'Please share which plugin',
			'reason_no_longer_needed'         => 'I no longer need the plugin',
			'reason_does_not_work'            => 'I couldn\'t get the plugin to work',
			'reason_does_not_work_text'       => 'Please share more details about the issue',
			'reason_other'                    => 'Other',
			'reason_other_text'               => 'Please share the reason',
		] );

		$this->name        = $this->getOrFail( $config, 'name' );
		$this->slug        = $this->getOrFail( $config, 'slug' );
		$this->version     = $this->getOrFail( $config, 'version' );
		$this->prefix      = $this->getOrFail( $config, 'prefix' );
		$this->context     = $this->getOptional( $config, 'context', 'plugin' );
		$this->public_path = $this->getOrFail( $config, 'public_path' );
		$this->public_url  = $this->getOrFail( $config, 'public_url' );
		$this->api_url     = $this->getOrFail( $config, 'api_url' );
		$this->reasons     = $this->getOptional( $config, 'reasons', $this->getDefaultReasons() );
		$this->data        = $this->getOptional( $config, 'data', [ 'language' ] );
		$this->http        = $this->getOptional( $config, 'http', [] );

	}

	/**
	 * Extracts parameter or throws missing exception.
	 *
	 * @param $config
	 * @param $key
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	private function getOrFail( $config, $key ) {
		if ( empty( $config[ $key ] ) ) {
			throw new \Exception( sprintf( 'WP Deactivate Feedback: Config option %s is missing.', $key ) );
		}

		return $config[ $key ];
	}

	/**
	 * Optional setting
	 *
	 * @param $config
	 * @param $key
	 * @param $optional
	 *
	 * @return mixed|string
	 */
	private function getOptional( $config, $key, $optional = '' ) {
		return isset( $config[ $key ] ) ? $config[ $key ] : $optional;
	}


	/**
	 * The JS configuration
	 * @return array
	 */
	public function toArray() {
		return [
			'name'    => $this->name,
			'slug'    => $this->slug,
			'prefix'  => $this->prefix,
			'context' => $this->context,
			'api_url' => $this->api_url,
		];
	}

	/**
	 * Returns the nonce key
	 * @return string
	 */
	public function getNonceKey() {
		return $this->getId();
	}

	/**
	 * Unique identifier of the plugin
	 * @return string
	 */
	public function getId() {
		return sprintf( '%sdeactivate_feedback', $this->prefix );
	}

	/**
	 * Returns the default reasons
	 * @return array
	 */
	public function getDefaultReasons() {
		return [
			[
				'id'    => 'temporary_deactivation',
				'title' => $this->i18n['reason_temporary_deactivation'],
			],
			[
				'id'    => 'found_better_plugin',
				'title' => $this->i18n['reason_found_better_plugin'],
				'text'  => [
					'enabled'     => true,
					'placeholder' => $this->i18n['reason_found_better_plugin_text'],
				],
			],
			[
				'id'    => 'no_longer_needed',
				'title' => $this->i18n['reason_no_longer_needed'],
			],
			[
				'id'    => 'does_not_work',
				'title' => $this->i18n['reason_does_not_work'],
				'text'  => [
					'enabled'     => true,
					'placeholder' => $this->i18n['reason_does_not_work_text'],
				],
			],
			[
				'id'    => 'other',
				'title' => $this->i18n['reason_other'],
				'text'  => [
					'enabled'     => true,
					'placeholder' => $this->i18n['reason_other_text'],
				],
			],
		];
	}


	/**
	 * The translated text
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getTranslated( $key ) {
		return isset( $this->i18n[ $key ] ) ? $this->i18n[ $key ] : $key;
	}

}