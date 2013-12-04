<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MHelper.php';

/**
 * Класс-хелпер для работы со строками
 *
 * @version 2.0 20.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
class MString extends MHelperBase
{

	/**
	 * Метод для перевода строки в верхний регистр
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _toUpper($string=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_strtoupper'))
			return self::_return(mb_strtoupper(self::_getValue($string), $charset), $returnData);
		else
			return self::_return(strtoupper(self::_getValue($string)), $returnData);
	}

	/**
	 * Метод для перевода строки в нижний регистр
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _toLower($string=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_strtolower'))
			return self::_return(mb_strtolower(self::_getValue($string), $charset), $returnData);
		else
			return self::_return(strtolower(self::_getValue($string)), $returnData);
	}

	/**
	 * Метод для перевода первого символа строки в верхний регистр
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _ucFirst($string=null, $charset='UTF-8', $returnData=false)
	{
		$string = self::_getValue($string);
		$letter = self::substr($string, 0, 1, $charset, true);
		$string = self::toUpper($letter, $charset, true) . self::substr($string, 1, null, $charset, true);
		return self::_return($string, $returnData);
	}

	/**
	 * Метод для перевода первого символа строки в нижний регистр
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _lcFirst($string=null, $charset='UTF-8', $returnData=false)
	{
		$string = self::_getValue($string);
		$letter = self::substr($string, 0, 1, $charset, true);
		$string = self::toLower($letter, $charset, true) . self::substr($string, 1, null, $charset, true);
		return self::_return($string, $returnData);
	}

	/**
	 * Метод переводит в верхний регистр первый символ каждого слова в строке
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _ucWords($string=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_convert_case'))
			return self::_return(mb_convert_case(self::_getValue($string), MB_CASE_TITLE, $charset), $returnData);
		else
			return self::_return(ucwords(self::_getValue($string)), $returnData);
	}

	/**
	 * Смена регистров символов в строке
	 *
	 * @param string $string
	 * @param int $mode (MB_CASE_UPPER, MB_CASE_LOWER, MB_CASE_TITLE)
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _convertCase($string=null, $mode=MB_CASE_UPPER, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_convert_case'))
			return self::_return(mb_convert_case(self::_getValue($string), $mode, $charset), $returnData);
		else
			return self::_return(self::_getValue($string), $returnData);
	}

	/**
	 * Функция вырезает часть текста из строки
	 *
	 * @param string $string
	 * @param integer $start
	 * @param integer $length
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _substr($string=null, $start=null, $length=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_substr'))
			return self::_return(mb_substr(self::_getValue($string), $start, $length, $charset), $returnData);
		else
			return self::_return(substr(self::_getValue($string), $start, $length), $returnData);
	}

	/**
	 * Метод возвращает последнее вхождение символа в строке
	 *
	 * @param null $haystack
	 * @param null $needle
	 * @param bool $part
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _strrchr($haystack=null, $needle=null, $part=false, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_strrchr'))
			return self::_return(mb_strrchr(self::_getValue($haystack), $needle, $part, $charset), $returnData);
		else
			return self::_return(strrchr(self::_getValue($haystack), $needle), $returnData);
	}

	/**
	 * Метод возвращает длину строки
	 *
	 * @param string $string
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _len($string=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_strlen'))
			return self::_return(mb_strlen(self::_getValue($string), $charset), $returnData);
		else
			return self::_return(strlen(self::_getValue($string)), $returnData);
	}

	/**
	 * Метод возвращает позицию искомой строки в исходной строке
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @param integer $offset
	 * @param string $charset
	 * @param bool $returnData
	 * @return boolean
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _stripos($haystack=null, $needle=null, $offset=null, $charset='UTF-8', $returnData=false)
	{
		if (self::_functionExists('mb_stripos'))
			return self::_return(mb_stripos(self::_getValue($haystack), $needle, $offset, $charset), $returnData);
		else
			return self::_return(stripos(self::_getValue($haystack), $needle, $offset), $returnData);
	}

	/**
	 * Метод удаляет слеши по краям строки
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _trimSlashes($string=null, $returnData=false)
	{
		return self::_return(trim(self::_getValue($string), '/'), $returnData);
	}

	/**
	 * Метод удаляет экранирование символов
	 *
	 * @param string|array $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _stripSlashes($string=null, $returnData=false)
	{
		$string = self::_getValue($string);
		if (is_array($string))
		{
			foreach ($string as $key=>$val)
			{
				$string[$key] = $this->stripSlashes($val);
			}
		}
		else
		{
			$string = stripslashes($string);
		}
		return self::_return($string, $returnData);
	}

	/**
	 * Метод удаляет двонйные и одинарные кавычки из строки
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _stripQuotes($string=null, $returnData=false)
	{
		return self::_return(str_replace(array('"', "'"), '', self::_getValue($string)), $returnData);
	}

	/**
	 * Метод заменяет двойнные и одинарные кавычки на их html-коды
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _quotesToEntities($string=null, $returnData=false)
	{
		return self::_return(str_replace(array("'","\"","'",'"'), array("&#39;","&quot;","&#39;","&quot;"), self::_getValue($string)), $returnData);
	}

	/**
	 * Метод заменяет двойные слеши на одинарные
	 * за исключением http://
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _reduceDoubleSlashes($string=null, $returnData=false)
	{
		return self::_return(preg_replace("#(^|[^:])//+#", "\\1/", self::_getValue($string)), $returnData);
	}

	/**
	 * Метод удаляет всякую хрень
	 * Например было:
	 * qwerty, test,, foo, bar
	 * стало:
	 * qwerty, test, foo, bar
	 *
	 * @param string $string
	 * @param string $character
	 * @param bool $trim
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _reduceMultiples($string=null, $character=',', $trim=false, $returnData=false)
	{
		$string = self::_getValue($string);
		$string = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $string);

		if ($trim === true)
			$string = trim($string, $character);

		return self::_return($string, $returnData);
	}

	/**
	 * Метод увеличивает счетчик в строке
	 *
	 * @param string $string
	 * @param string $separator
	 * @param integer $first
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _incrementString($string=null, $separator='_', $first=1, $returnData=false)
	{
		$string = self::_getValue($string);
		preg_match('/(.+)'.$separator.'([0-9]+)$/', $string, $match);

		return self::_return(isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $string.$separator.$first, $returnData);
	}

	/**
	 * Ну в общем и так понятно должно быть, что делает метод
	 *
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _alternator($returnData=false)
	{
		static $i;

		if (func_num_args() == 0)
		{
			$i = 0;
			return '';
		}

		$args = func_get_args();
		return self::_return($args[($i++ % count($args))], $returnData);
	}

	/**
	 * Метод возвращает строку, продублированную заданное количество раз
	 *
	 * @param string $string
	 * @param integer $num
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _repeater($string=null, $num=1, $returnData=false)
	{
		return self::_return((($num > 0) ? str_repeat(self::_getValue($string), $num) : ''), $returnData);
	}

	/**
	 * Функция wordwrap для работы с UTF-8
	 *
	 * @param string $string
	 * @param integer $width
	 * @param string $break
	 * @param bool $cut
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _wordwrap($string=null, $width=80, $break="\r\n", $cut=false, $returnData=false)
	{
		return self::_return(preg_replace('#([\S]{'.$width.'}'. ($cut ? '' : '\s') .')#u', '$1'. $break , self::_getValue($string)), $returnData);
	}

	/**
	 * Метод для обрезания строк
	 * Взят из плагинов "Smarty 3.0.6"
	 *  + добавлен параметр "$charset" (Иначе косяки с кириллицей в utf-8)
	 *  + подправлен код, т.к. неверно обрезались строки до целых слов
	 *
	 * $string - Строка, которую надо обрезать
	 *
	 * $length - Определяет максимальную длину обрезаемой строки
	 *
	 * $etc - Текстовая строка, которая заменяет обрезаемый текст.
	 *        Её длина НЕ включена в максимальную длину обрезаемой строки.
	 *
	 * $break_words - Определяет, обрезать ли строку в промежутке между словами (false)
	 *                или строго на указанной длине (true).
	 *
	 * $middle - Определяет, нужно ли обрезать строку в конце (false) или в середине строки (true).
	 *           Обратите внимание, что при включении этой опции, промежутки между словами игнорируются.
	 *
	 * $exact_length - Если true, то обрезается точно по запрашиваемой длине + $etc, если false, то запрашиваемая длина - длина $etc + $etc
	 *
	 * $charset	- Кодировка строки
	 *
	 * @param string $string
	 * @param integer $length
	 * @param string $etc
	 * @param boolean $break_words
	 * @param boolean $middle
	 * @param boolean $exact_length
	 * @param string $charset
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _truncate($string=null, $length=80, $etc='...', $break_words=false, $middle=false, $exact_length=true, $charset='UTF-8', $returnData=false)
	{
		$string = self::_getValue($string);
		if ($length == 0) return '';

		if (self::_functionExists('mb_strlen'))
		{
			if (mb_detect_encoding($string, 'UTF-8, ISO-8859-1') === 'UTF-8')
			{
				// $string has utf-8 encoding
				if (mb_strlen($string, $charset) > $length)
				{
					if (!$break_words && !$middle)
					{
						$string = mb_ereg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length + 1, $charset));
						if (mb_strlen($string, $charset) > $length)
							return self::_return(preg_replace('/\s+?(\S+)?$/u', '', $string) . $etc, $returnData);
					}
					if (!$exact_length)
						$length -= min($length, mb_strlen($etc, $charset));
					if (!$middle)
						return self::_return(mb_substr($string, 0, $length, $charset) . $etc, $returnData);
					else
						return self::_return(mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, - $length / 2, $charset), $returnData);
				}
				else
				{
					return self::_return($string, $returnData);
				}
			}
		}
		// $string has no utf-8 encoding
		if (strlen($string) > $length)
		{
			if (!$break_words && !$middle)
			{
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));
				if (mb_strlen($string, $charset) > $length)
					return self::_return(preg_replace('/\s+?(\S+)?$/', '', $string) . $etc, $returnData);
			}
			if (!$exact_length)
				$length -= min($length, strlen($etc));
			if (!$middle)
				return self::_return(substr($string, 0, $length) . $etc, $returnData);
			else
				return self::_return(substr($string, 0, $length / 2) . $etc . substr($string, - $length / 2), $returnData);
		}
		else
		{
			return self::_return($string, $returnData);
		}
	}

	/**
	 * Метод возвращает рандомную строку
	 *
	 * @param integer $len
	 * @param string $type
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/string_helper.php
	 */
	public function _randomString($len=5, $type='alnum', $returnData=false)
	{
		switch($type)
		{
			case 'basic': return mt_rand();
				break;
			case 'alnum':
			case 'numeric':
			case 'nozero':
			case 'alpha':
					switch ($type) {
						case 'alpha' :
							$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
						case 'alnum':
							$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
						case 'numeric':
							$pool = '0123456789';
							break;
						case 'nozero':
							$pool = '123456789';
							break;
					}

					$str = '';
					for ($i=0; $i<$len; $i++)
					{
						$str .= $this->substr($pool, mt_rand(0, $this->len($pool) -1), 1);
					}
					return self::_return($str, $returnData);
				break;
			case 'unique':
			case 'md5':
				return self::_return(md5(uniqid(mt_rand())), $returnData);
				break;
			case 'encrypt':
			case 'sha1':
				return self::_return(sha1(uniqid(mt_rand(), true)), $returnData);
				break;
		}
	}

	/**
	 * Метод для транслитерации строк
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _toTranslit($string=null, $returnData=false)
	{
		$tr = array(
			'А'=>'A',  'Б'=>'B',  'В'=>'V',  'Г'=>'G', 'Д'=>'D',
			'Е'=>'E',  'Ё'=>'Yo', 'Ж'=>'Zh', 'З'=>'Z', 'И'=>'I',
			'Й'=>'J',  'К'=>'K',  'Л'=>'L',  'М'=>'M', 'Н'=>'N',
			'О'=>'O',  'П'=>'P',  'Р'=>'R',  'С'=>'S', 'Т'=>'T',
			'У'=>'U',  'Ф'=>'F',  'Х'=>'H',  'Ц'=>'C', 'Ч'=>'Ch',
			'Ш'=>'Sh', 'Щ'=>'W',  'Ъ'=>'',   'Ы'=>'Y', 'Ь'=>'',
			'Э'=>'Ye', 'Ю'=>'Yu', 'Я'=>'Ya',

			'а'=>'a',  'б'=>'b',  'в'=>'v',  'г'=>'g', 'д'=>'d',
			'е'=>'e',  'ё'=>'yo', 'ж'=>'zh', 'з'=>'z', 'и'=>'i',
			'й'=>'j',  'к'=>'k',  'л'=>'l',  'м'=>'m', 'н'=>'n',
			'о'=>'o',  'п'=>'p',  'р'=>'r',  'с'=>'s', 'т'=>'t',
			'у'=>'u',  'ф'=>'f',  'х'=>'h',  'ц'=>'c', 'ч'=>'ch',
			'ш'=>'sh', 'щ'=>'w',  'ъ'=>'',   'ы'=>'y', 'ь'=>'',
			'э'=>'ye', 'ю'=>'yu', 'я'=>'ya',

			'!'=>'',  '@'=>'',  '#'=>'', '$'=>'',  '%'=>'',
			'^'=>'',  '&'=>'',  '*'=>'', '('=>'',  ')'=>'',
			'"'=>'',  ' '=>'_', ';'=>'', ':'=>'',  '?'=>'',
			'['=>'',  ']'=>'',  '{'=>'', '}'=>'',  '\''=>'',
			','=>'',  '.'=>'',  '/'=>'', '<'=>'',  '>'=>'',
			'\\'=>'', '|'=>'',  '/'=>'', '='=>'',  '+'=>'',
			'№'=>'',  '«'=>'',  '»'=>'', '’'=>'',  '`'=>'',
			'—'=>'-', '‘'=>'',

			// '_'=>'', '-'=>'',
		);
		return self::_return(strtr(self::_getValue($string), $tr), $returnData);
	}

	/**
	 * Метод для растранслитерации строк
	 *
	 * @param string $string
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _fromTranslit($string=null, $returnData=false)
	{
		$tr = array(
			'A'=>'А', 'B'=>'Б',  'C'=>'К', 'D'=>'Д', 'E'=>'Е',
			'F'=>'Ф', 'G'=>'Дж', 'H'=>'Ш', 'I'=>'И', 'J'=>'',
			'K'=>'К', 'L'=>'Л',  'M'=>'М', 'N'=>'Н', 'O'=>'О',
			'P'=>'П', 'Q'=>'К',  'R'=>'Р', 'S'=>'С', 'T'=>'Т',
			'U'=>'У', 'V'=>'В',  'W'=>'В', 'X'=>'',  'Y'=>'И',
			'Z'=>'З',

			'a'=>'а', 'b'=>'б',  'c'=>'к', 'd'=>'д', 'e'=>'е',
			'f'=>'ф', 'g'=>'дж', 'h'=>'ш', 'i'=>'и', 'j'=>'',
			'k'=>'к', 'l'=>'л',  'm'=>'м', 'n'=>'н', 'o'=>'о',
			'p'=>'п', 'q'=>'к',  'r'=>'р', 's'=>'с', 't'=>'т',
			'u'=>'у', 'v'=>'в',  'w'=>'в', 'x'=>'',  'y'=>'и',
			'z'=>'з',
		);
		return self::_return(strtr(self::_getValue($string), $tr), $returnData);
	}

	/**
	 * Метод для сравнения двух строк
	 * Возвращает текст с изменениями (добавленные символы обрамлены тегом "ins", а удаленные символы тегом "del")
	 *
	 * @param string $old
	 * @param string $new
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @see @this->_diff()
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _diff($old=null, $new=null, $returnData=false)
	{
		$old = self::_getValue($old);
		$diff = self::_p_diff(explode(' ', $old), explode(' ', $new));

		$ret = '';
		foreach($diff as $k)
		{
			if(is_array($k))
				$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
			else
				$ret .= $k . ' ';
		}
		return self::_return($ret, $returnData);
	}

	/**
	 * Метод для сравнения двух строк
	 *
	 * @param string $old
	 * @param string $new
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	private function _p_diff($old=null, $new=null, $returnData=false)
	{
		$old = self::_getValue($old);
		$maxlen = 0;
		foreach($old as $oindex => $ovalue)
		{
			$nkeys = array_keys($new, $ovalue);
			foreach($nkeys as $nindex)
			{
				$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
				if($matrix[$oindex][$nindex] > $maxlen)
				{
					$maxlen = $matrix[$oindex][$nindex];
					$omax = $oindex + 1 - $maxlen;
					$nmax = $nindex + 1 - $maxlen;
				}
			}
		}

		if($maxlen == 0)
			return array(array('d'=>$old, 'i'=>$new));

		return array_merge(
			self::_diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
			array_slice($new, $nmax, $maxlen),
			self::_diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
		);
	}

}
