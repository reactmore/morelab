<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropTable extends Migration
{
    public function up()
    {
        //
        $this->forge->dropColumn('users',  ['update_at']);
    }

    public function down()
    {
        //
    }
}
