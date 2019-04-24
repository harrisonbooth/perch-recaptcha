<?php

/**
 *
 * Receives a form submission and validate using Recaptcha, re-dispatching the form to Perch forms if valid.
 * @param $form
 */
function hbooth_recaptcha_form_handler($form)
{
    require_once __DIR__.'/lib/recaptcha/src/autoload.php';
    $recaptcha = new ReCaptcha\ReCaptcha('secret_key');

    $formData = $form->data;
    $widgetResponse = null;

    if (isset($formData['g-recaptcha-response'])) {
        $widgetResponse = $formData['g-recaptcha-response'];
    }

    $recaptchaResponse = $recaptcha->verify($widgetResponse, $_SERVER['REMOTE_ADDR']);
    if ($recaptchaResponse->isSuccess()) {
        $form->redispatch('perch_forms');
    } else {
        $form->throw_error('error', 'recaptcha');
    }
}

    