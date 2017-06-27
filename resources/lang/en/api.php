<?php

$httpStatusText = \Symfony\Component\HttpFoundation\Response::$statusTexts;

return [
    'success'   => 'Successfully requested',
    'fail'      => 'Unable to process the request',

    // Applicable to normal views as well
    'something_went_wrong'  => 'Whoops, looks like something went wrong',

    // For API Middleware
    'invalid_url_type'      => 'Invalid url type',
    'invalid_content_type'  => 'Content type is invalid',
    'invalid_accept_header' => 'Accept header is invalid',
    'invalid_request_body'  => 'Invalid Request Body',

    // HTTP status text
    'http_status_text'      => $httpStatusText,

    // Validations
    'validations'   => [
        'auth'  => 'Email or password is invalid.'
    ],

    // JWT
    'token_not_provided'    => 'Token is missing in the header.',
    'token_expired'         => 'Token has expired',
    'token_invalid'         => 'Token is invalid',
    'user_not_found'        => 'User corresponding to the token is not found.',
    ''
];
