<?php

namespace Admin\Model\Session;

use Admin\Model\Session\Wrapper\ISession;

class Wrapper implements ISession
{

	private static $_sessionContainer = array();

	public static function init()
	{
		if ('cli' !== PHP_SAPI) {
			session_start();
		}
	}

	public static function setValue($key, $value)
	{
		if ('cli' === PHP_SAPI) {
			self::$_sessionContainer[$key] = $value;
		} else {
			$_SESSION[$key] = $value;
		}
	}

	public static function getValue($key)
	{
		if ('cli' === PHP_SAPI) {
			if (isset(self::$_sessionContainer[$key])) {
				return self::$_sessionContainer[$key];
			}
		} else {
			if (isset($_SESSION[$key])) {
				return $_SESSION[$key];
			}
		}
		return null;
	}

	public static function destroy()
	{
		if ('cli' === PHP_SAPI) {
			self::$_sessionContainer = array();
		} else {
			session_destroy();
		}
	}

}