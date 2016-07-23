<?php 

require_once('App/helpers.php');
$query = $_POST['name'];
$site = "http://".$query."/robots.txt";
$queryName = explode(".", $query);
$fileName = $queryName[0].'.xlsx';

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
	$fsize = intval(round($fsize/1024));
	return $fsize; 
	}

require_once('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/IOFactory.php');

//Берём исходную таблицу
$Test = PHPExcel_IOFactory::load('Test.xlsx');
$Test->setActiveSheetIndex(0);

if($httpCode == 200) {
	//Файл существует
	//isFile
	$Test->getActiveSheet()->getStyle('A3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$Test->getActiveSheet()->getStyle('A3')->getFill()->getStartColor()->setARGB('FFFF00');

	for ($i = 5; $i <= 31; $i++) {
		$Test->getActiveSheet()->getRowDimension($i)->setVisible(false);
	}

  //Проверка размера файла robots.txt
  $fsize = getFileSize($site);
  
  if($fsize > 32) {
  	$value = preg_replace('/__/', $fsize." Kb", $Test->getActiveSheet()->getCell('E20')->getValue());
  	$Test->getActiveSheet()->setCellValue('E20', $value);
  	//setVisibleRows(20, 21);
  	$Test->getActiveSheet()->getRowDimension(20)->setVisible(true);
		$Test->getActiveSheet()->getRowDimension(21)->setVisible(true);
		$Test->getActiveSheet()->getStyle('A20')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$Test->getActiveSheet()->getStyle('A20')->getFill()->getStartColor()->setARGB('FFFF00');
  } else {
  	$value = preg_replace('/__/', $fsize." Kb", $Test->getActiveSheet()->getCell('E18')->getValue());
  	$Test->getActiveSheet()->setCellValue('E18', $value);
  	//setVisibleRows(18, 19);
  	$Test->getActiveSheet()->getRowDimension(18)->setVisible(true);
		$Test->getActiveSheet()->getRowDimension(19)->setVisible(true);
		$Test->getActiveSheet()->getStyle('A18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$Test->getActiveSheet()->getStyle('A18')->getFill()->getStartColor()->setARGB('FFFF00');
  }
    //Проверка указания директивы Host и их количество
    if(preg_match_all('/Host/', $result, $arr) > 0) {
    	//Директива Host указана
    	//setVisibleRows(8, 9);
    	$Test->getActiveSheet()->getRowDimension(8)->setVisible(true);
			$Test->getActiveSheet()->getRowDimension(9)->setVisible(true);
			$Test->getActiveSheet()->getStyle('A8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$Test->getActiveSheet()->getStyle('A8')->getFill()->getStartColor()->setARGB('FFFF00');
    	    	
    	//Проверка количества директив Host, прописанных в файле
    	$counter = substr_count($result, 'Host');
    	if($counter == 1) {
    		//В файле прописана 1 директива Host
    		//setVisibleRows(13, 14);
    		$Test->getActiveSheet()->getRowDimension(13)->setVisible(true);
				$Test->getActiveSheet()->getRowDimension(14)->setVisible(true);
				$Test->getActiveSheet()->getStyle('A13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$Test->getActiveSheet()->getStyle('A13')->getFill()->getStartColor()->setARGB('FFFF00');
    	} else {
    		//В файле прописано несколько директив Host
    		//setVisibleRows(15, 16);
    		$Test->getActiveSheet()->getRowDimension(15)->setVisible(true);
				$Test->getActiveSheet()->getRowDimension(16)->setVisible(true);
				$Test->getActiveSheet()->getStyle('A15')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$Test->getActiveSheet()->getStyle('A15')->getFill()->getStartColor()->setARGB('FFFF00');
    	}
    } else {
  		//В файле robots.txt не указана директива Host
  		//setVisibleRows(10, 11);
  		$Test->getActiveSheet()->getRowDimension(10)->setVisible(true);
			$Test->getActiveSheet()->getRowDimension(11)->setVisible(true);
			$Test->getActiveSheet()->getStyle('A10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$Test->getActiveSheet()->getStyle('A10')->getFill()->getStartColor()->setARGB('FFFF00');
    }

    //Проверка указания директивы Sitemap и их количество
    if(preg_match_all('/Sitemap/', $result, $arr)) {
    	//Директива Sitemap указана
    	//setVisibleRows(23, 24);
    	$Test->getActiveSheet()->getRowDimension(23)->setVisible(true);
			$Test->getActiveSheet()->getRowDimension(24)->setVisible(true);
			$Test->getActiveSheet()->getStyle('A23')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$Test->getActiveSheet()->getStyle('A23')->getFill()->getStartColor()->setARGB('FFFF00');
    	
    } else {
    	//В файле robots.txt не указана директива Sitemap
    	//setVisibleRows(25, 26);
    	$Test->getActiveSheet()->getRowDimension(25)->setVisible(true);
			$Test->getActiveSheet()->getRowDimension(26)->setVisible(true);
			$Test->getActiveSheet()->getStyle('A25')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$Test->getActiveSheet()->getStyle('A25')->getFill()->getStartColor()->setARGB('FFFF00');

    }
  //setVisibleRows(28, 29);
  $Test->getActiveSheet()->getRowDimension(28)->setVisible(true);
	$Test->getActiveSheet()->getRowDimension(29)->setVisible(true);
	$Test->getActiveSheet()->getStyle('A28')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$Test->getActiveSheet()->getStyle('A28')->getFill()->getStartColor()->setARGB('FFFF00');

} else {
    //Файл не найден.
		$Test->getActiveSheet()->getRowDimension(3)->setVisible(false);
		$Test->getActiveSheet()->getRowDimension(4)->setVisible(false);
		$Test->getActiveSheet()->getStyle('A5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$Test->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('FFFF00');

		for ($i = 7; $i <= 31; $i++) {
			$Test->getActiveSheet()->getRowDimension($i)->setVisible(false);
		}
		//noFile
		$value = preg_replace('/\(указать код\)/', $httpCode, $Test->getActiveSheet()->getCell('E30')->getValue());
  	$Test->getActiveSheet()->setCellValue('E30', $value);
		//setVisibleRows($Test, 30, 31);
		$Test->getActiveSheet()->getRowDimension(30)->setVisible(true);
		$Test->getActiveSheet()->getRowDimension(31)->setVisible(true);
		$Test->getActiveSheet()->getStyle('A30')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$Test->getActiveSheet()->getStyle('A30')->getFill()->getStartColor()->setARGB('FFFF00');
}
//saveFile($Test);
$objWriter = PHPExcel_IOFactory::createWriter($Test, 'Excel2007');
$objWriter->save("$fileName");

echo '<a href='.$fileName.'><button type="submit">Открыть таблицу</button></a>';
echo "<br>";
echo '<form action="form.php"><button type="submit">Вернуться назад</button></form>';
echo "<br>";


