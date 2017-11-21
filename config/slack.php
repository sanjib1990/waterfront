<?php

return [
    /**
     * The webhook url to be used.
     */
    'web_hook' => env('SLACK_WEBHOOK_URL'),

    /**
     * The default channel to post to.
     */
    'default_channel' => env('SLACK_DEFAULT_CHANNEL'),

    /**
     * username for posting which will be displayed.
     */
    'slack_user_name' => env('SLACK_USER_NAME', 'capwx'),

    /**
     * Allow markdown to support markdown
     * true or false
     */
    'allow_markdown' => env('ALLOW_MARKDOWN', true),

    /**
     * Link names and channels in messages. default is false.
     */
    'link_names' => true,

    /**
     * Icon
     */
    'icon' => env('SLACK_ICON', ':space_invader:')
];
