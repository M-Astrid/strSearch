	Библиотека PHP для поиска по текстовым файлам

Пример использования:
	/* 
	Распакуйте архив с библиотекой на сервере и подключите
	Если требуется, укажите ограничения по размеру или mime-type в config.yaml
	*/

	require_once('path/to/StrSearch.php');

	$file = 'data.txt'; // путь к файлу или url, если файл на удаленном сервере
	$find = 'Искомая строка'; // искомый фрагмент
	
	StrSearch::stringFound($file, $find); // boolean
	StrSearch::position($file, $find); // array('line' => номер строки в файле, 'position' => положение в строке), если совпадений не найдено - false

Требования:
	PHP 7+
	Composer
	Windows or Unix
