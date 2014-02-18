
<?php echo $header; ?>
<meta charset="UTF-8" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<div id="content">
  <div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
      <h1><img src="view/image/lockscreen.png" alt="" /> Введите логин и пароль</h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
      <?php if ($success) { ?>
      <div class="success"><?php echo $success; ?></div>
      <?php } ?>
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table style="width: 100%;">
          <tr>
            <td style="text-align: center;" rowspan="4"><img src="view/image/login.png" alt="Логин" /></td>
          </tr>
          <tr>
            <td>Логин<br />
              <input type="text" name="username" value="" style="margin-top: 4px;" />
              <br />
              <br />
              Пароль<br />
              <input type="password" name="password" value="" style="margin-top: 4px;" />
              <?php if ($forgotten) { ?>
              <br />
              <a href="<?php echo $forgotten; ?>">Забыли пароль?</a>
              <?php } ?>
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: right;"><a onclick="alert('Неверный логин или пароль!')" class="button">Войти</a></td>
          </tr>
        </table>
        <?php if ($redirect) { ?>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>