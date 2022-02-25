<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class LanguageTranslations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'lang_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,

            ],
            'label'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '500',
                'null'       => true,
            ],
            'translation'       => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('language_translations');
    }

    public function down()
    {
        $this->forge->dropTable('language_translations');
    }
}
