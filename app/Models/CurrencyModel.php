<?php

namespace App\Models;

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
            'code' => $this->input->post('code', true),
            'name' => $this->input->post('name', true),
            'symbol' => $this->input->post('symbol', true),
            'currency_format' => $this->input->post('currency_format', true),
            'symbol_direction' => $this->input->post('symbol_direction', true),
            'space_money_symbol' => $this->input->post('space_money_symbol', true),
            'status' => $this->input->post('status', true)
        );

        return $this->db->insert('currencies', $data);
    }

    //update currency
    public function update_currency($id)
    {
        $id = clean_number($id);
        $data = array(
            'code' => $this->input->post('code', true),
            'name' => $this->input->post('name', true),
            'symbol' => $this->input->post('symbol', true),
            'currency_format' => $this->input->post('currency_format', true),
            'symbol_direction' => $this->input->post('symbol_direction', true),
            'space_money_symbol' => $this->input->post('space_money_symbol', true),
            'status' => $this->input->post('status', true)
        );

        $this->db->where('id', $id);
        return $this->db->update('currencies', $data);
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
        $this->db->order_by('status DESC, id');
        return $this->db->get('currencies')->result();
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
            'default_currency' => $this->input->post('default_currency', true),
            'allow_all_currencies_for_classied' => $this->input->post('allow_all_currencies_for_classied', true)
        );

        $this->db->where('id', 1);
        $this->db->update('payment_settings', $data);
        $this->update_currency_rates($data['default_currency'], null);
        return true;
    }

    //update currency converter settings
    public function update_currency_converter_settings()
    {
        $data = array(
            'currency_converter' => $this->input->post('currency_converter', true),
            'auto_update_exchange_rates' => $this->input->post('auto_update_exchange_rates', true),
            'currency_converter_api' => $this->input->post('currency_converter_api', true),
            'currency_converter_api_key' => $this->input->post('currency_converter_api_key', true)
        );
        $this->db->where('id', 1);
        $this->db->update('payment_settings', $data);
        $this->update_currency_rates(null, $data['currency_converter_api'], $data['currency_converter_api_key']);
        return true;
    }

    //update currency rates
    public function update_currency_rates($base = null, $service = null, $service_key = null)
    {
        if (empty($base)) {
            $base = $this->payment_settings->default_currency;
        }
        if (empty($service)) {
            $service = $this->payment_settings->currency_converter_api;
        }
        if (empty($service_key)) {
            $service_key = $this->payment_settings->currency_converter_api_key;
        }
        if ($this->payment_settings->currency_converter == 1) {
            $this->load->library('currency');
            $this->currency->updateExchangeRates($base, $service, $service_key);
        }
        return true;
    }

    //edit currency rate
    public function edit_currency_rate()
    {
        $currency_id = $this->input->post('currency_id', true);
        $exchange_rate = $this->input->post('exchange_rate', true);
        $currency = $this->get_currency($currency_id);
        if (!empty($currency)) {
            $this->db->where('id', $currency->id);
            $this->db->update('currencies', ['exchange_rate' => $exchange_rate]);
        }
    }

    //delete currency
    public function delete_currency($id)
    {
        $id = clean_number($id);
        $currency = $this->get_currency($id);
        if (!empty($currency)) {
            $this->db->where('id', $id);
            return $this->db->delete('currencies');
        }
        return false;
    }
}
