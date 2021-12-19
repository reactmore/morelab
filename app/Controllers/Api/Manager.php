<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Dotenv\Dotenv;
use Exception;
use GuzzleHttp\Client;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use TelegramBot\TelegramBotManager\BotManager;
use Reactmore\Bot\BotDevelopmentHelper;
use MatthiasMullie\Scrapbook\KeyValueStore;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\NullLogger;
use Throwable;


class Manager extends BaseController
{
    public function index()
    {
        try {
            // Vitals!
            $params = [
                'api_key' => getenv('TG_API_KEY'),
            ];
            foreach (['bot_username', 'secret'] as $extra) {
                if ($param = getenv('TG_' . strtoupper($extra))) {
                    $params[$extra] = $param;
                }
            }

            // Database connection.
            if (getenv('TG_DB_HOST')) {
                $params['mysql'] = [
                    'host'     => getenv('TG_DB_HOST'),
                    'port'     => getenv('TG_DB_PORT'),
                    'user'     => getenv('TG_DB_USER'),
                    'password' => getenv('TG_DB_PASSWORD'),
                    'database' => getenv('TG_DB_DATABASE'),
                ];
            }

            // Optional extras.
            $extras = [
                'admins',
                'commands',
                'paths',
            ];

            foreach ($extras as $extra) {
                if ($param = getenv('TG_' . strtoupper($extra))) {
                    $params[$extra] = json_decode($param, true);
                }
            }

            if (getenv('TG_MODE_WEBHOOK')) {
                $params['webhook'] = [
                    'url' => getenv('TG_WEBHOOK_URL'),
                    // 'certificate' => FCPATH . 'laragon.crt',
                    'max_connections' => 20,
                    'allowed_updates' => [],
                ];
            }




            $params['validate_request'] = false;
            if (getenv('TG_VALID_IPS')) {
                $params['valid_ips'] = getenv('TG_VALID_IPS');
                $params['validate_request'] = true;
                $params['limiter'] = [
                    'enabled' => true,
                    'options' => [
                        'interval' => 0.1,
                    ],
                ];
                $this->initRequestClient();
            }



            $this->initLogging();

            $bot = new BotManager($params);
            $bot->run();
        } catch (Throwable $e) {
            var_dump($e);
            TelegramLog::error($e->getMessage());
        }
    }

    function initLogging(): void
    {
        // Logging.
        $logging_paths = json_decode(getenv('TG_LOGGING'), true) ?? [];

        $debug_log  = $logging_paths['debug'] ?? null;
        $error_log  = $logging_paths['error'] ?? null;
        $update_log = $logging_paths['update'] ?? null;

        // Main logger that handles all 'debug' and 'error' logs.
        $logger = ($debug_log || $error_log) ? new Logger('telegram_bot') : new NullLogger();
        $debug_log && $logger->pushHandler((new StreamHandler($debug_log, Logger::DEBUG))->setFormatter(new LineFormatter(null, null, true)));
        $error_log && $logger->pushHandler((new StreamHandler($error_log, Logger::ERROR))->setFormatter(new LineFormatter(null, null, true)));

        // Updates logger for raw updates.
        $update_logger = new NullLogger();
        if ($update_log) {
            $update_logger = new Logger('telegram_bot_updates');
            $update_logger->pushHandler((new StreamHandler($update_log, Logger::INFO))->setFormatter(new LineFormatter('%message%' . PHP_EOL)));
        }

        TelegramLog::initialize($logger, $update_logger);
    }

    /**
     * Initialise a custom Request Client.
     */
    function initRequestClient()
    {
        $config = array_filter([
            'base_uri' => getenv('TG_REQUEST_CLIENT_BASE_URI') ?: 'https://api.telegram.org',
            'proxy'    => getenv('TG_REQUEST_CLIENT_PROXY'),
        ]);

        $config && Request::setClient(new Client($config));
    }


    public function sendChat()
    {
        try {
            $telegram = new Telegram(getenv('TG_API_KEY'), getenv('TG_BOT_USERNAME'));
            $chat_id = 958587442;

            Request::sendMessage([
                'chat_id'    => $chat_id,
                'text' => 'test',
            ]);
        } catch (TelegramException $e) {
            // Log telegram errors
            TelegramLog::error($e);
        } catch (TelegramLogException $e) {
            // Uncomment this to output log initialisation errors (ONLY FOR DEVELOPMENT!)
            TelegramLog::error($e);
        }
    }
}
