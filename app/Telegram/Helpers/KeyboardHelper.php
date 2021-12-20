<?php


namespace App\Telegram\Helpers;

use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use LitEmoji\LitEmoji;

class KeyboardHelper
{
	/**
	 * Return "follow to" links set keyboard array
	 *
	 * $group_url and $channel_url MUST BE valid http(s) protocol links.
	 * Telegram API will return 400 Bad Request response code if not.
	 *
	 * @param $group_url string
	 * @param $channel_url string|null
	 *
	 * @return InlineKeyboard
	 */
	public static function getJoinToKeyboard(string $group_url, string $channel_url = null)
	{
		$keyboard_array = [
			['text' => 'Join our group', 'url' => $group_url],
		];
		if (!empty($channel_url)) {
			$keyboard_array[] = ['text' => 'Join our channel', 'url' => $channel_url];
		}

		$keyboard = new InlineKeyboard($keyboard_array);
		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Check me" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getBackKeyboardInline()
	{
		$keyboard = new InlineKeyboard([
			['text' => 'Back', 'callback_data' => 'command=react&action=back']
		]);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Check me" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getCheckMeKeyboard()
	{
		$keyboard = new InlineKeyboard([
			['text' => 'Check Me', 'callback_data' => 'command=react&action=checkme']
		]);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	public static function getMutasi($id)
	{
		$keyboard = new InlineKeyboard([
			['text' => 'Confirm Transfer', 'callback_data' => 'command=react&action=mutasi&i=' . $id]
		]);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Main menu" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getMainMenuKeyboard()
	{
		$keyboard = new Keyboard(
			['Transaksi', 'Isi Saldo', 'Profile'],
			['Kupon', 'Extra', 'Bantuan'],
			['Undian', 'Rekber', 'Refferal']
		);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Main menu" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getProductMenuKeyboard()
	{
		$keyboard = new Keyboard(
			['Crypto'],
			['Batalkan']
		);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Main menu" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getDepositMenuKeyboard()
	{
		$keyboard = new Keyboard(
			['Voucher Indodax', 'Bank'],
			['Virtual Account'],
			['Batalkan']
		);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Return "Main menu" keyboard
	 *
	 * @return Keyboard
	 */
	public static function getBackKeyboard()
	{
		$keyboard = new Keyboard(
			['Batalkan'],
		);

		$keyboard->setResizeKeyboard(true);

		return $keyboard;
	}

	/**
	 * Remove keyboard from chat
	 *
	 * @return Keyboard
	 */
	public static function getEmptyKeyboard()
	{
		return Keyboard::remove();
	}
}
