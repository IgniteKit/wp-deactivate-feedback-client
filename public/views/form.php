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


/* @var \IgniteKit\WP\DeactivateFeedbackClient\Configuration $configuration */

$id  = $configuration->getId();
$url = add_query_arg( [
	'action'   => $configuration->prefix . 'deactivate_plugin_feedback',
	'_wpnonce' => wp_create_nonce( $configuration->getNonceKey() ),
], admin_url( 'admin-ajax.php' ) );

?>

<div class="iwpdf-modal micromodal-slide" id="<?php echo esc_attr( $id ); ?>" aria-hidden="true">
    <div class="iwpdf-modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="iwpdf-modal__container" role="dialog" aria-modal="true" aria-labelledby="<?php esc_attr_e( $id ); ?>--title">
            <header class="iwpdf-modal__header">
                <h2 class="iwpdf-modal__title" id="<?php esc_attr_e( $id ); ?>--title">
					<?php echo sprintf( $configuration->getTranslated( 'form_title' ) ); ?>
                </h2>
                <button class="iwpdf-modal__close" aria-label="<?php echo esc_attr( $configuration->getTranslated( 'form_close_label' ) ); ?>" data-micromodal-close></button>
            </header>
            <form method="POST" action="<?php echo esc_url( $url ); ?>" id="<?php esc_attr_e( $id ); ?>--form">
                <main class="iwpdf-modal__content" id="<?php esc_attr_e( $id ); ?>--content">
                    <p class="iwpdf-modal__content-intro">
						<?php echo sprintf( $configuration->getTranslated( 'form_description' ), $configuration->name ); ?>
                    </p>
                    <div class="iwpdf-form">
	                    <?php foreach ( $configuration->reasons as $reason ): ?>
		                    <?php
		                    $has_text    = isset( $reason['text']['enabled'] ) && $reason['text']['enabled'];
		                    $placeholder = isset( $reason['text']['placeholder'] ) ? $reason['text']['placeholder'] : '';
		                    ?>
                            <div class="iwpdf-form-row <?php echo $has_text ? 'iwpdf--has-text' : ''; ?>">
                                <div class="iwpdf-field">
                                    <input type="radio" id="deactivation_reason_<?php esc_attr_e($reason['id']); ?>" name="deactivation_reason" value="<?php esc_attr_e( $reason['id'] ); ?>">
                                    <label for="deactivation_reason_<?php esc_attr_e($reason['id']); ?>"><?php esc_html_e( $reason['title'] ); ?></label>
                                </div>
			                    <?php if($has_text): ?>
                                    <div class="iwpdf-subfield">
                                        <input type="text" name="<?php esc_attr_e( $reason['id'] ); ?>_additional_feedback" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>
                                    </div>
			                    <?php endif; ?>
                            </div>
	                    <?php endforeach; ?>
                    </div>
                </main>
                <footer class="iwpdf-modal__footer">
                    <button type="submit" class="iwpdf-form-submit button-primary"><?php echo esc_attr( $configuration->getTranslated( 'button_submit_deactivate' ) ); ?></button>
                    <button type="button" class="iwpdf-deactivate button-secondary"><?php echo esc_attr( $configuration->getTranslated( 'button_skip_deactivate' ) ); ?></button>
                </footer>
            </form>
        </div>
    </div>
</div>