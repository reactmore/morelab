<?php

namespace App\Models\Finance;

use CodeIgniter\Model;
use App\Libraries\Bcrypt;


class AccountMutationModel extends Model
{

    protected $table            = 'account_mutation';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['id', 'validate_code', 'amount', 'description', 'type'];

    // Custom 
    protected $bcrypt;
    protected $session;
    protected $db;
    protected $request;

    public function __construct()
    {
        parent::__construct();

        $this->bcrypt = new Bcrypt();
        $this->session = session();
        $this->db = db_connect();

        $this->request = \Config\Services::request();
    }

    public function syncMutation($product_code, $data)
    {
        $checkData = $this->get_mutation_by_validate_code($product_code);
        if (!empty($checkData)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->builder()->where('validate_code', $product_code)->update($data);
            $msg = 'Data Success Update!';
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->builder()->set('validate_code', $product_code);
            $this->builder()->insert($data);
            $msg = 'Data Success Insert';
        }

        return $msg;
    }

    public function get_mutation_by_validate_code($validate_code)
    {
        $sql = "SELECT * FROM account_mutation WHERE account_mutation.validate_code = ? ";
        $query = $this->db->query($sql, array($validate_code));
        return $query->getRow();
    }

    public function validateTransactions($amount, $description)
    {
        $this->builder()->select('account_mutation.*')
            ->where('account_mutation.amount', $amount);

        $this->builder()->groupStart()
            ->like('account_mutation.description', clean_str($description))
            ->groupEnd();

        $query = $this->builder()->get()->getRow();

        if (!empty($query)) {
            return true;
        }

        return false;
    }
}
