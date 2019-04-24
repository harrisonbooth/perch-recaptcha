<?php

/**
 * Import Google's Recaptcha PHP library to perform validation on widget.
 */
require_once './lib/recaptcha/src/autoload.php';

/**
 *
 * Receives a form submission and validate using Recaptcha, re-dispatching the form to Perch forms if valid.
 * @param $form
 */
function hbooth_recaptcha_form_handler($form)
{
    $formData = $form->data;
    $response = null;

    if (isset($formData['g-recaptcha-response'])) {
        $response = $formData['g-recaptcha-response'];
    }

    $recaptcha = new \Recaptcha\Recaptcha('SECRET_API_KEY');
    $recaptcha->validate($response, $_SERVER['REMOTE_ADDR']);
    if ($recaptcha->isValid()) {
        $form->redispatch('perch_forms');
    } else {
        $form->throw_error('ERROR', 'Failed to pass Recaptcha.');
    }
}

    