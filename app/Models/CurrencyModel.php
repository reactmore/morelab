<?php

namespace App\Models;

use App\Libraries\Currency;
use CodeIgniter\Model;

class CurrencyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'currencies';
    protected $primaryKey       = 'id';
    // protected $allowedFields = [];
    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->currencyLib = new Currency();
        $this->db->query("SET sql_mode = ''");
    }

    //set selected currency
    public function set_selected_currency()
    {
        $currency_code = $this->request->getVar('currency');
        $currency = $this->get_currency_by_code($currency_code);
        if (!empty($currency)) {
            $this->session->set('selected_currency', $currency->code);
        }
    }

    //get selected currency
    public function get_selected_currency($default_currency)
    {
        if ($this->payment_settings->currency_converter == 1 && !empty($this->session->get('selected_currency'))) {
            if (isset($this->currencies[$this->session->get('selected_currency')])) {
                return $this->currencies[$this->session->get('selected_currency')];
            }
        }

        return $this->default_currency;
    }

    //get default currency
    public function get_default_currency($currencies, $payment_settings)
    {
        if (isset($currencies[$payment_settings->default_currency])) {
            return $currencies[$payment_settings->default_currency];
        }
        $currencies = $this->get_currencies();
        return @$currencies[0];
    }

    //add currency
    public function add_currency()
    {
        $data = array(
            'code' => $this->request->getVar('code'),
            'name' => $this->request->getVar('name'),
            'symbol' => $this->request->getVar('symbol'),
            'currency_format' => $this->request->getVar('currency_format'),
            'symbol_direction' => $this->request->getVar('symbol_direction'),
            'space_money_symbol' => $this->request->getVar('space_money_symbol'),
            'status' => $this->request->getVar('status')
        );

        return $this->protect(false)->insert($data);
    }

    //update currency
    public function update_currency($id)
    {
        $id = clean_number($id);
        $data = array(
            'code' => $this->request->getVar('code'),
            'name' => $this->request->getVar('name'),
            'symbol' => $this->request->getVar('symbol'),
            'currency_format' => $this->request->getVar('currency_format'),
            'symbol_direction' => $this->request->getVar('symbol_direction'),
            'space_money_symbol' => $this->request->getVar('space_money_symbol'),
            'status' => $this->request->getVar('status')
        );

        return $this->protect(false)->update($id, $data);
    }

    //get currencies array
    public function get_currencies_array()
    {
        $currencies = $this->builder()->orderBy('status', 'DESC')->get()->getResult();

        $array = array();
        if (!empty($currencies)) {
            foreach ($currencies as $currency) {
                $array[$currency->code] = $currency;
            }
        }
        return $array;
    }

    //get currencies
    public function get_currencies()
    {
        $this->builder()->orderBy('status', 'DESC');;
        return $this->builder()->get()->getResult();
    }

    //get currency
    public function get_currency($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }

    //get currency by code
    public function get_currency_by_code($code)
    {
        $sql = "SELECT * FROM $this->table WHERE code = ?";
        $query = $this->db->query($sql, array(clean_str($code)));
        return $query->getRow();
    }

    //update currency settings
    public function update_currency_settings()
    {
        $data = array(
            'default_currency' => $this->request->getVar('default_currency'),
            'allow_all_currencies_for_classied' => $this->request->getVar('allow_all_currencies_for_classied')
        );

        $this->builder('payment_settings')->where('id', 1)->update($data);
        $this->update_currency_rates($data['default_currency'], null);
        return true;
    }

    //update currency converter settings
    public function update_currency_converter_settings()
    {
        $data = array(
            'currency_converter' => $this->request->getVar('currency_converter'),
            'auto_update_exchange_rates' => $this->request->getVar('auto_update_exchange_rates'),
            'currency_converter_api' => $this->request->getVar('currency_converter_api'),
            'currency_converter_api_key' => $this->request->getVar('currency_converter_api_key')
        );

        $this->builder('payment_settings')->where('id', 1)->update($data);
        $this->update_currency_rates(null, $data['currency_converter_api'], $data['currency_converter_api_key']);
        return true;
    }

    //update currency rates
    public function update_currency_rates($base = null, $service = null, $service_key = null)
    {
        if (empty($base)) {
            $base = get_general_settings()->default_currency;
        }
        if (empty($service)) {
            $service = get_general_settings()->currency_converter_api;
        }
        if (empty($service_key)) {
            $service_key = get_general_settings()->currency_converter_api_key;
        }
        if (get_general_settings()->currency_converter == 1) {

            return $this->currencyLib->updateExchangeRates($base, $service, $service_key);
        }
        return true;
    }

    //edit currency rate
    public function edit_currency_rate()
    {
        $currency_id = $this->request->getVar('currency_id');
        $exchange_rate = $this->request->getVar('exchange_rate');
        $currency = $this->get_currency($currency_id);
        if (!empty($currency)) {
            return $this->protect(false)->update($currency->id, ['exchange_rate' => $exchange_rate]);
        }
    }

    //delete currency
    public function delete_currency($id)
    {

        $id = clean_number($id);
        $currency = $this->asObject()->find($id);
        if (!empty($currency)) {
            return $this->where('id', $currency->id)->delete();
        }
        return false;
    }
}
