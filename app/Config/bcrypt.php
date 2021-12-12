<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Bcrypt extends BaseConfig
{

    public $iteration_count = 8;

    public $portable_hashes = FALSE;
}
