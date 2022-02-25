<?php

namespace App\Libraries;

use Google_Client;
use Google\Service\Analytics;

/**
 * Currency PHP library
 *
 **/
class GoogleAnalytics
{

    protected $db, $init, $profile;

    public function __construct()
    {
        helper('custom_helper');
        $this->db =  \Config\Database::connect();
        $this->init = $this->initializeAnalytics();

        $this->profile =  $this->getFirstProfileId($this->init);
    }


    public function initializeAnalytics()
    {

        $client = new \Google\Client();
        $client->setApplicationName(get_general_settings()->application_name . "Google Analytics");
        // putenv('GOOGLE_APPLICATION_CREDENTIALS=' . FCPATH  . '/../ceklissatu-34a6f1eb7d85.json');
        // $client->useApplicationDefaultCredentials();
        $client->setAuthConfig(FCPATH  . '/../ceklissatu-34a6f1eb7d85.json');
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Analytics($client);

        return $analytics;
    }

    public function getFirstProfileId($analytics)
    {

        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();


            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();


                $profiles = $analytics->management_profiles
                    ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();


                    return 'ga:' . $items[0]->getId();
                } else {
                    throw new \Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new \Exception('No properties found for this user.');
            }
        } else {
            throw new \Exception('No accounts found for this user.');
        }
    }

    public function getReportViews(string $startDate = null, string $endDate = null)
    {

        $diff = date_diff(date_create(date('Y-m-d', strtotime($endDate))), date_create($startDate));
        $diff = $diff->format("%R%a");

        $analytics_previous = $this->init->data_ga->get(
            $this->profile,
            date('Y-m-d', strtotime($startDate . $diff - 1 . " day")),
            date('Y-m-d', strtotime($endDate . $diff - 1 . " day")),
            'ga:users',
            array(
                'dimensions'  => 'ga:day,ga:month,ga:year',
                'sort'       => 'ga:month,ga:year',

            )
        );

        $analytics_latest = $this->init->data_ga->get(
            $this->profile,
            $startDate,
            $endDate,
            'ga:sessions,ga:pageviews,ga:users',
            array(
                'dimensions'  => 'ga:day,ga:month,ga:year',
                'sort'       => 'ga:month,ga:year',

            )
        );

        $data = array();
        foreach ($analytics_latest->getRows() as $row) {

            $data['latest']['day'][] = date("M-d", strtotime($row[0] . '-' . $row[1] . '-' . $row[2]));

            $data['latest']['user'][] = (int) $row[3];
        }

        foreach ($analytics_previous->getRows() as $row) {

            $data['previous']['day'][] = date("M-d", strtotime($row[0] . '-' . $row[1] . '-' . $row[2]));

            $data['previous']['user'][] = (int) $row[3];
        }

        return $data;
    }

    public function getReportTraffic(string $startDate = null, string $endDate = null)
    {

        $analytics = $this->init->data_ga->get(
            $this->profile,
            $startDate,
            $endDate,
            'ga:organicSearches',
            array(
                'dimensions'  => 'ga:medium,ga:hasSocialSourceReferral',
                'sort'       => 'ga:organicSearches',

            )
        );

        dd($analytics->getRows());

        $data = array();
        foreach ($analytics->getRows() as $row) {

            $data['latest']['day'][] = date("M-d", strtotime($row[0] . '-' . $row[1] . '-' . $row[2]));

            $data['latest']['user'][] = (int) $row[3];
        }


        return $data;
    }
}
