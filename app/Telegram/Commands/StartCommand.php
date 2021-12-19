<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\UserCommands;

use App\Telegram\core\ReactCommand;
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

class StartCommand extends ReactCommand
{

    protected $name = 'start';

    protected $description = 'Show Start Command';

    protected $version = '0.1.0';

    protected $usage = '/start';

    protected $private_only = true;

    public static function handleCallbackQuery(CallbackQuery $callback_query, array $callback_data): ?ServerResponse
    {

        if ('explain' === $callback_data['action'] ?? null) {
            $message         = $callback_query->getMessage();
            $chat_id         = $message->getChat()->getId();
            $clicked_user_id = $callback_query->getFrom()->getId();

            $text = "Cara Penggunaan : \n\n";
            $text .= "1. Joinkan bot melalui Tombol (Add Me) agar informasi group tercatat di Database \n";
            $text .= "2. Gunakan Command /setwelcome untuk mengatur welcome  \n";
            $text .= " 2a. /setwelcome on/off (Mengaktifkan Welcome pada group)  \n";
            $text .= " 2b. /setwelcome message (Custom Welcome Text dan bisa menggunakan Variable {news_users}, {group_name}, {id}, {time_stamp} dan Emotions Code)  \n\n";
            $text .= "Fitur Akan di Update berkala \n\n";

            Request::editMessageText([
                'text' => $text,
                'chat_id'      => $chat_id,
                'message_id'   => $message->getMessageId(),
                'reply_markup' => KeyboardHelper::getBackKeyboard(),
            ]);

            return $callback_query->answer();
        }
        if ('donate' === $callback_data['action'] ?? null) {
            $message         = $callback_query->getMessage();
            $chat_id         = $message->getChat()->getId();
            $clicked_user_id = $callback_query->getFrom()->getId();
            $amount = "Rp ." . number_format(self::DonateSum());

            $text = "Terima Kasih telah melakukan Donasi, donasi ini digunakan membayar biaya server yang digunakan \n\n";
            $text .= "Donasi Terkumpul : {$amount} \n";

            $keyboard = new InlineKeyboard([
                ['text' => 'Gopay', 'callback_data' => 'command=react&action=donate'],
                ['text' => 'Paypal', 'url' => 'https://t.me/fvckinD/'],
            ], [
                ['text' => 'Back', 'callback_data' => 'command=react&action=back'],
            ]);

            $keyboard->setResizeKeyboard(true);

            Request::editMessageText([
                'text' => $text,
                'chat_id'      => $chat_id,
                'message_id'   => $message->getMessageId(),
                'reply_markup' =>  $keyboard,
            ]);

            return $callback_query->answer();
        }

        return $callback_query->answer();
    }

    public function execute(): ServerResponse
    {

        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $text = trim($message->getText(true));

        Request::sendChatAction([
            'chat_id' => $chat_id,
            'action' => ChatAction::TYPING,
        ]);

        $out_text = "Hello " . TextHelper::greeting() . " {$message->getChat()->tryMention(true)} \n\n";
        $out_text .= "### 🔎 INFORMASI 🔍 ###\nKami menjual BSC, LTC, BTT, TRX, USDT, XLM dan BUSD dengan sistem otomatis silahkan klik tombol Isi Saldo untuk mengisi saldo, Harap cek ketersediaan Coin terlebih dahulu dengan mengetik rate. \n\nSistem Cashback Poin bisa didapat ketika kamu membeli BSC, LTC, BTT, TRX, USDT, XLM dan BUSD sebesar 0.4 % dari nominal transaksi, 1 Poin (1 IDR) bisa ditukar dengan minimum penukaran 5000 Poin.\n\n";


        return Request::sendMessage([
            'text' => LitEmoji::encodeUnicode($out_text),
            'chat_id' => $chat_id,
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getMainMenuKeyboard(),
        ]);
    }
}
