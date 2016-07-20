<?php 
//require_once('App/helpers.php');
/*require_once('Classes/PHPExcel.php');
require_once ('Classes/PHPExcel/IOFactory.php');
$xls = PHPExcel_IOFactory::load('Test.xlsx');
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();*/

//var_dump($xls);
//die;
$site = "http://".$_POST['name']."/robots.txt";
#echo $site;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $site);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);	
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

//Определение размера файла
function getFileSize($url) {
	$fsize = 0;
	$fh = fopen($url, "r");
	while(($str = fread($fh, 1024)) != null) $fsize += strlen($str);
	fclose($fh);
	//echo "Размер файла: " . $fsize . " bytes.";
	return $fsize;
}

if($httpCode == 200) {
		
		//$xls->getActiveSheet()->getCellByColumnandRow(3, 4)->getValue();
    
    echo "Файл существует. <br>";
    echo "Ответ сервера: " . $httpCode . "<br>";
    getFileSize($site);
    echo "<br>";
		//var_dump($result); - тип string
		//xd($result);
		echo "<br>";
    //Проверка указания директивы Host и их количество
    if(preg_match_all('/HOST/', $result, $arr) > 0) {
    	echo "Директива Host указана". "<br>";
    	
    	$counter = substr_count($result, 'HOST');
    	if($counter > 0) {
    		echo "В файле прописано несколько (" . $counter . ") директив Host" . "<br>";
    	}
    } else {
    	echo "В файле robots.txt не указана директива Host" . "<br>";
    }

    //Проверка указания директивы Sitemap и их количество
    if(preg_match_all('/Sitemap/', $result, $arr)) {
    	echo "Директива Sitemap указана". "<br>";
    	
    	$counter = substr_count($result, 'Sitemap');
    	if($counter > 0) {
    		echo "В файле прописано несколько (" . $counter . ") директив Sitemap" . "<br>";
    	}
    } else {
    	echo "В файле robots.txt не указана директива Sitemap" . "<br>";
    }
    
} else {
    echo "Файл не найден. httpCode: ".$httpCode;
}
echo "<br>";
echo '<form action="form.php">
	<button type="submit">Вернуться назад</button>
</form>';

