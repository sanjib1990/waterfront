<?php

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
    'cookie_header'         => 'Cookie-Id missing in headers'
];
