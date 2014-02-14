<?
function getXLS($xls){
    require_once "PHPExcel.php";
    include_once 'PHPExcel/IOFactory.php';
    $objPHPExcel = PHPExcel_IOFactory::load($xls);
    $objPHPExcel->setActiveSheetIndex(0);
    $aSheet = $objPHPExcel->getActiveSheet();
 
    //���� ������ ����� ��������� ������� ���������� � ���� �������� ����� ������ ������
    $array = array();
    //������� �������� ������ � ��������� �� ���� ������
    foreach($aSheet->getRowIterator() as $row){
      //������� �������� ����� ������� ������
      $cellIterator = $row->getCellIterator();
      //��������� ������ �� ������� ������
      //���� ������ ����� ��������� �������� ������ ��������� ������
      $item = array();
      foreach($cellIterator as $cell){
        //������� �������� ����� ����� ������ � ��������� ������
        array_push($item, iconv('utf-8', 'cp1251', $cell->getCalculatedValue()));
      }
      //������� ������ �� ���������� ����� ��������� ������ � "����� ����� �����"
      array_push($array, $item);
    }
    return $array;
  }
 
  $xlsData = getXLS('data/1.xls'); //�������� ������ �� XLS
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

echo "$cat_num - $category � $sku � $name<br />";
}







?>