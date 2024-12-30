<?php

if (!defined('ABSPATH'))
    exit;

/**
 * 
 * Elementor Journey Sign Up Form widget.
 * 
 * @var array $settings
 * @var array $journey_data
 * @var string $form_title
 * @var string $form_description
 */

//  dd($journey_data);
?>

<div class="sign-up-container">
    <div class="open-popup-button-wrapper" style="background:transparent;">
        <button class="open-popup-button"><?php echo $settings['open_popup_button_text']; ?></button>
    </div>
    <div class="form-wrapper">
        <div class="heading">
            <h2><?php echo $form_title; ?></h2>
            <p><?php echo $form_description; ?></p>
        </div>
        <div class="form">
        </div>
        <div class="footing"></div>
    </div>
</div>

<style>
    pre {
        background-color: #fff;
    }
</style>