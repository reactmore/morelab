<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Telegram\TelegramModel;
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
    public function __construct()
    {
        $this->telegramModel = new TelegramModel();
    }

    public function index()
    {
        try {
            $config = $this->telegramModel->asObject()->find(1);
            $AdminintegerIDs = array_map('intval', explode(',', $config->bot_admin));
            // Vitals!
            $params = [
                'api_key' =>  $config->bot_api_key,
                'bot_username' => $config->bot_username,
                'secret' => getenv('TG_SECRET'),
                'admins' =>  $AdminintegerIDs,
            ];

            $extras = [
                'commands',
                'paths',
            ];

            foreach ($extras as $extra) {
                if ($param = getenv('TG_' . strtoupper($extra))) {
                    $params[$extra] = json_decode($param, true);
                }
            }

            // Database connection.

            $params['mysql'] = [
                'host'     => getenv('database.telegram.hostname'),
                'port'     => getenv('database.telegram.port'),
                'user'     => getenv('database.telegram.username'),
                'password' => getenv('database.telegram.password'),
                'database' => getenv('database.telegram.database'),
            ];



            $params['webhook'] = [
                'url' => $config->webhook_url,
                // 'certificate' => FCPATH . 'laragon.crt',
                'max_connections' => 10,
                'allowed_updates' => [],
            ];





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
            $config = $this->telegramModel->asObject()->find(1);
            $telegram = new Telegram($config->bot_api_key, $config->bot_username);
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
