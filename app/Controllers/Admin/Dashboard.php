<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Helpers\Request_helper;
use App\Libraries\Finance\BCAParser;
use App\Models\Finance\AccountMutationModel;

class Dashboard extends BaseController
{

    protected $requestHelper;
    protected $AccountMutationModel;

    public function __construct()
    {
        $this->requestHelper = new Request_helper();
        $this->AccountMutationModel = new AccountMutationModel();
    }

    public function index()
    {
        $data['title'] = trans('dashboard');

        $data['mutation'] = $this->AccountMutationModel->asObject()->orderBy('id', 'desc')->findAll();

        return view('admin/dashboard', $data);
    }

    public function checkMutation()
    {
        $mutations = new BCAParser(getenv('BCA_USERNAME'), getenv('BCA_PIN'));
        $result = $mutations->getListTransaksi(date("Y-m-d"), date("Y-m-d"));

        if (!empty($result)) {
            foreach ($result as $item) {
                $product_code = md5($item['date'] . $item['description']);
                $insert = [
                    'validate_code' =>  $product_code,
                    'amount' => $item['nominal'],
                    'description' => $item['description'],
                    'type'    => $item['flows'],
                    'transactions_at'    => $item['date'],
                ];

                $output = $this->AccountMutationModel->syncMutation($product_code, $insert);
                $mutations->logout();
            }

            echo $output;
        } else {
            echo 'Mohon Menunggu Selama 10 Menit!';
            $mutations->logout();
        }
    }
}
