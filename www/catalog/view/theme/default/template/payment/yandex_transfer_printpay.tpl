<html>
<head>
<title>Оплата VISA, Master Card, Яндекс.Деньги - <?php echo $inn ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=win-1251" />
<meta name='description' content='<?php echo $inn ?>' />
</head>
<body>
<center>
</br></br>
<font size="6">Оплата VISA, Master Card, Яндекс.Деньги</font>
</br></br>
<font size="3" color="red">
ВНИМАНИЕ!<br />
Сумма платежа указана с учётом комиссии платёжной системы Яндекс (+2.5%)</font><br />
<font size="2"><b>Итого к оплате:</b> <?php echo $amount." руб. (сумма заказа) + ".round($amount*0.02502333333,2)." руб. (комиссия Яндекс) = ".round($amount+$amount*0.02502333333,2)." руб." ?>
</br></br>
<i>Если у Вас возникли вопросы, телефон для справок: <?php echo $bankuser ?></i></font>
</br></br>
<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?uid=<?php echo $bank ?>&payment-type-choice=on&writer=seller&targets=%d0%9e%d0%bf%d0%bb%d0%b0%d1%82%d0%b0+%d0%b7%d0%b0%d0%ba%d0%b0%d0%b7%d0%b0+%e2%84%96+<?php echo $order_id ?>&default-sum=<?php echo round($amount+$amount*0.02502333333,2) ?>&button-text=01&hint=" scrolling="no" width="450" frameborder="0" height="220">
</iframe>
</br></br>
<font size="3"><?php echo $inn ?> - <a href="<?php echo $rs ?>"><?php echo $rs ?></a></font>
</center>
</body>
<html>