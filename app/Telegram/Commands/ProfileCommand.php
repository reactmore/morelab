<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\Models\Telegram\UserModel;
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

class ProfileCommand extends ReactCommand
{


    protected $name = 'profile';

    protected $description = 'Show Profile User';

    protected $version = '0.1.0';

    protected $usage = '/profile';

    protected $private_only = true;

    public static function handleCallbackQuery(CallbackQuery $callback_query, array $callback_data): ?ServerResponse
    {
        return $callback_query->answer();
    }

    public function execute(): ServerResponse
    {
        helper('custom_helper');
        $userModel = new UserModel();
        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $user =  $userModel->asObject()->find($user_id);

        $text = trim($message->getText(true));

        Request::sendChatAction([
            'chat_id' => $chat_id,
            'action' => ChatAction::TYPING,
        ]);

        $out_text = "### Profile ###\n";
        $out_text .= "ID Pengguna : {$user->id} \n";
        $out_text .= "Saldo : \n";
        $out_text .= "Poin : \n";
        $active =  $user->status ? 'Aktif' : 'Tidak Aktif';
        $out_text .= "Status : {$active} \n";
        $join_at = date("M j, Y", strtotime($user->created_at));
        $out_text .= "Bergabung Sejak : {$join_at} \n";
        $out_text .= "Versi Bot : v1.0";




        return Request::sendMessage([
            'text' => LitEmoji::encodeUnicode($out_text),
            'chat_id' => $chat_id,
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getMainMenuKeyboard(),
        ]);
    }
}
