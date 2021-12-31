<?php

namespace Config;

use App\Controllers\Admin\Dashboard;
use App\Controllers\AjaxController;
use App\Controllers\Home;
use App\Libraries\Finance\BCAParser;
use App\Models\Finance\AccountMutationModel;
use CodeIgniter\Config\BaseConfig;

use Daycry\CronJob\Scheduler;

class CronJob extends \Daycry\CronJob\Config\CronJob
{
	/**
	 * Directory
	 */
	public $FilePath = WRITEPATH . 'cronJob/';

	/**
	 * Filename setting
	 */
	public $FileName = 'jobs';

	/**
	 * Set true if you want save logs
	 */
	public $logPerformance = false;

	/*
    |--------------------------------------------------------------------------
    | Log Saving Method
    |--------------------------------------------------------------------------
    |
    | Set to specify the REST API requires to be logged in
    |
    | 'file'   Save in file
    | 'database'  Save in database
    |
    */
	public $logSavingMethod = 'file';

	/*
    |--------------------------------------------------------------------------
    | Database Group
    |--------------------------------------------------------------------------
    |
    | Connect to a database group for logging, etc.
    |
    */
	public $databaseGroup = 'default';

	/*
    |--------------------------------------------------------------------------
    | Cronjob Table Name
    |--------------------------------------------------------------------------
    |
    | The table name in your database that stores cronjobs
    |
    */
	public $tableName = 'cronjob';



	/*
    |--------------------------------------------------------------------------
	| Cronjobs
	|--------------------------------------------------------------------------
    |
	| Register any tasks within this method for the application.
	| Called by the TaskRunner.
	|
	| @param Scheduler $schedule
	*/
	public function init(Scheduler $schedule)
	{


		$schedule->call(function () {
			$mutations = new BCAParser(getenv('BCA_USERNAME'), getenv('BCA_PIN'));
			$result = $mutations->getListTransaksi(date("Y-m-d"), date("Y-m-d"));
			$AccountMutationModel = new AccountMutationModel();

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

					$output = $AccountMutationModel->syncMutation($product_code, $insert);
					$mutations->logout();
				}

				echo $output;
			} else {
				echo 'Mohon Menunggu Selama 10 Menit!';
				$mutations->logout();
			}
		})->everyFifteenMinutes()->named('mutasi');

		// $schedule->shell('cp foo bar')->daily( '11:00 pm' );
		// $schedule->call( function() { do something.... } )->everyMonday()->named( 'foo' )
	}
}
