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
    $ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
        'Title' => $blogtitle,
        'Header' => $blogtitle,
        'HeaderIcon' => $bloghost . 'zb_users/plugin/AppCentre/logo.png',
        'Content' => Get_Content(),
        'Js_Nonce' => @$nonce,
        'ActiveLeftMenu' => 'aAppCentre',
        'SubMenu' => AppCentre_SubMenus(9),
    ]);

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
<div class="SubMenu"><?php echo AppCentre_SubMenus(9);
?></div>
  <div id="divMain2">
<?php echo Get_Content();
?>
<script type="text/javascript">ActiveLeftMenu("aAppCentre");</script>
    <script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/AppCentre/logo.png'; ?>");</script>
  </div>
</div>
<?php
function Get_Content()
{
    global $zbp;
    ob_start();
    if (!$zbp->Config('AppCentre')->token) { ?>
            <div class="divHeader2"></div>
            <form action="?act=login&token=<?php echo $zbp->GetToken('AppCentre'); ?>" method="post">
              <table class="table_hover table_striped tableFull">
                <tr height="32">
                  <th align="center"><center><?php echo $zbp->lang['AppCentre']['account_login']; ?>
                    </center></td>
                </tr>
                <tr height="32">
                  <td  align="center"><center><?php echo $zbp->lang['AppCentre']['token']; ?>:
                    <input type="password" name="app_token" value="" style="width:40%"/></center></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><center><input type="submit" value="<?php echo $zbp->lang['msg']['login']; ?>" class="button" /></center></td>
                </tr>
                <tr height="32" align="center">
                  <td align="center"><center><a href="https://user.zblogcn.com/user/security/token" target="_blank"><?php echo $zbp->lang['AppCentre']['get_token']; ?></a></center></td>
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

    return $content;
}

require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
