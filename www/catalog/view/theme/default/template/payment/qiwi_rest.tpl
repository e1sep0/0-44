<div class="content">
<p><?php echo $sub_text_info; ?></p>
<form action="<?php echo $action; ?>" method="get" id="payments" >
	<input type="hidden" name="shop" value="<?php echo $shop; ?>" />
	<input type="hidden" name="transaction" value="<?php echo $transaction; ?>" />
	<input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>" />
	<input type="hidden" name="failUrl" value="<?php echo $failUrl; ?>" />

	<input type="hidden" name="qiwi_phone" value="" />

	<div style="text-align: right;"><?php echo $markup; ?></div><br>


</form>

<?php if ($summ < 15000) { ?>
	<div style="text-align: right;"><?php echo $sub_text_info_phone; ?><input type="text" name="qiwi_rest_phone" value="<?php echo $phone; ?>" size="15" maxlength="15"></div><br>
<?php } else { ?>
	<center><?php echo $qiwi_rest_limit; ?></center>
<?php } ?>

</div>
<div class="buttons">
<?php if ($summ < 15000) { ?>
    <div class="right"><a id="payment" class="button"><span><?php echo $button_confirm; ?></span></a> </div>
<?php } else { ?>
    <div class="right"><a id="payment_back" class="button"><span><?php echo $button_back; ?></span></a> </div>
<?php } ?>

</div>


<script type="text/javascript">


$(document).ready(function(){
	$("#payment").click(function(event){
			$.ajax({
	 		type: 'POST',
			url: 'index.php?route=payment/qiwi_rest/confirm',
			data: 'qiwi_phone=' + encodeURIComponent('+' + $('input[name=\'qiwi_rest_phone\']').val()) + '&qiwi_com=' +  encodeURIComponent('<?php echo $com; ?>'), 
			success: function () {

				$('input[name=qiwi_phone]').val( '+' + $('input[name=qiwi_rest_phone]').val() );
	     			$('#payments').submit();
			}
	
			});

	return false;
	});


	$("#payment_back").click(function(event){
	 		location.href = 'index.php?route=checkout/cart'	
	return false;
	});

});


</script>
