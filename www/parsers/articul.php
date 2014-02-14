<html>
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html charset=windows-1251">
<!-- <meta http-equiv="Expires" content="Tue, 01 Jan 1980 00:00:00 GMT"> -->
</head><body>
<?php
ini_set("max_execution_time", "600");
 $connect=mysql_connect("localhost","root","");
 $db=mysql_select_db("ocstore");
 mysql_query("SET NAMES utf8");
 /*$phone=array();
 $txtAds=array();
 $addr=array();
 $price=array();*/
 
 
 if($curl = curl_init()){
 //for ($i=1322;$i<=1322;$i++){
  for ($j=1;$j<=17;$j++){
    $cat="";
    curl_setopt($curl,CURLOPT_URL,"http://dynamic.ru.focalprice.com/sitemap/apparel-accessories-products-$j");
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    $arr=explode("<li class=\"w1000\">",$out);
    
    foreach($arr as $out){
    $mas=explode("<a href=\"http://ru.focalprice.com/",$out);
    $out=$mas[1];
    $mas=explode("\">",$out);
    $t_art=explode("/",$mas[0]);
    $articul=$t_art[0];
    $text=explode("</a>",$mas[1]);
    $name=$text[0];
    if($articul!=''){
      mysql_query("INSERT INTO articuls (articul,name) VALUES ('".$articul."','".$name."')");
    }

    //echo "$articul - $name<br>";
   
   }           
              
              
  }
          
        
    }
 //   }
    echo "Конец!";
   /* print_r($rubr);
    print_r($phone);
    print_r($txtAds);
    print_r($addr);
    print_r($price);*/
 curl_close($curl);
 mysql_close($connect);
?>
</body>
</html>