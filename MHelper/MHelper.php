<?php

/**
 * Helper class
 *
 * @example
 *  MHelper::get()->string->toLower('TeSt StRiNg');         // test string
 *  MHelper::get()->string()->toUpper('TeSt StRiNg');       // TEST STRING
 *  MHelper::get()->string('TeSt StRiNg')->ucwords();       // Test String
 *  MHelper::get('string', 'TeSt StRiNg')->toLower();       // test string
 *  MHelper::get(null, 'TeSt StRiNg')->string->toLower();   // test string
 *
 *  OR
 *
 *  $MString = new MString('TeSt StRiNg');
 *  $MString->toLower();                                    // test string
 *
 *  $MString = new MString();
 *  $MString->toLower('TeSt StRiNg');                       // test string
 *
 *  OR
 *
 *  // PHP 5.3+ only
 *  MHelper::String()->toLower('TeSt StRiNg');              // test string
 *  MHelper::String('TeSt StRiNg')->toUpper();              // TEST STRING
 *  MString::toLower('TeSt StRiNg');                        // test string
 *
 *  Use chaining
 *
 *  MHelper::get()->string('TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
 *  MHelper::get()->string(null, true)->toUpper('TeSt StRiNg')->lcFirst()->value;             // tEST STRING
 *  MHelper::get()->string('TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
 *  MHelper::get('string', 'TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
 *  MHelper::get(null, 'TeSt StRiNg', true)->string->toUpper()->lcFirst()->value;             // tEST STRING
 *  MHelper::get(null, null, true)->string('TeSt StRiNg')->toUpper()->lcFirst()->value;       // tEST STRING
 *
 *  OR
 *
 *  $MString = new MString('TeSt StRiNg', true);
 *  $MString->toLower()->ucFirst()->value;                                  // Test string
 *
 *  $MString = new MString();
 *  $MString->setChain(true)->toLower('TeSt StRiNg')->ucFirst()->value;     // Test string
 *
 *  OR
 *
 *  // PHP 5.3+ only
 *  MHelper::String('TeSt StRiNg', true)->toLower()->ucFirst()->value;               // Test string
 *  MHelper::String(null, true)->toLower('TeSt StRiNg')->ucFirst()->value;           // Test string
 *  MHelper::String('TeSt StRiNg')->setChain(true)->toLower()->ucFirst()->value;     // Test string
 *  MHelper::String()->setChain(true)->toLower('TeSt StRiNg')->ucFirst()->value;     // Test string
 *  MString::chain(true)->toUpper('TeSt StRiNg')->lcFirst()->value;                  // tEST STRING
 *
 * @version 2.0 19.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
class MHelper
{

	protected static $_Instance = null;
	protected static $_helpers = array();
	private static  $_value = null;
	private static  $_chain = false;

	private function __construct() {}
	private function __clone() {}

	public static function __callStatic($helper, $arguments)
	{
		$value = isset($arguments[0]) && $arguments[0] ? $arguments[0] : false;
		$chain = isset($arguments[1]) ? (bool)$arguments[1] : false;
		return self::get($helper, $value, $chain);
	}

	public function __call($helper, $arguments)
	{
		$value = isset($arguments[0]) && $arguments[0] ? $arguments[0] : false;
		$chain = isset($arguments[1]) ? (bool)$arguments[1] : false;
		$Helper = self::get($helper, $chain);
		if ($value)
			$Helper->setValue($value);
		if ($chain)
			$Helper->setChain($chain);
		return $Helper;
	}

	public function __get($helper)
	{
		$helper = strtolower($helper);
		if (!isset(self::$_helpers[$helper]))
		{
			$className = 'M'.ucfirst($helper);
			require_once dirname(__FILE__).DIRECTORY_SEPARATOR.$className.'.php';
			self::$_helpers[$helper] = new $className();
		}
		if (self::$_value)
			self::$_helpers[$helper]->setValue(self::$_value);
		if (self::$_chain)
			self::$_helpers[$helper]->setChain(self::$_chain);
		return self::$_helpers[$helper];
	}

	public static function get($helper=null, $value=null, $chain=false)
	{
		if (self::$_Instance === null)
			self::$_Instance = new self;

		self::$_value = $value;
		self::$_chain = (bool)$chain;
		return (is_string($helper) && $helper) ? self::$_Instance->{$helper} : self::$_Instance;
	}

}

/**
 * MHelperBase class
 *
 * @version 2.0 19.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
abstract class MHelperBase
{

	protected static $_storage = array();
	protected static $_chain = false;

	public function __construct($value=null, $chain=false)
	{
		$this->setValue($value);
		$this->setChain($chain);
	}

	public function __toString()
	{
		return self::getValue();
	}

	public function setValue($data)
	{
		self::_setStorage('value', $data);
	}

	public function getValue()
	{
		self::$_chain = false;
		return self::_getStorage('value');
	}

	public function setChain($chain=false)
	{
		self::$_chain = (bool)$chain;
		return $this;
	}

	public function __get($name)
	{
		if ($name == 'value')
		{
			$name = 'get'.ucfirst($name);
			return self::$name();
		}
		else
		{
			self::$name();
		}
	}

	public static function __callStatic($name, $arguments)
	{
		$helper = substr(get_called_class(), 1);
		$chain = isset($arguments[0]) ? (bool)$arguments[0] : false;
		if ($name == 'chain')
		{
			$Helper = MHelper::get($helper, null, $chain);
			$Helper->setChain($chain);
			return $Helper;
		}
	}

	protected function _getValue($data)
	{
		return $data?:self::_getStorage('value');
	}

	protected function _return($data, $returnData=false)
	{
		self::_setStorage('value', $data);
		if (!$returnData && self::$_chain)
			return $this;
		else
			return $data;
	}

	protected function _functionExists($name)
	{
		if (!self::_hasStorage($name, 'functionExists'))
			self::_setStorage($name, function_exists($name), 'functionExists');
		return self::_getStorage($name, 'functionExists');
	}

	protected function _hasStorage($name, $key=false)
	{
		$key = $key?:'_';
		return isset(self::$_storage[$key][$name]);
	}

	protected function _getStorage($name, $key=false)
	{
		$key = $key?:'_';
		return self::$_storage[$key][$name];
	}

	protected function _setStorage($name, $value, $key=false)
	{
		$key = $key?:'_';
		if (!isset(self::$_storage[$key]))
			self::$_storage[$key] = array();
		self::$_storage[$key][$name] = $value;
	}

}
