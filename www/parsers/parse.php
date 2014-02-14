<?
function getXLS($xls){
    require_once "PHPExcel.php";
    include_once 'PHPExcel/IOFactory.php';
    $objPHPExcel = PHPExcel_IOFactory::load($xls);
    $objPHPExcel->setActiveSheetIndex(0);
    $aSheet = $objPHPExcel->getActiveSheet();
 
    //этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
    $array = array();
    //получим итератор строки и пройдемся по нему циклом
    foreach($aSheet->getRowIterator() as $row){
      //получим итератор ячеек текущей строки
      $cellIterator = $row->getCellIterator();
      //пройдемся циклом по ячейкам строки
      //этот массив будет содержать значения каждой отдельной строки
      $item = array();
      foreach($cellIterator as $cell){
        //заносим значения ячеек одной строки в отдельный массив
        array_push($item, iconv('utf-8', 'cp1251', $cell->getCalculatedValue()));
      }
      //заносим массив со значениями ячеек отдельной строки в "общий массв строк"
      array_push($array, $item);
    }
    return $array;
  }
 
  $xlsData = getXLS('data/1.xls'); //извлеаем данные из XLS
  $categ = getXLS('data/backup_categories_products_last.xlsx');
//print_r($xlsData);
foreach($xlsData as $ar_colls){
$category = $ar_colls[2];
  foreach($categ as $cat_colls){
    if(trim($cat_colls[2])==trim($category)){
      $cat_num = $cat_colls[0];
    }
  }
$sku = $ar_colls[3];
$name = $ar_colls[4];

echo "$cat_num - $category — $sku — $name<br />";
}







?>