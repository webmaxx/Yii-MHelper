<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MHelper.php';

/**
 * Класс-хелпер для работы с файлами и директориями
 *
 * @version 2.0 20.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
class MPath extends MHelperBase
{

	/**
	 * Метод проверяет является запрашиваемый файл собственно файлом
	 *
	 * @param string $file
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _isFile($file=null, $returnData=false)
	{
		$file = self::_getValue($file);
		return self::_return($file ? is_file($file) : false, $returnData);
	}

	/**
	 * Метод проверяет есть ли права на чтение файла
	 *
	 * @param string $file
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _isReadable($file=null, $returnData=false)
	{
		$file = self::_getValue($file);
		return self::_return($file ? is_readable($file) : false, $returnData);
	}

	/**
	 * Метод создает директорию
	 *
	 * @param string $dir
	 * @param integer $chmod
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _createDir($dir=null, $chmod=0777, $returnData=false)
	{
		$dir = self::_getValue($dir);
		@mkdir($dir, $chmod, true);
		@chmod($dir, $chmod);
		return self::_return(true, $returnData);
	}

	/**
	 * Метод создает директорию
	 *
	 * @param string $dir
	 * @param integer $chmod
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _mkdir($dir=null, $chmod=0777, $returnData=false)
	{
		$dir = self::_getValue($dir);
		return self::_return(self::createDir($dir, $chmod, true), $returnData);
	}

	/**
	 * Метод читает файл и возвращает его содержимое
	 *
	 * @param string $file
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _read($file=null, $returnData=false)
	{
		$file = self::_getValue($file);
		if (!file_exists($file))
			return self::_return(false, $returnData);

		if (self::_functionExists('file_get_contents'))
			return self::_return(file_get_contents($file));

		if (!$fp = @fopen($file, FOPEN_READ))
			return self::_return(false, $returnData);

		flock($fp, LOCK_SH);

		$data = '';
		if (filesize($file) > 0)
			$data = fread($fp, filesize($file));

		flock($fp, LOCK_UN);
		fclose($fp);

		return self::_return($data, $returnData);
	}

	/**
	 * Метод записывает данные в файл
	 *
	 * @param string $path
	 * @param string $data
	 * @param integer $mode
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _write($path=null, $data=null, $mode=FOPEN_WRITE_CREATE_DESTRUCTIVE, $returnData=false)
	{
		$path = self::_getValue($path);
		if (!$fp = @fopen($path, $mode))
			return self::_return(false, $returnData);

		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);

		return self::_return(true, $returnData);
	}

	/**
	 * Метод возвращает список файлов в директории
	 *
	 * @param string $source_dir
	 * @param bool $include_path
	 * @param bool $_recursion
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _filenames($source_dir=null, $include_path=false, $_recursion=false, $returnData=false)
	{
		$source_dir = self::_getValue($source_dir);
		static $_filedata = array();

		if ($fp = @opendir($source_dir))
		{
			if ($_recursion === false)
			{
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			while (false !== ($file = readdir($fp)))
			{
				if (@is_dir($source_dir.$file) && strncmp($file, '.', 1) !== 0)
					self::filenames($source_dir.$file.DIRECTORY_SEPARATOR, $include_path, true);
				elseif (strncmp($file, '.', 1) !== 0)
					$_filedata[] = ($include_path == true) ? $source_dir.$file : $file;
			}
			return self::_return($_filedata, $returnData);
		} else {
			return self::_return(false, $returnData);
		}
	}

	/**
	 * Метод возвращает информацию о файлах в директории
	 *
	 * @param string $source_dir
	 * @param bool $top_level_only
	 * @param bool $_recursion
	 * @param bool $returnData
	 * @return array
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _filesInfo($source_dir=null, $top_level_only=true, $_recursion=false, $returnData=false)
	{
		$source_dir = self::_getValue($source_dir);
		static $_filedata = array();
		$relative_path = $source_dir;

		if ($fp = @opendir($source_dir))
		{
			// reset the array and make sure $source_dir has a trailing slash on the initial call
			if ($_recursion === false)
			{
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			// foreach (scandir($source_dir, 1) as $file) // In addition to being PHP5+, scandir() is simply not as fast
			while (false !== ($file = readdir($fp)))
			{
				if (@is_dir($source_dir.$file) && strncmp($file, '.', 1) !== 0 && $top_level_only === false)
				{
					self::filesInfo($source_dir.$file.DIRECTORY_SEPARATOR, $top_level_only, false);
				}
				elseif (strncmp($file, '.', 1) !== 0)
				{
					$_filedata[$file] = self::fileInfo($source_dir.$file);
					$_filedata[$file]['relative_path'] = $relative_path;
				}
			}

			return self::_return($_filedata, $returnData);
		} else {
			return self::_return(false, $returnData);
		}
	}

	/**
	 * Метод возвращает информацию файле
	 *
	 * @param string $file
	 * @param mixed $returned_values
	 * @param bool $returnData
	 * @return array
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _fileInfo($file=null, $returned_values=array('name','server_path','size','date'), $returnData=false)
	{
		$file = self::_getValue($file);
		if (!file_exists($file))
			return self::_return(false, $returnData);

		if (is_string($returned_values))
			$returned_values = explode(',', $returned_values);

		foreach ($returned_values as $key) {
			switch ($key) {
				case 'name':
					$fileinfo['name'] = self::pathInfo($file, 'basename');
					break;
				case 'server_path':
					$fileinfo['server_path'] = $file;
					break;
				case 'size':
					$fileinfo['size'] = filesize($file);
					break;
				case 'date':
					$fileinfo['date'] = filemtime($file);
					break;
				case 'readable':
					$fileinfo['readable'] = is_readable($file);
					break;
				case 'writable':
					// There are known problems using is_weritable on IIS.  It may not be reliable - consider fileperms()
					$fileinfo['writable'] = is_writable($file);
					break;
				case 'executable':
					$fileinfo['executable'] = is_executable($file);
					break;
				case 'fileperms':
					$fileinfo['fileperms'] = fileperms($file);
					break;
			}
		}

		return self::_return($fileinfo, $returnData);
	}

	/**
	 * Метод возвращает информацию о пути к файлу
	 *
	 * @param $file
	 * @param $field (dirname, basename, extension, filename)
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _pathInfo($file=null, $field=false, $returnData=false)
	{
		$file = self::_getValue($file);
		$pathInfo = $file ? pathinfo($file) : false;
		return self::_return($pathInfo ? ($field ? $pathInfo[$field] : $pathInfo) : false, $returnData);
	}

	/**
	 * Метод возвращает информацию о размере файла
	 *
	 * @param string $file
	 * @param $format (see {@link CNumberFormatter})
	 * @param bool $returnData
	 * @return mixed
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _size($file=null, $format=false, $returnData=false)
	{
		$file = self::_getValue($file);
		if (self::isFile($file))
			$size = sprintf("%u", filesize($file));

		if ($format !== false)
			$size = self::sizeFormat($size, $format);

		return self::_return($size, $returnData);
	}

	/**
	 * Метод возвращает информацию о размере файла в человекопонятном формате
	 *
	 * @param integer $bytes
	 * @param string $format (see {@link CNumberFormatter})
	 * @param bool $returnData
	 * @return string
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _sizeFormat($bytes=null, $format='', $returnData=false)
	{
		$bytes = self::_getValue($bytes);
		$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

		$bytes = max($bytes, 0);
		$expo = floor(($bytes ? log($bytes) : 0) / log(1024));
		$expo = min($expo, count($units)-1);

		$bytes /= pow(1024, $expo);

		return self::_return(Yii::app()->numberFormatter->format($format, $bytes).' '.$units[$expo], $returnData);
	}

	/**
	 * Метод отсылает файл юзеру
	 *
	 * @param string $file
	 * @param $fakename
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _send($file=null, $fakename=false, $returnData=false)
	{
		$file = self::_getValue($file);
		if (!self::isFile($file) || !self::isReadable($file))
			return false;

		$contentType = self::getMimeType($file);

		if (!$contentType)
			$contentType = "application/octet-stream";

		if ($fakename)
			$filename = $fakename;
		else
			$filename = self::pathInfo($file, 'basename');

		// disable browser caching
		header('Cache-control: private');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

		header('Content-Type: '.$contentType);
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.self::size($file));
		header('Content-Disposition: attachment;filename="'.$filename.'"');

		if ($contents = self::read($file)) {
			echo $contents;
			exit;
		}

		return self::_return(false, $returnData);
	}

	/**
	 * Alias for {@link send}
	 *
	 * @param string $file
	 * @param $fakename
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _download($file=null, $fakename=false, $returnData=false)
	{
		$file = self::_getValue($file);
		return self::_return(self::send($file, $fakename), $returnData);
	}

	/**
	 * Метод возвращает Mime-тип файла
	 *
	 * @param string $file
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _getMimeType($file=null, $returnData=false)
	{
		$file = self::_getValue($file);
		if (self::_functionExists('finfo_open'))
			if(($info=@finfo_open(FILEINFO_MIME)) && ($result=@finfo_file($info,$file))!==false)
				return self::_return($result, $returnData);

		if (self::_functionExists('mime_content_type') && ($result=@mime_content_type($file))!==false)
			return self::_return($result, $returnData);

		return self::_return(self::getMimeTypeByExtension($file), $returnData);
	}

	/**
	 * Метод возвращает Mime-тип файла по его расширению
	 *
	 * @param string $file
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _getMimeTypeByExtension($file=null, $returnData=false)
	{
		$file = self::_getValue($file);
		if (!isset(self::$_storage['extensions']))
			self::$_storage['extensions'] = require Yii::getPathOfAlias('system.utils.mimeTypes').'.php';

		$extension = self::pathInfo($file, 'extension');

		if (!$extension || !isset(self::$_storage['extensions'][$extension]))
			return self::_return(false, $returnData);

		return self::_return(self::$_storage['extensions'][$extension], $returnData);
	}

	/**
	 * Метод возвращает массив с содержимым папки
	 *
	 * @param string $source_dir
	 * @param integer $directory_depth (0 = fully recursive, 1 = current dir, etc)
	 * @param bool $hidden
	 * @param bool $returnData
	 * @return array
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/directory_helper.php
	 */
	public function _map($source_dir=null, $directory_depth=0, $hidden=false, $returnData=false)
	{
		$source_dir = self::_getValue($source_dir);
		if ($fp = @opendir($source_dir))
		{
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

			while (false !== ($file = @readdir($fp)))
			{
				if (!trim($file, '.') || ($hidden == false && $file[0] == '.'))
					continue;

				if (($directory_depth < 1 || $new_depth > 0) && @is_dir($source_dir.$file))
					$filedata[$file] = self::map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
				else
					$filedata[] = $file;
			}

			@closedir($fp);
			return self::_return($filedata, $returnData);
		}

		return self::_return(false, $returnData);
	}

	/**
	 * Метод удаляет все файлы в директории
	 *
	 * @param string $path
	 * @param bool $del_dir
	 * @param integer $level
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 * @see CodeIgniter_2.1.0/system/helpers/file_helper.php
	 */
	public function _cleardir($path=null, $del_dir=true, $level=0, $returnData=false)
	{
		$path = self::_getValue($path);
		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if (!$current_dir = @opendir($path))
			return self::_return(false, $returnData);

		while (false !== ($filename = @readdir($current_dir)))
		{
			if ($filename != "." && $filename != "..") {
				if (is_dir($path.DIRECTORY_SEPARATOR.$filename))
				{
					if (substr($filename, 0, 1) != '.')
						self::rmdir($path.DIRECTORY_SEPARATOR.$filename, $del_dir, $level+1);
				}
				else
				{
					@unlink($path.DIRECTORY_SEPARATOR.$filename);
				}
			}
		}
		@closedir($current_dir);

		if ($del_dir == true && $level > 0)
			return self::_return(@rmdir($path), $returnData);

		return self::_return(true, $returnData);
	}

	/**
	 * Метод удаляет каталог со всем содержимым
	 *
	 * @param string $path
	 * @param bool $returnData
	 * @return bool
	 *
	 * @version 2.0 20.09.2013
	 * @author webmaxx <webmaxx@webmaxx.name>
	 */
	public function _rmdir($path=null, $returnData=false)
	{
		$path = self::_getValue($path);
		if (self::clear($path))
		{
			@rmdir($path);
			return self::_return(true, $returnData);
		}
		return self::_return(false, $returnData);
	}

}
