<?php

namespace SWX\Services\SlackService;

use Maknz\Slack\Client;

/**
 * Class Slack
 *
 * @package SWX\Services\SlackService
 */
class Slack
{
    /**
     * @var Client|\Maknz\Slack\Message;
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    /**
     * Slack constructor.
     */
    public function __construct()
    {
        $this->config = config('slack');
        $this->client = new Client($this->config['web_hook']);

        $this->init();
    }

    /**
     * Get the slack client instance.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Send message.
     *
     * @param       $message
     * @param array $params
     * [
     *  to => "@user or #channel the message needs to be sent to",
     *  withIcon => "set an icon other than the default icon",
     *  from => "send message on behalf of a user or bot",
     *  attach => array
     * ]
     *
     * @see https://github.com/maknz/slack for more options.
     * @return void
     */
    public function send($message, array $params = [])
    {
        $client = $this->client;

        foreach ($params as $key => $value) {
            $client = $client->{$key}($value);
        }

        $client->send($message);
    }

    /**
     * instiantiate the slack client with parameters.
     *
     * @return void
     */
    private function init()
    {
        $this->client->setAllowMarkdown($this->config['allow_markdown']);
        $this->client->setDefaultChannel($this->config['default_channel']);
        $this->client->setDefaultIcon($this->config['icon']);
        $this->client->setLinkNames($this->config['link_names']);
        $this->client->setDefaultUsername($this->config['slack_user_name']);
    }
}
