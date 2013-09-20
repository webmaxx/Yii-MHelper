<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MHelper.php';

/**
 * Класс-хелпер для работы с массивами
 *
 * @version 2.0 20.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
class MArray extends MHelperBase
{

	/**
	 * Метод для получения элемента массива
	 * Если он не существует или пустой, то возвращается значение по умолчанию
	 * 
	 * @param string $item
	 * @param array $array
	 * @param mixed $default
	 * @param bool $returnData
	 * @return mixed
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/array_helper.php
	 */
	public function element($item=null, $array=array(), $default=false, $returnData=false)
	{
		$item = self::_getValue($item);
		if (!isset($array[$item]) || $array[$item] == "")
			return self::_return($default, $returnData);
		return self::_return($array[$item], $returnData);
	}

	/**
	 * Метод возвращает случайный элемент массива
	 * 
	 * @param array $array
	 * @param bool $returnData
	 * @return mixed
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/array_helper.php
	 */
	public function randomElement($array=null, $returnData=false)
	{
		$array = self::_getValue($array);
		if (!is_array($array))
			return self::_return($array, $returnData);
		return self::_return($array[array_rand($array)], $returnData);
	}

	/**
	 * Метод для получения специфичных элементов массива
	 * Если какого либо элемента не существует или пустой, то вместо него возвращается значение по умолчанию
	 * 
	 * @param array $items
	 * @param array $array
	 * @param mixed $default
	 * @param bool $returnData
	 * @return mixed
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/array_helper.php
	 */
	public function elements($items=null, $array=array(), $default=false, $returnData=false)
	{
		$items = self::_getValue($items);
		$return = array();
		if (!is_array($items))
			$items = array($items);
		foreach ($items as $item) {
			if (isset($array[$item]))
				$return[$item] = $array[$item];
			else
				$return[$item] = $default;
		}
		return self::_return($return, $returnData);
	}

}
