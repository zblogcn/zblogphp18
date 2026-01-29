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

if (!$zbp->Config('AppCentre')->token) {
    $blogtitle = AppCentre_GetBlogTitle() . '-' . $zbp->lang['AppCentre']['login_store'];
} else {
    $blogtitle = AppCentre_GetBlogTitle() . '-' . $zbp->lang['AppCentre']['my_store'];
}

Add_Filter_Plugin('Filter_Plugin_CSP_Backend', 'AppCentre_UpdateCSP');

if ('login' == GetVars('act')) {
    if (!$zbp->ValidToken(GetVars('token', 'GET'), 'AppCentre')) {
        $zbp->ShowError(5, __FILE__, __LINE__);

        exit();
    }
    AppCentre_CheckInSecurityMode();
    $s = trim(Server_Open('login'));
    if ('' !== $s) {
        $zbp->Config('AppCentre')->token = GetVars('app_token', 'POST');
        $zbp->Config('AppCentre')->uniq_id = trim($s);
        $zbp->Config('AppCentre')->old_token = 'false';
        $zbp->Config('AppCentre')->DelKey('old_token');

        $zbp->SaveConfig('AppCentre');

        $zbp->SetHint('good', $zbp->lang['AppCentre']['login_success']);
        Redirect('./main.php');

        exit;
    }
    $zbp->SetHint('bad', $zbp->lang['AppCentre']['token_not_exist']);
    Redirect('./client.php');

    exit;
}

if ('logout' == GetVars('act')) {
    if (function_exists('CheckHTTPRefererValid')) {
        CheckHTTPRefererValid();
    }
    AppCentre_CheckInSecurityMode();
    $zbp->Config('AppCentre')->token = '';
    $zbp->Config('AppCentre')->uniq_id = '';
    $zbp->SaveConfig('AppCentre');
    $zbp->SetHint('good', $zbp->lang['AppCentre']['logout']);
    Redirect('./client.php');

    exit;
}

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    ob_start();

    if (!$zbp->Config('AppCentre')->token) { ?>
            <div class="divHeader2"><?php echo $zbp->lang['AppCentre']['account_login']; ?></div>
            <form action="?act=login&token=<?php echo $zbp->GetToken('AppCentre'); ?>" method="post">
              <table width="100%" border="0">
                <tr height="32">
                  <th align="center"><?php echo $zbp->lang['AppCentre']['account_login']; ?>
                    </td>
                </tr>
                <tr height="32">
                  <td  align="center"><?php echo $zbp->lang['AppCentre']['token']; ?>:
                    <input type="password" name="app_token" value="" style="width:40%"/></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><input type="submit" value="<?php echo $zbp->lang['msg']['login']; ?>" class="button" /></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><a href="https://user.zblogcn.com/user/security/token" target="_blank"><?php echo $zbp->lang['AppCentre']['get_token']; ?></a>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="https://uc.zblogcn.com/user/security/token" target="_blank"><?php echo $zbp->lang['AppCentre']['get_token2']; ?></a></td>
                </tr>
              </table>
            </form>
    <?php
} else {
        //已登录
        Server_Open('shoplist');
    }
    //内容获取结束
    $content = ob_get_clean();

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
    AppCentre_SubMenus(9);
    $ActionInfo->SubMenu = ob_get_clean();

    // 输出页面
    $zbp->template_admin->SetTags('title', $ActionInfo->Title);
    $zbp->template_admin->SetTags('main', $ActionInfo);
    $zbp->template_admin->Display('index');

    RunTime();

    exit;
}

require $blogpath . 'zb_system/admin/admin_header.php';

require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">

  <div class="divHeader"><?php echo $blogtitle; ?></div>
<div class="SubMenu"><?php
foreach ($GLOBALS['hooks']['Filter_Plugin_AppCentre_Client_SubMenu'] as $fpname => &$fpsignal) {
    $fpname();
}
AppCentre_SubMenus(9);
?></div>
  <div id="divMain2">
<?php if (!$zbp->Config('AppCentre')->token) { ?>
            <div class="divHeader2"><?php echo $zbp->lang['AppCentre']['account_login']; ?></div>
            <form action="?act=login&token=<?php echo $zbp->GetToken('AppCentre'); ?>" method="post">
              <table width="100%" border="0">
                <tr height="32">
                  <th align="center"><?php echo $zbp->lang['AppCentre']['account_login']; ?>
                    </td>
                </tr>
                <tr height="32">
                  <td  align="center"><?php echo $zbp->lang['AppCentre']['token']; ?>:
                    <input type="password" name="app_token" value="" style="width:40%"/></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><input type="submit" value="<?php echo $zbp->lang['msg']['login']; ?>" class="button" /></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><a href="https://user.zblogcn.com/user/security/token" target="_blank"><?php echo $zbp->lang['AppCentre']['get_token']; ?></a>
				  &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="https://uc.zblogcn.com/user/security/token" target="_blank"><?php echo $zbp->lang['AppCentre']['get_token2']; ?></a></td>
                </tr>
              </table>
            </form>
    <?php
} else {
    //已登录
    Server_Open('shoplist');
}
?>



    <script type="text/javascript">ActiveLeftMenu("aAppCentre");</script>
    <script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/AppCentre/logo.png'; ?>");</script>
  </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
