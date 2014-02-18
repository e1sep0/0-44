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
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="socialdiscount_status">
                <?php if ($socialdiscount_status) { ?>
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
            <td><input type="text" name="socialdiscount_sort_order" value="<?php echo $socialdiscount_sort_order; ?>" size="1" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_value_like; ?></td>
            <td><input type="text" name="socialdiscount_value_like" value="<?php echo $socialdiscount_value_like; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_value_share; ?></td>
            <td><input type="text" name="socialdiscount_value_share" value="<?php echo $socialdiscount_value_share; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_apiId; ?></td>
            <td><input type="text" name="socialdiscount_apiId" value="<?php echo $socialdiscount_apiId; ?>" size="5" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>