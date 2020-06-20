<?php

namespace App\Service;

use App\Helper\LoggerTrait;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackClient
{
    use LoggerTrait;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendMessage(string $from, string $message): void
    {
        $this->logInfo('Beaming a message to Slack!', ['message' => $message]);

        $slackMessage = $this->client->createMessage();

        $slackMessage
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message);

        $this->client->sendMessage($slackMessage);
    }
}