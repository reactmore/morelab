<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\Telegram\Core\ReactCommand;
use App\Telegram\Helpers\KeyboardHelper;
use App\Telegram\Helpers\TextHelper;
use Longman\TelegramBot\ChatAction;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ChatPermissions;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use LitEmoji\LitEmoji;
use App\Telegram\Helpers\GroupHelper;
use App\Telegram\Helpers\BotDevelopmentHelper;

class CommonCommand extends ReactCommand
{

    protected $name = 'common';

    protected $description = 'This Statis Command';

    protected $version = '0.1.0';

    protected $usage = '/common';

    protected $private_only = true;

    public static function handleCallbackQuery(CallbackQuery $callback_query, array $callback_data): ?ServerResponse
    {
        return $callback_query->answer();
    }

    public function execute(): ServerResponse
    {

        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();

        $text = trim($message->getText(true));

        if ($text === 'Batalkan') {
            return $this->CancelMessage();
        }

        if ($text === 'Transaksi') {
            return $this->TransactionsMessage();
        }

        if ($text === 'Isi Saldo') {
            return $this->DepositMessage();
        }

        return Request::sendMessage([
            'text' => 'Menu ini Belum Tersedia! ',
            'chat_id' => $chat_id,
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getMainMenuKeyboard(),
        ]);
    }

    /**
     * Cancel.
     *
     * @return ServerResponse
     */
    private function CancelMessage(): ServerResponse
    {

        return Request::sendMessage([
            'text' => 'Yah Kenapa Di Batalin',
            'chat_id' => $this->getMessage()->getChat()->getId(),
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getMainMenuKeyboard(),
        ]);
    }

    private function TransactionsMessage(): ServerResponse
    {

        return Request::sendMessage([
            'text' => 'Silahkan Pilih Produk',
            'chat_id' => $this->getMessage()->getChat()->getId(),
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getProductMenuKeyboard(),
        ]);
    }

    private function DepositMessage(): ServerResponse
    {

        return Request::sendMessage([
            'text' => 'Silahkan pilih metode pembayaran untuk mengisi saldo akun kamu',
            'chat_id' => $this->getMessage()->getChat()->getId(),
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getDepositMenuKeyboard(),
        ]);
    }
}
