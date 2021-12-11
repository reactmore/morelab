<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GeneralSettingsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'application_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => 'Reactmore',
                'null' => true
            ],
            'site_lang' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
                'default' => '1'
            ],
            'multilingual_system' => [
                'type' => 'TINYINT',
                'constraint' => '255',
                'null' => true,
                'default' => '1'
            ],
            'mail_library' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'swift'
            ],
            'mail_protocol' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'smpt'
            ],
            'mail_encryption' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'tls'
            ],
            'mail_host' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL
            ],
            'mail_port' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => '587'
            ],
            'mail_username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL
            ],
            'mail_password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL

            ],
            'mail_title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL
            ],
            'mail_reply_to' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'noreply@domain.com'
            ],
            'google_client_id' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],
            'google_client_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],

            'facebook_app_id' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],
            'facebook_app_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],
            'registration_system' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '1'
            ],
            'vr_key' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],
            'purchase_code' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => NULL
            ],
            'recaptcha_site_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL
            ],
            'recaptcha_secret_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => NULL
            ],
            'recaptcha_lang' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'default' => NULL
            ],
            'cache_system' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'cache_refresh_time' => [
                'type' => 'INT',
                'constraint' => '1',
                'null' => true,
                'default' => '1800'
            ],
            'refresh_cache_database_changes' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'email_verification' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'file_manager_show_files' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '1'
            ],
            'audio_download_button' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '1'
            ],
            'timezone' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => 'Asia/Jakarta'
            ],
            'maintenance_mode_title' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => 'Coming Soon!'
            ],
            'maintenance_mode_description' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'default' => null
            ],
            'maintenance_mode_status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'show_user_email_on_profile' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'currency_symbol' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null
            ],
            'currency_symbol_format' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
                'default' => null
            ],
            'currency_format' => [
                'type' => 'VARCHAR',
                'constraint' => '29',
                'null' => true,
                'default' => null
            ],
            'cookie_prefix' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'default' => null
            ],
            'pwa_status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'last_cron_update' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'default' => '1'
            ],
            'update_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('general_settings');
    }

    public function down()
    {
        //
        $this->forge->dropTable('general_settings');
    }
}
