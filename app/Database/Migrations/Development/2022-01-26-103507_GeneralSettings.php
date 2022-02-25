<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class GeneralSettings extends Migration
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
            'application_name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'site_lang'       => [
                'type'       => 'INT',
                'constraint' => 1,
                'default' => 1,
            ],
            'multilingual_system'       => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'dark_mode'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default' => 1,

            ],
            'mail_library'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'swift',

            ],
            'mail_protocol'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'smpt',

            ],
            'mail_encryption'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'tls',

            ],
            'mail_host'  => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true,


            ],
            'mail_port'  => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
                'default' => '587',

            ],
            'mail_username'  => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true,

            ],
            'mail_password'  => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true,

            ],
            'mail_title'  => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true,

            ],
            'mail_reply_to'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'noreply@domain.com',

            ],
            'google_client_id'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'google_client_secret'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'registration_system'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 1,
            ],
            'vr_key'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'purchase_code'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'recaptcha_site_key'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'recaptcha_secret_key'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'recaptcha_lang'  => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'cache_system'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ],
            'cache_refresh_time'  => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null' => true,
                'default' => 1800,
            ],
            'refresh_cache_database_changes'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'email_verification'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ],
            'file_manager_show_files'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ],
            'timezone'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => 'Asia/Jakarta',
            ],
            'maintenance_mode_title'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => 'Coming Soon!',
            ],
            'maintenance_mode_description'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'maintenance_mode_status'  => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ],
            'cookie_prefix'  => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'last_cron_update'  => [
                'type'       => 'TIMESTAMP',
                'null' => true,
            ],
            'version'  => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'default' => '1.0'
            ],
            'copyright'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => '<strong>Copyright &copy; 2014-2022 <a href="">Reactmore</a>.</strong>    All rights reserved.'
            ],
            'contact_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'contact_text'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'contact_address'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'contact_email'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'contact_phone'  => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null' => true,

            ],
            'logo_light'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,

            ],
            'logo_dark'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,

            ],
            'logo_email'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,

            ],
            'favicon'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,

            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null' => true,

            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('general_settings');
    }

    public function down()
    {
        $this->forge->dropTable('general_settings');
    }
}
