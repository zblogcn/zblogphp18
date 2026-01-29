<?php
require '../../../zb_system/function/c_system_base.php';

require '../../../zb_system/function/c_system_admin.php';

require dirname(__FILE__) . '/function.php';
if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require '../../../zb_system/admin2/function/admin2_function.php';
}
$zbp->Load();

$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);

    exit();
}

if (!$zbp->CheckPlugin('AppCentre')) {
    $zbp->ShowError(48);

    exit();
}

if (count($_POST) > 0) {
    if (function_exists('CheckIsRefererValid')) {
        CheckIsRefererValid();
    }
    file_put_contents($zbp->path . 'zb_users/data/appcentre_security_mode.php', '');
}

$blogtitle = AppCentre_GetBlogTitle() . '-' . $zbp->lang['AppCentre']['safe_mode'];

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    ob_start(); ?>
<style>
.warning { 
  font-size: 150%; 
  line-height: 2em;
  text-align: center;
  background: white;
}
.warning .button {
  height: 100%;
}
</style>
  <div class="warning">
<?php
if (AppCentre_InSecurityMode()) {
        echo $zbp->lang['AppCentre']['turn_off_safe_mode_note'];
    } else {
        echo $zbp->lang['AppCentre']['turn_on_safe_mode_note']; ?>
<p>
<form method="post">
    <?php if (function_exists('CheckIsRefererValid')) { ?>
<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken(); ?>">
    <?php } ?>
<input type="submit" class="button" value="<?php echo $zbp->lang['AppCentre']['turn_on_safe_mode']; ?>"></form></p>
<?php
    }
    $content = ob_get_clean();
    //内容获取结束

    $ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
        'Title' => $blogtitle,
        'Header' => $blogtitle,
        'HeaderIcon' => $bloghost . 'zb_users/plugin/AppCentre/logo.png',
        'Content' => $content,
        'Js_Nonce' => @$nonce,
        'ActiveLeftMenu' => 'aAppCentre',
    ]);
    ob_start();
    foreach ($GLOBALS['hooks']['Filter_Plugin_AppCentre_Client_SubMenu'] as $fpname => &$fpsignal) {
        $fpname();
    }
    AppCentre_SubMenus(7);
    $ActionInfo->SubMenu = ob_get_clean();

    // 输出页面
    $zbp->template_admin->SetTags('title', $ActionInfo->Title);
    $zbp->template_admin->SetTags('main', $ActionInfo);
    $zbp->template_admin->Display('index');

    RunTime();

    exit;
}

require $blogpath . 'zb_system/admin/admin_header.php';
?>
<style>
.warning { 
  font-size: 150%; 
  line-height: 2em;
  text-align: center;
  background: white;
}
.warning .button {
  height: 100%;
}
</style>
<?php
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">

  <div class="divHeader"><?php echo $blogtitle; ?></div>
<div class="SubMenu"><?php
foreach ($GLOBALS['hooks']['Filter_Plugin_AppCentre_Client_SubMenu'] as $fpname => &$fpsignal) {
    $fpname();
}
AppCentre_SubMenus(7);
?></div>
  <div id="divMain2">
  <div class="warning">
<?php
if (AppCentre_InSecurityMode()) {
    echo $zbp->lang['AppCentre']['turn_off_safe_mode_note'];
} else {
    echo $zbp->lang['AppCentre']['turn_on_safe_mode_note']; ?>
<p>
<form method="post">
    <?php if (function_exists('CheckIsRefererValid')) { ?>
<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken(); ?>">
    <?php } ?>
<input type="submit" class="button" value="<?php echo $zbp->lang['AppCentre']['turn_on_safe_mode']; ?>"></form></p>
<?php
} ?>
</div>
    <script type="text/javascript">ActiveLeftMenu("aAppCentre");</script>
    <script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/AppCentre/logo.png'; ?>");</script>
  </div>
</div>


<?php
require $blogpath . 'zb_system/admin/admin_footer.php';

RunTime();
