<?php

namespace App\Models\Telegram;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'telegram';
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [];

    public function __construct()
    {
        parent::__construct();
        $this->request = \Config\Services::request();
    }
}
