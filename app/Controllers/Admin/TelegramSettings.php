<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Helpers\Request_helper;
use App\Models\EmailModel;
use App\Models\UploadModel;
use App\Models\Telegram\TelegramModel;

use Longman\TelegramBot\Exception\TelegramException;

class TelegramSettings extends BaseController
{
    public function __construct()
    {
        $this->telegramModel = new TelegramModel();
    }

    public function index()
    {

        $data['title'] = trans("telegram");
        $data['telegram'] = $this->telegramModel->asObject()->find(1);

        return view('admin/telegram/index', $data);
    }

    public function configurations_post()
    {

        if ($this->telegramModel->update_telegram_settings()) {
            $this->session->setFlashData('success', trans("settings") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    public function webhook_setup_posts()
    {
        $id = $this->request->getVar('id');
        $option = $this->request->getVar('option');

        $bot = $this->telegramModel->asObject()->find($id);

        if ($option == 'setwebhook') {

            try {
                $data = array(
                    'status' => 1,
                );

                $this->telegramModel->builder()->where('id', 1)->update($data);
                $curl = service('curlrequest');

                $response = $curl->request('get', base_url() . '/api/manager',  [
                    "verify" => false,
                    'query' => ['s' => 'super-secret', 'a' => 'set']
                ]);

                if ($response->getStatusCode()) {
                    echo $response->getStatusCode();
                } else {
                    $response->getStatusCode();
                }
            } catch (TelegramException $e) {
                // log telegram errors
                echo $e->getMessage();
            }
        }

        if ($option == 'deletewebhook') {
            try {
                $data = array(
                    'status' => 0,
                );

                $this->telegramModel->builder()->where('id', 1)->update($data);
                $curl = service('curlrequest');

                $response = $curl->request('get', base_url() . '/api/manager',  [
                    "verify" => false,
                    'query' => ['s' => 'super-secret', 'a' => 'set']
                ]);

                if ($response->getStatusCode() == 200) {
                    echo $response->getStatusCode();
                } else {
                    $response->getStatusCode();
                }
            } catch (TelegramException $e) {
                // log telegram errors
                echo $e->getMessage();
            }
        }
    }
}
