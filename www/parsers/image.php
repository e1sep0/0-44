<html>
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<!-- <meta http-equiv="Expires" content="Tue, 01 Jan 1980 00:00:00 GMT"> -->
</head><body>
<?php
ini_set("max_execution_time", "600000");
 $connect=mysql_connect("localhost","u8950171_frolov","antosh1k");
 $db=mysql_select_db("u8950171_0-44");
 mysql_query("SET NAMES utf8");
 /*$phone=array();
 $txtAds=array();
 $addr=array();
 $price=array();*/
 $q="SELECT product_id,sku FROM oc_product";
$res=mysql_query($q); 
 While ($row=mysql_fetch_array($res)){
  $q1="SELECT COUNT(product_id) FROM oc_product_image WHERE product_id=".$row[0]."";
  $res1=mysql_query($q1); 
  While ($row1=mysql_fetch_array($res1)){
  if($row1[0]==0){
    image($row[0],substr($row[1],0,-1));
  }
  }
 }
 function image($id,$sku){
 $i=1;
  if ($handle = opendir("../image/data/$sku")) {
    
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != ".." && !strpos($entry,"-1.jpg")) {
        mysql_query("INSERT INTO oc_product_image (product_id,image,sort_order) VALUES ($id,'data/$sku/$entry',$i)");
        $i++;
      }
    }
  
  }
  
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 mysql_close($connect);
?>
</body>
</html>