<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Helpers\Request_helper;
use App\Libraries\Finance\BCAParser;
use App\Models\Finance\AccountMutationModel;
use CodeIgniter\Cache\Handlers\BaseHandler;

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

    public function checkMutations()
    {
        $mutations = new BCAParser(getenv('BCA_USERNAME'), getenv('BCA_PIN'));

        $starDate = date("Y-m-d", strtotime('-30 days'));
        $endDate = date("Y-m-d");


        $result = $mutations->getListTransaksi($starDate, $endDate);
        if (!empty($result)) {
            foreach ($result as $item) {
                $uniq_code = md5($item['date'] . $item['description']);
                $insert[] = [
                    'uniq_code' =>  $uniq_code,
                    'amount' => $item['nominal'],
                    'description' => $item['description'],
                    'type'    => $item['flows'],
                    'transactions_at'    => $item['date'],
                ];
            }

            set_cache_data('bca_mutations', $insert);
            $mutations->logout();
        } else {
            echo 'Wait 10 Minute!';
            $mutations->logout();
        }
    }

    public function getMutations()
    {
        $data = get_cached_data('bca_mutations');

        $result = validatePaymentBank('EVANITA SATYAS', '50,123.00', $data);

        if ($result['success']) {
            echo "Data Transfer Atas Nama {$result['data']['description']} sebesar Rp {$result['data']['amount']} ditemukan";
        } else {
            echo "Data Tdak ditemukan";
        }
    }
}
