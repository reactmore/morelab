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

class RefferalCommand extends ReactCommand
{


    protected $name = 'refferal';

    protected $description = 'Show Refferal User';

    protected $version = '0.1.0';

    protected $usage = '/refferal';

    protected $private_only = true;

    public static function handleCallbackQuery(CallbackQuery $callback_query, array $callback_data): ?ServerResponse
    {
        return $callback_query->answer();
    }

    public function execute(): ServerResponse
    {

        $userModel = new UserModel();
        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $user =  $userModel->asObject()->find($user_id);
        $refferal_user = $userModel->countAllRefferal($user_id);

        $text = trim($message->getText(true));

        Request::sendChatAction([
            'chat_id' => $chat_id,
            'action' => ChatAction::TYPING,
        ]);
        $out_text = "*Total Refferal* : {$refferal_user} Pengguna\n\n";
        $out_text .= "*Link Refferal* : `http://t.me/{$this->config('bot_username')}?start={$user_id}` \n";





        return Request::sendMessage([
            'text' => LitEmoji::encodeUnicode($out_text),
            'chat_id' => $chat_id,
            'parse_mode' => 'markdown',
            'reply_markup' => KeyboardHelper::getMainMenuKeyboard(),
        ]);
    }
}
