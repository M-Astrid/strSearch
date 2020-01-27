<?php
/*
Библиотека для поиска по текстовым файлам
*/

// подключаем файл автозагрузки 
require_once __DIR__.'/vendor/autoload.php';

// подключаем компоненты symfony для парсинга yaml
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
// компонент для определения mime-type
use FInfo\FInfo;


class StrSearch
{
	const PATH_TO_CONFIG = __DIR__.'\config.yaml';
	
	/*
	$file - путь к файлу или url, если файл на удаленном сервере
	$find - искомый фрагмент
	
	Фрагмент найден в файле - true, если нет - false
	*/
	public static function stringFound($file, $find)
	{
		self::checkRestrictions($file);
		return strpos(file_get_contents($file), $find) !== false;
	}
		
	/* 
	Ищет строку в файле
	
	Возвращает массив, ['line' => номер строки в файле, 'position' => положение в строке] 
	или false, если строка не найдена
	*/
	public static function position($file, $find)
	{
		self::checkRestrictions($file);
		
		$line_number = false; 
		if ($handle = fopen($file, "r")) 
		{ 
			$count = 0;
			while (($line = fgets($handle)) !== FALSE) 
			{
				$count++;
				$position = strpos($line, $find);
				if ($position !== FALSE)
				{
					fclose($handle);
					return array('line' => $count, 'position' => $position);
				}
			}
			return false;
		}
	}
	
	
	private static function parseConfig()
	{
		try {
			$value = Yaml::parseFile(self::PATH_TO_CONFIG);
		} catch (ParseException $exception) {
			printf('Произошла ошибка во время чтения YAML конфига: %s', $exception->getMessage());
		}
		return $value;
	}
	
	private static function checkRestrictions($file)
	{
		if (isset(self::parseConfig()['restrictions']))
		{
			$restrictions = self::parseConfig()['restrictions'];
			// проверяем размер
			if(isset($restrictions['max_size']) and filesize($file) > $restrictions['max_size']) die('Файл превышает допустимый размер');
			// проверяем mime-тип
			if(isset($restrictions['mime-types']) and !(in_array(FInfo::mime_content_type($file), $restrictions['mime-types'])))
			{
				$string = implode($restrictions['mime-types']);
				die("Недопустимый mime-тип файла. Доступные: $string");
			}
		}
	}
}