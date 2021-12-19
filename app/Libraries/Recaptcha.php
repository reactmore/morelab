<?php

namespace App\Libraries;

/**
 * CodeIgniter Recaptcha library
 *
 * @package CodeIgniter
 * @author  Bo-Yi Wu <appleboy.tw@gmail.com>
 * @link    https://github.com/appleboy/CodeIgniter-reCAPTCHA
 */
class Recaptcha
{
	/**
	 * ci instance object
	 *
	 */
	private $ipAddress;

	/**
	 * reCAPTCHA site up, verify and api url.
	 *
	 */
	const sign_up_url = 'https://www.google.com/recaptcha/admin';
	const site_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
	const api_url = 'https://www.google.com/recaptcha/api.js';

	/**
	 * constructor
	 *
	 * @param string $config
	 */
	public function __construct()
	{

		$settings = get_general_settings();
		$this->_siteKey = $settings->recaptcha_site_key;
		$this->_secretKey = $settings->recaptcha_secret_key;
		$this->_language = $settings->recaptcha_lang;
		$this->ipAddress = \Config\Services::request()->getIPAddress();
	}

	/**language
	 * Submits an HTTP GET to a reCAPTCHA server.
	 *
	 * @param array $data array of parameters to be sent.
	 *
	 * @return array response
	 */
	private function _submitHTTPGet($data)
	{
		$url = self::site_verify_url . '?' . http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	 * Calls the reCAPTCHA siteverify API to verify whether the user passes
	 * CAPTCHA test.
	 *
	 * @param string $response response string from recaptcha verification.
	 * @param string $remoteIp IP address of end user.
	 *
	 * @return ReCaptchaResponse
	 */
	public function verifyResponse($response, $remoteIp = null)
	{

		$remoteIp = (!empty($remoteIp)) ? $remoteIp : $this->ipAddress;

		// Discard empty solution submissions
		if (empty($response)) {
			return array(
				'success' => false,
				'error-codes' => 'missing-input',
			);
		}

		$getResponse = $this->_submitHttpGet(
			array(
				'secret' => $this->_secretKey,
				'remoteip' => $remoteIp,
				'response' => $response,
			)
		);

		// get reCAPTCHA server response
		$responses = json_decode($getResponse, true);

		if (isset($responses['success']) and $responses['success'] == true) {
			$status = true;
		} else {
			$status = false;
			$error = (isset($responses['error-codes'])) ? $responses['error-codes']
				: 'invalid-input-response';
		}

		return array(
			'success' => $status,
			'error-codes' => (isset($error)) ? $error : null,
		);
	}

	/**
	 * Render Script Tag
	 *
	 * onload: Optional.
	 * render: [explicit|onload] Optional.
	 * hl: Optional.
	 * see: https://developers.google.com/recaptcha/docs/display
	 *
	 * @param array parameters.
	 *
	 * @return scripts
	 */
	public function getScriptTag(array $parameters = array())
	{
		$default = array(
			'render' => 'onload',
			'hl' => $this->_language,
		);

		$result = array_merge($default, $parameters);

		$scripts = sprintf(
			'<script type="text/javascript" src="%s?%s" async defer></script>',
			self::api_url,
			http_build_query($result)
		);

		return $scripts;
	}

	/**
	 * render the reCAPTCHA widget
	 *
	 * data-theme: dark|light
	 * data-type: audio|image
	 *
	 * @param array parameters.
	 *
	 * @return scripts
	 */
	public function getWidget(array $parameters = array())
	{
		$default = array(
			'data-sitekey' => $this->_siteKey,
			'data-theme' => 'light',
			'data-type' => 'image',
			'data-size' => 'normal',
		);

		$result = array_merge($default, $parameters);

		$html = '';
		foreach ($result as $key => $value) {
			$html .= sprintf('%s="%s" ', $key, $value);
		}

		return '<div class="g-recaptcha" ' . $html . '></div>';
	}
}
