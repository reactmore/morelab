<?php

namespace App\Telegram\Helpers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use MatthiasMullie\Scrapbook\Adapters\MySQL;
use MatthiasMullie\Scrapbook\KeyValueStore;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\NullLogger;
use GuzzleHttp\Client;
use Throwable;


class BotDevelopmentHelper
{
    public static function dump($data, $chat_id = null)
    {
        $dump = var_export($data, true);


        if (!empty($chat_id)) {
            $result = Request::sendMessage([
                'chat_id'                  => $chat_id,
                'text'                     => $dump,
                'disable_web_page_preview' => true,
                'disable_notification'     => true,
            ]);

            if ($result->isOk()) {
                return $result;
            }

            TelegramLog::error('Var not dumped to chat_id %s; %s', $chat_id, $result->printError());
        }

        return Request::emptyResponse();
    }

    public static function jsonDebug($array): bool
    {
        $fp = fopen(getenv('TG_LOGS_DIR') . '/command.json', 'w');

        $fs = json_encode(
            $array,
            JSON_PRETTY_PRINT
        );
        fwrite(
            $fp,
            $fs
        );
        fclose($fp);

        return false;
    }
}
