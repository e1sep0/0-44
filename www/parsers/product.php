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
 mysql_query("SET NAMES cp1251");
 /*$phone=array();
 $txtAds=array();
 $addr=array();
 $price=array();*/
 $q="SELECT id,articul FROM articuls LIMIT 2";
$res=mysql_query($q); 
 While ($row=mysql_fetch_array($res)){
 
 if($curl = curl_init()){
 //for ($i=1322;$i<=1322;$i++){
    $cat="";
    echo $row[1].'-';
    curl_setopt($curl,CURLOPT_URL,"http://ru.focalprice.com/".$row[1]."/?Currency=RUB");//http://dynamic.focalprice.com/IP2429W/
    curl_setopt($curl, CURLOPT_USERAGENT, "Chrome/32.0.1700.107");
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 120);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
    $out = curl_exec($curl);
  //  print_r($out);
   // print_r(curl_getinfo( $curl ));
    //Категория
    $arr=explode("<em>&#187;</em>",$out);

      $tcat=explode("</a>",$arr[1]);
      $cat=explode(">",$tcat[0]);
      $main_cat=$cat[1];
     // print_r($arr);
     //echo $arr[1];
      if($arr[2]){
        
      $tcat=explode("</a>",$arr[2]);
      $cat=explode(">",$tcat[0]);
      $par_cat=$cat[1];
      }
      
      if($arr[3]){
        
      $tcat=explode("</a>",$arr[3]);
      $cat=explode(">",$tcat[0]);
      $par_cat=$cat[1];
      }
      //Цена
      
      $arr=explode("id=\"unit_price_RU\" language=\"RU\">",$out);
      $pr=explode("</sup>",$arr[1]);
      $price=str_replace("<sup>","",$pr[0]);
      
      //Описание
      
      $topis=explode("<div id=\"summary\">",$out);
      $temp=explode("</div>",$topis[1]);
      $opis=$temp[0];
      
      //Картинки
      $pic=array();
      $fl=0;
      $pics_mas=explode("<ul id=\"imgs\" class=\"list_h\">",$out);
      $mass=explode("jqimg=\"",$pics_mas[1]);
      foreach($mass as $t){
        if($fl==1){
        $t_pic=explode("\" jqimg2=",$t);
          $pic[]=$t_pic[0];
          }
          $fl=1;
      }
      
      
    echo "".$row[0]."-$main_cat - $par_cat-$price-$opis<br>";       
    print_r($pic);              
          
  }
  echo "<br><br><br>";      
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