<?php echo $header ?>
<style>
	.tab-inner-form {float:left;width:200px;border-right:1px #CCC dotted;margin-right:20px}
	.tab-inner-form2 {float:left;width:300px;border-right:1px #CCC dotted;margin-right:20px}
	.tab-inner-description {overflow:hidden}
</style>

<div id="content">

<div class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<?php echo $breadcrumb['separator'] ?><a href="<?php echo $breadcrumb['href'] ?>"><?php echo $breadcrumb['text'] ?></a>
	<?php } ?>
</div>

<div class="box">

	<div class="heading">
	<h1><img src="view/image/module.png" /><?php echo $heading_title ?></h1>
	<div class="buttons">
		<a onclick="$('#setting-form').submit();" class="button"><?php echo $button_save ?></a>
		<a onclick="location='<?php echo $url_cancel ?>';" class="button"><?php echo $button_cancel ?></a>
	</div>
	</div>

<div class="content">
 
	<div id="tabs" class="htabs">
	<a href="#tab-connection"><?php echo $oc_smsc_tab_connection ?></a>
	<a href="#tab-admin"><?php echo $oc_smsc_tab_member ?></a>
	<a href="#tab-customer"><?php echo $oc_smsc_tab_customer ?></a>
	</div>

	<form action="<?php echo $url_action ?>" method="post" enctype="multipart/form-data" id="setting-form" onsubmit="create_hidden_fields()">

		<div id="tab-connection">

		<div class="tab-inner-form">

			<p>
			<label>
				<?php echo $oc_smsc_text_login ?> <span class="required">*</span><br />
				<input type="text" name="oc_smsc_login" value="<?php echo (isset($value_oc_smsc_login) ? $value_oc_smsc_login :false) ?>" />
			</label>
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_text_password ?> <span class="required">*</span><br />
				<input type="password" name="oc_smsc_password" value="<?php echo (isset($value_oc_smsc_password) ? $value_oc_smsc_password : false) ?>" />
			</label>
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_text_signature ?><br />
				<input type="text" name="oc_smsc_signature" value="<?php echo (isset($value_oc_smsc_signature) ? $value_oc_smsc_signature : false) ?>" />
			</label>
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_text_maxsms ?><br />
				<input type="text" name="oc_smsc_maxsms" value="<?php echo (isset($value_oc_smsc_maxsms) ? $value_oc_smsc_maxsms : false) ?>" />&nbsp;<?php echo $oc_smsc_text_sms ?>
			</label>
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_debug" value="1" <?php echo (isset($value_oc_smsc_debug) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_debug ?>
				</label>
			</p>

		</div>

		<div class="tab-inner-description">

			<p>
			<?php echo $oc_smsc_text_connection_tab_description ?>
			</p>

		</div>

		</div>

		<div id="tab-admin">

		<div class="tab-inner-form2">

			<p>
				<?php echo $oc_smsc_text_notify_by_sms ?>:
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_admin_new_customer" value="1" <?php echo (isset($value_oc_smsc_admin_new_customer) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_admin_new_customer ?>
				</label>
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_admin_new_order" value="1" <?php echo (isset($value_oc_smsc_admin_new_order) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_admin_new_order ?>
				</label>
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_admin_new_email" value="1" <?php echo (isset($value_oc_smsc_admin_new_email) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_admin_new_email ?>
				</label>
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_text_telephone ?><br />
				<input type="text" name="oc_smsc_telephone" value="<?php echo (isset($value_oc_smsc_telephone) ? $value_oc_smsc_telephone : false) ?>" />
			</label>
			</p>

		</div>

		<div class="tab-inner-form2">

			<p>
				<?php echo $oc_smsc_text_notify ?>:
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_label_admin_new_order ?><br />
				<textarea cols=50 rows=3 name="oc_smsc_textarea_admin_new_order"><?php echo (!empty($value_oc_smsc_textarea_admin_new_order) ? $value_oc_smsc_textarea_admin_new_order : $oc_smsc_text_admin_new_order) ?></textarea>
			</label>
			</p>

		</div>

		<div class="tab-inner-description">

			<p>
				<?php echo $oc_smsc_text_macros_description ?>
			</p>
		</div>

		</div>

		<div id="tab-customer">

		<div class="tab-inner-form2">

			<p>
				<?php echo $oc_smsc_text_notify_by_sms ?>:
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_customer_new_order" value="1" <?php echo (isset($value_oc_smsc_customer_new_order) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_customer_new_order ?>
				</label>
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_customer_new_order_status" value="1" <?php echo (isset($value_oc_smsc_customer_new_order_status) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_customer_new_order_status ?>
				</label>
			</p>

			<p>
				<label>
				<input type="checkbox" name="oc_smsc_customer_new_register" value="1" <?php echo (isset($value_oc_smsc_customer_new_register) ? 'checked="checked"' : false) ?> />
				<?php echo $oc_smsc_text_customer_new_register ?>
				</label>
			</p>

		</div>

		<div class="tab-inner-form2">

			<p>
				<?php echo $oc_smsc_text_notify ?>:
			</p>

			<p>
			<label>
				<?php echo $oc_smsc_label_customer_new_order ?><br />
				<textarea cols=50 rows=3 name="oc_smsc_textarea_customer_new_order"><?php echo (!empty($value_oc_smsc_textarea_customer_new_order) ? $value_oc_smsc_textarea_customer_new_order : $oc_smsc_text_customer_new_order) ?></textarea>
			</label>
			</p>

			<p>
			<label>
				<p>
					<br /><?php echo $oc_smsc_label_customer_new_status.":<br />".$oc_smsc_text_status ?>&nbsp;
					<select name="oc_smsc_select_customer_new_status" id="oc_smsc_select_customer_new_status" onchange="oc_smsc_textarea_customer_new_status.value = return_status_mes(this)">
					<?php
						$stat_num = $options = "";

						$fonf = !empty($this->status_id_message->rows);

						foreach ($this->order_statuses->rows as $k => $v) {
							$options .= "<option ".($k ? "" : "selected")." value=".$v['order_status_id'].">".$v['name']."</option>";
							$stat_num .= ($k ? "," : "")."[".$v['order_status_id'].",";
							if ($fonf)
								foreach ($this->status_id_message->rows as $kid => $vid) {
									if (substr($vid['key'], 18) == $v['order_status_id']) {
										$stat_num .= '"'.($vid['value'] ? $vid['value'] : '').'"]';
										break;
									}

									if ($kid == count($this->status_id_message->rows) - 1)
										$stat_num .= '""]';
								}
							else
								$stat_num .= '"'.$this->config->get('oc_smsc_textarea_customer_new_status').'"]';
						}
						echo $options;
					?>
					</select>
				</p>
				<textarea cols=50 rows=3 name="oc_smsc_textarea_customer_new_status" onchange="save_notify_mes(oc_smsc_select_customer_new_status, this)"><?php echo (!empty($value_oc_smsc_textarea_customer_new_status) ? $value_oc_smsc_textarea_customer_new_status : $oc_smsc_message_customer_new_order_status) ?></textarea>
			</label>
			</p>

		</div>

		<div class="tab-inner-description">

			<p>
				<?php echo $oc_smsc_text_macros_description ?>
			</p>
		</div>

		</div>
		<input type="hidden" name="setting_form" value="1" />

	</form>
 
</div>

</div>

</div>

<script type="text/javascript">
<!--
$('#tabs a').tabs()
//-->

var status_ids_mes = [<?php echo $stat_num ?>]

var HTMLdecoder = document.createElement('textarea')
var HTMLencoder = document.createElement('div')

var create_change = document.getElementById('oc_smsc_select_customer_new_status')
var evnt = document.createEvent('HTMLEvents')

evnt.initEvent('change', true, false)

create_change.dispatchEvent(evnt)

function save_notify_mes(st_id, notify_mes) {
	var i, text

	for (i = 0; i < status_ids_mes.length; i++)
		if (status_ids_mes[i][0] == st_id.value) {
			text = document.createTextNode(notify_mes.value)
			HTMLencoder.appendChild(text)
			status_ids_mes[i][1] = HTMLencoder.innerHTML
			break
		}
}

function return_status_mes(status) {
	for (var i = 0; i < status_ids_mes.length; i++)
		if (status_ids_mes[i][0] == status.value) {
			HTMLdecoder.innerHTML = status_ids_mes[i][1]

			return HTMLdecoder.value
		}
}

function create_hidden_fields() {
	var inp, i

	for (i = 0; i < status_ids_mes.length; i++) {
		inp = document.createElement('input')
		inp.name = 'oc_smsc_status_id_' + status_ids_mes[i][0]
		inp.type = 'hidden'

		HTMLdecoder.innerHTML = status_ids_mes[i][1]

		inp.value = HTMLdecoder.value
		document.getElementById('setting-form').appendChild(inp)
	}
}

</script>

<?php echo $footer ?>
