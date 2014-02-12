<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

      <table width=100%>
	<tr><td width=10 valign=top>
<a onclick="window.open(\'http://qiwi.ru/\');"><img  src="view/image/payment/qiwi_rest2.jpg" alt="QIWI Кошелек" title="QIWI Кошелек" style="border: 1px solid #EEEEEE;" /></a>
</td>
<td>

      <table class="form">

        <tr>
          <td><?php echo $entry_ccy_select; ?></td>
          <td><select name="qiwi_rest_ccy_select">
              <?php foreach ($currencies as $currency) { ?>
              <?php if ($currency['code'] == $qiwi_rest_ccy_select) { ?>
              <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>


        <tr>
          <td><span class="required">*</span> <?php echo $entry_shop_id; ?></td>
          <td><input type="text" name="qiwi_rest_shop_id" value="<?php echo $qiwi_rest_shop_id; ?>" />
            <?php if ($error_shop_id) { ?>
            <span class="error"><?php echo $error_shop_id; ?></span>
            <?php } ?></td>
        </tr>

        <tr>
          <td><span class="required">*</span> <?php echo $entry_rest_id; ?></td>
          <td><input type="text" name="qiwi_rest_id" value="<?php echo $qiwi_rest_id; ?>" />
            <?php if ($error_rest_id) { ?>
            <span class="error"><?php echo $error_rest_id; ?></span>
            <?php } ?></td>
        </tr>

        <tr>
          <td><span class="required">*</span> <?php echo $entry_rest_password; ?></td>
          <td><input type="password" name="qiwi_rest_password" value="<?php echo $qiwi_rest_password; ?>" size="40"/>
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>

        <tr>
          <td><?php echo $entry_qiwi_rest_mode; ?></td>
          <td>

<select name="qiwi_rest_mode_select">
              <?php foreach ($entry_qiwi_rest_modes as $mode) { ?>
              <?php if ($mode['code'] == $qiwi_rest_mode_select) { ?>
              <option value="<?php echo $mode['code']; ?>" selected="selected"><?php echo $mode['code_text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $mode['code']; ?>"><?php echo $mode['code_text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
</td>
        </tr>


        <tr>
          <td><?php echo $entry_qiwi_rest_show_picture; ?></td>
          <td>

<select name="qiwi_rest_mode_show_picture">
              <?php foreach ($entry_qiwi_rest_modes_show_picture as $mode) { ?>
              <?php if ($mode['code'] == $qiwi_rest_mode_show_picture) { ?>
              <option value="<?php echo $mode['code']; ?>" selected="selected"><?php echo $mode['code_text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $mode['code']; ?>"><?php echo $mode['code_text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
</td>
        </tr>


        <tr>
          <td><?php echo $entry_result_url; ?></td>
          <td><?php echo $qiwi_rest_result_url; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="qiwi_rest_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $qiwi_rest_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_order_status_cancel; ?></td>
          <td><select name="qiwi_rest_order_status_cancel_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $qiwi_rest_order_status_cancel_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_order_status_progress; ?></td>
          <td><select name="qiwi_rest_order_status_progress_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $qiwi_rest_order_status_progress_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		 <tr>
          <td><span class="required">*</span> <?php echo $entry_lifetime; ?></td>
          <td><input type="text" name="qiwi_rest_lifetime" value="<?php echo $qiwi_rest_lifetime; ?>" />
            <?php if ($error_lifetime) { ?>
            <span class="error"><?php echo $error_lifetime; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="qiwi_rest_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $qiwi_rest_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="qiwi_rest_status">
              <?php if ($qiwi_rest_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="qiwi_rest_sort_order" value="<?php echo $qiwi_rest_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_markup; ?></td>
          <td><input type="text" name="qiwi_rest_markup" value="<?php echo $qiwi_rest_markup; ?>" size="1" /></td>
        </tr>
      </table>


        </td></tr>
      </table>



    </form>

<br>
		<div style="text-align:center; color:#555555;">QIWI v<?php echo $qiwi_rest_version; ?></div>

  </div>
</div>
<?php echo $footer; ?>