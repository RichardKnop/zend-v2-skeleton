<?php

namespace Admin\Model\Session\Wrapper;

interface ISession
{

	public static function init();

	public static function setValue($key, $value);

	public static function getValue($key);

	public static function destroy();
}