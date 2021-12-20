<?php

declare(strict_types=1);

namespace App\Telegram\Helpers;

use Longman\TelegramBot\DB;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\TelegramLog;

use Throwable;

class GroupHelper
{
    public static function getSettings($id, $code)
    {
        $dir = getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json';
        if (file_exists($dir)) {
            $groupsettings = file_get_contents($dir);

            $data = json_decode($groupsettings, true);
            foreach ($data as $index => $json) {
                if ($json['code'] === $code) {
                    return $json['value'];
                }
            }
        }

        return null;
    }

    public static function insertSetting($message)
    {
        $groupsettings = getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $message->getChat()->getId() . '.json';
        if (!file_exists($groupsettings)) {
            $directory = fopen($groupsettings, 'w');

            $config = [
                'id' =>  $message->getChat()->getId(),
                'name' =>  $message->getChat()->getTitle(),
                'type' =>  $message->getChat()->getType()
            ];

            $data[] = array('code' => 'identity', 'value' => $config);

            fwrite($directory, json_encode($data));
            fclose($directory);

            self::addSettings($config['id'], 'welcome_message_text', ["enable" => 0, "msg" => '']);
        }
    }

    public static function addSettings($id, $code, $val)
    {

        $groupsettings = file_get_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json');
        $temp = json_decode($groupsettings);

        $data = array(
            'code' => $code,
            'value' => $val
        );

        array_push($temp, $data);
        file_put_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json', json_encode($temp));
    }



    public static function updateSettings($id, $code, $data)
    {
        // read file
        $groupsettings = file_get_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json');

        $json_arr = json_decode($groupsettings, true);

        foreach ($json_arr as $key => $value) {
            if ($value['code'] == $code) {
                $json_arr[$key]['value'] =  $data;
            }
        }

        // self::deleteSetting($id, $code);

        file_put_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json', json_encode($json_arr));
    }

    public static function deleteSetting($id, $code)
    {

        $groupsettings = file_get_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json');

        $json_arr = json_decode($groupsettings, true);

        // get array index to delete
        $arr_index = array();
        foreach ($json_arr as $key => $value) {
            if ($value['code'] == $code) {
                $arr_index[] = $key;
            }
        }

        // delete data
        foreach ($arr_index as $i) {
            unset($json_arr[$i]);
        }

        // rebase array
        $json_arr = array_values($json_arr);

        // encode array to json and save to file
        file_put_contents(getenv('TG_CACHE_DIR') . '/group_configurations/settings_' . $id . '.json', json_encode($json_arr));
    }

    /**
     * Get a simple option value.
     *
     * @todo: Move into core!
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function getSimpleOption(int $id): mixed
    {
        $data = self::getSettings($id, 'welcome_message_ids');
        if (!empty($data)) {
            return $data;
        }

        return array();
    }

    /**
     * Set a simple option value.
     *
     * @todo: Move into core!
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return bool
     */
    public static function setSimpleOption(int $id, string $name, mixed $value)
    {
        $options = self::getSettings($id, 'welcome_message_ids');

        if (empty($options)) {
            return self::addSettings($id, $name, $value);
        }

        return self::updateSettings($id, $name, $value);
    }

    /**
     * Delete any old welcome messages from the group.
     */
    public static function deleteOldWelcomeMessages(int $id): void
    {
        $chat_id = $id;

        $welcome_message_ids = self::getSimpleOption($chat_id);
        foreach ($welcome_message_ids as $key => $message_id) {
            // Be sure to keep the latest one.
            if ($key === 'latest') {
                continue;
            }

            $deletion = Request::deleteMessage(compact('chat_id', 'message_id'));
            if (!$deletion->isOk()) {
                // Let's just save the error for now if it fails, to see if we can fix this better.
                TelegramLog::error(sprintf(
                    'Chat ID: %s, Message ID: %s, Error Code: %s, Error Message: %s',
                    $chat_id,
                    $message_id,
                    $deletion->getErrorCode(),
                    $deletion->getDescription()
                ));
            }

            unset($welcome_message_ids[$key]);
        }

        self::setSimpleOption($chat_id, 'welcome_message_ids', $welcome_message_ids);
    }

    /**
     * Save the latest welcome message to the option.
     *
     * @param int $welcome_message_id
     */
    public static function saveLatestWelcomeMessage(int $id, int $welcome_message_id): void
    {
        $welcome_message_ids     = self::getSimpleOption($id);
        $new_welcome_message_ids = array_values($welcome_message_ids) + ['latest' => $welcome_message_id];
        self::setSimpleOption($id, 'welcome_message_ids', $new_welcome_message_ids);
    }
}
