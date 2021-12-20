<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Request;



/**
 * Generic message command
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '0.2.0';

    /**
     * Execute command
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage() ?: $this->getCallbackQuery()->getMessage();
        $text = trim($this->getMessage()->getText(true));
        $msg_id = $message->getMessageId();

        // If a conversation is busy, execute the conversation command after handling the message.
        $conversation = new Conversation(
            $message->getFrom()->getId(),
            $message->getChat()->getId()
        );

        // Fetch conversation command if it exists and execute it.
        if ($conversation->exists() && $command = $conversation->getCommand()) {
            return $this->telegram->executeCommand($command);
        }

        if ($text === 'Transaksi') {
            return $this->getTelegram()->executeCommand('common');
        } elseif ($text === 'Profile') {
            return $this->getTelegram()->executeCommand('profile');
        } elseif ($text === 'Refferal') {
            return $this->getTelegram()->executeCommand('refferal');
        } else {
            return $this->getTelegram()->executeCommand('common');
        }

        // Handle new chat members.
        if ($message->getNewChatMembers()) {
            $this->deleteThisMessage(); // Service message.
            return $this->getTelegram()->executeCommand('newchatmembers');
        }
        if ($message->getLeftChatMember()) {
            $this->deleteThisMessage(); // Service message.
        }

        // Handle posts forwarded from channels.
        if ($message->getForwardFrom()) {
            return $this->getTelegram()->executeCommand('id');
        }

        return parent::execute();
    }

    /**
     * Delete the current message.
     *
     * @return ServerResponse
     */
    private function deleteThisMessage(): ServerResponse
    {
        return Request::deleteMessage([
            'chat_id'    => $this->getMessage()->getChat()->getId(),
            'message_id' => $this->getMessage()->getMessageId(),
        ]);
    }
}
