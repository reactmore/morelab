<?php

namespace App\Telegram\Core;

use App\Models\Telegram\TelegramModel;

use Longman\TelegramBot\DB;
use Longman\TelegramBot\Commands\UserCommand;
use App\Telegram\Helpers\CommunityHelper;
use App\Telegram\Helpers\KeyboardHelper;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;

abstract class ReactCommand extends UserCommand
{
    public function config($object)
    {
        $model = new TelegramModel();
        $config = $model->asObject()->find(1);

        return $config->$object;
    }

    /**
     * Pre-execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function preExecute(): ServerResponse
    {
        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $telegramModel = new TelegramModel();
        $getModelSettings = $telegramModel->asObject()->find(1);


        if ($this->need_mysql && !($this->telegram->isDbEnabled() && DB::isDbConnected())) {
            return $this->executeNoDb();
        }

        if ($this->isPrivateOnly() && $this->removeNonPrivateMessage()) {
            if ($user = $message->getFrom()) {
                return Request::sendMessage([
                    'chat_id'    => $user->getId(),
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' =>  $message->getMessageId(),
                    'text'       => 'command is only available in a private chat'
                ]);
            }
            return Request::emptyResponse();
        }

        if ($telegramModel->asObject()->find(1)->bot_auth) {
            $text = "Sebelum Menggunakan Bot Ini Baiknya Kamu Gabung Channel/Group dulu ya \n\n";
            if (getenv('TG_CHANNEL_USERNAME')) {
                $auth_channel = CommunityHelper::checkUserIsMemberOfChat($message->getFrom()->getId(), '@' .  $telegramModel->asObject()->find(1)->cahnnel_username);
                if (!$auth_channel) {
                    $text .= "@" . $telegramModel->asObject()->find(1)->cahnnel_username . "\n";
                    return Request::sendMessage([
                        'chat_id'    =>  $message->getFrom()->getId(),
                        'parse_mode' => 'Markdown',
                        'disable_web_page_preview' => true,
                        'reply_markup' => KeyboardHelper::getCheckMeKeyboard(),
                        'text'       => $text
                    ]);
                }
            }

            $checkStatus = CommunityHelper::checkKYC($message->getFrom()->getId());
            if (!$checkStatus) {
                return Request::sendMessage([
                    'chat_id'    =>  $message->getFrom()->getId(),
                    'parse_mode' => 'Markdown',
                    'disable_web_page_preview' => true,
                    'reply_markup' => KeyboardHelper::getCheckMeKeyboard(),
                    'text'       => 'User Ini Belum Verifikasi!'
                ]);
            }
        }


        return $this->execute();
    }
}
