<?php


namespace App\Telegram\Helpers;

use App\Models\UserTelegramModel;
use Longman\TelegramBot\Entities\ChatMember;
use Longman\TelegramBot\Request;
use App\Models\Telegram\UserModel;



class CommunityHelper
{

	/**
	 * Return user status in relation to the chat with given chat_id
	 *
	 * @param $user_id string
	 * @param $chat_id string
	 *
	 * @return string|false
	 */
	public static function getUserChatStatus($user_id, $chat_id)
	{
		$isMemberRequest = Request::getChatMember(['chat_id' => $chat_id, 'user_id' => $user_id]);
		if ($isMemberRequest->isOk()) {
			/**
			 * @var $isMemberResult ChatMember
			 */
			$isMemberResult = $isMemberRequest->getResult();
			$memberStatus = $isMemberResult->getStatus();
			return $memberStatus;
		}
		return false;
	}

	/**
	 * Return boolean result of collation of user chat status and given array of statuses
	 * Status can be: “creator”, “administrator”, “member”, “restricted”, “left” or “kicked”
	 *
	 * @param $user_id string
	 * @param $chat_id string
	 * @param $chat_status_pool array of verifiable user statuses
	 *
	 * @return boolean
	 */
	public static function checkUserHaveAnyChatStatus(string $user_id, string $chat_id, array $chat_status_pool)
	{
		return in_array(self::getUserChatStatus($user_id, $chat_id), $chat_status_pool);
	}


	/**
	 * Checks user's membership in chat
	 *
	 * @param $user_id string
	 * @param $chat_id string
	 *
	 * @return boolean
	 */
	public static function checkUserIsMemberOfChat($user_id, $chat_id)
	{
		return self::checkUserHaveAnyChatStatus($user_id, $chat_id, ['member', 'administrator', 'creator']);
	}


	/**
	 * Checks if the user is admin of chat
	 *
	 * @param $user_id string
	 * @param $chat_id string
	 *
	 * @return boolean
	 */
	public static function checkUserIsAdminOfChat($user_id, $chat_id)
	{
		return self::checkUserHaveAnyChatStatus($user_id, $chat_id, ['administrator', 'creator']);
	}

	public static function checkKYC($user_id)
	{
		$UserTelegramModel = new UserModel();

		$user = $UserTelegramModel->asObject()->find($user_id);

		if ($user->status == 0) {
			return false;
		}

		return true;
	}
}
