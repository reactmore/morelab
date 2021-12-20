<?php

namespace App\Models\Telegram;

use CodeIgniter\Model;

class TelegramModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'telegram_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [];

    public function __construct()
    {
        parent::__construct();
        $this->request = \Config\Services::request();
    }

    public function update_telegram_settings()
    {
        $data = array(
            'bot_api_key' => $this->request->getVar('bot_api_key'),
            'bot_username' => $this->request->getVar('bot_username'),
            'bot_name' => $this->request->getVar('bot_name'),
            'webhook_url' => $this->request->getVar('webhook_url'),
            'bot_admin' => $this->request->getVar('bot_admin'),
            'channel_id' => $this->request->getVar('channel_id'),
            'channel_username' => $this->request->getVar('channel_username'),
            'bot_auth' => $this->request->getVar('bot_auth'),
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }
}
