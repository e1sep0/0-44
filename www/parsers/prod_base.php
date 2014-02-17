<html>
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html charset=utf8">
<!-- <meta http-equiv="Expires" content="Tue, 01 Jan 1980 00:00:00 GMT"> -->
</head><body>
<?php
ini_set("max_execution_time", "600000");
 $connect=mysql_connect("localhost","root","hoh5wait");
 $db=mysql_select_db("ocstore");
 mysql_query("SET NAMES utf8");
 /*$phone=array();
 $txtAds=array();
 $addr=array();
 $price=array();*/
 $q="SELECT * FROM articuls LIMIT 1";
$res=mysql_query($q);
 While ($row=mysql_fetch_array($res)){
   $q1="SELECT category_id,COUNT(category_id) FROM oc_category_description WHERE name='".$row[4]."'";
   $res1=mysql_query($q1);
    While ($row1=mysql_fetch_array($res1)){
      if($row1[1]>1){
          $q2="SELECT cat.category_id,descr.name FROM oc_category_description des LEFT JOIN oc_category cat ON des.category_id=cat.parent_id, oc_category_description descr WHERE des.name='".$row[3]."' AND descr.category_id=cat.category_id AND descr.name='".$row[4]."'";
          $res2=mysql_query($q2);
          While ($row2=mysql_fetch_array($res2)){
            $category=$row2[0];
          }
      }else{
        $category=$row1[0];
      } 
    }
	echo $category.$row[0].$row[1].$row[2].$row[3].$row[4].$row[6];
	$pr=(float)$row[5];
	$price=($pr+(0.15*$pr))*35.0976;
 mysql_query("INSERT INTO oc_product (model,sku,quantity,shipping,minimum,status,weight_class_id,stock_status_id,image,price,date_available,date_added) 
				VALUES ('-','".$row[1]."',999,1,1,1,1,5,'".str_replace("http://img.focalprice.com/550x426/IP","data",$row[7])."',".$row[5].",NOW(),NOW())");
 mysql_query("INSERT INTO oc_product_description (product_id,language_id,name,description) VALUES (".$row[0].",1,'".trim($row[2])."','".trim($row[6])."')");
 mysql_query("INSERT INTO oc_product_to_category (product_id,category_id,main_category) VALUES (".$row[0].",$category,1)");
 mysql_query("INSERT INTO oc_product_to_store (product_id,store_id) VALUES (".$row[0].",0)");              
               

 }
 mysql_close($connect);
?>
</body>
</html>