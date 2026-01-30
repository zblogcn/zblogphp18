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

AppCentre_CheckInSecurityMode();

$blogtitle = AppCentre_GetBlogTitle() . '-' . $zbp->lang['AppCentre']['settings'];

if ('save' == GetVars('act')) {
    if (!$zbp->ValidToken(GetVars('token', 'POST'), 'AppCentre')) {
        $zbp->ShowError(5, __FILE__, __LINE__);

        exit();
    }
    $zbp->Config('AppCentre')->enabledcheck = (int) GetVars('app_enabledcheck');
    $zbp->Config('AppCentre')->checkbeta = (int) GetVars('app_checkbeta');
    $zbp->Config('AppCentre')->enabledevelop = (int) GetVars('app_enabledevelop');
    $zbp->Config('AppCentre')->enablegzipapp = (int) GetVars('app_enablegzipapp');
    $zbp->Config('AppCentre')->networktype = trim(GetVars('app_networktype'));
    $zbp->Config('AppCentre')->firstdomain = trim(GetVars('app_firstdomain'));
    $zbp->Config('AppCentre')->enablepluginsort = trim(GetVars('app_enablepluginsort'));
    $zbp->Config('AppCentre')->enablemultidownload = trim(GetVars('app_enablemultidownload'));
    $zbp->Config('AppCentre')->app_ignores = GetVars('app_ignores');
    $zbp->Config('AppCentre')->forcehttps = (int) GetVars('app_forcehttps');
    $zbp->SaveConfig('AppCentre');

    $zbp->SetHint('good');
    Redirect('./setting.php');
}

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    ob_start(); ?>
            <form action="?act=save" method="post">
            <?php echo '<input id="token" name="token" type="hidden" value="' . $zbp->GetToken('AppCentre') . '"/>'; ?>
              <table class="table_hover table_striped tableFull">
                <tr height="32">
                  <th colspan="2" align="center"><?php echo $zbp->lang['AppCentre']['settings']; ?>
                    </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_automatic_updates']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['enable_automatic_updates_note']; ?></span></p></td>
                  <td><input id="app_enabledcheck" name="app_enabledcheck" type="text" value="<?php echo $zbp->Config('AppCentre')->enabledcheck; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['check_the_beta_version']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['check_the_beta_version_note']; ?></span></p></td>
                  <td><input id="app_checkbeta" name="app_checkbeta" type="text" value="<?php echo $zbp->Config('AppCentre')->checkbeta; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_developer_mode']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['enable_developer_mode_note']; ?></span></p></td>
                  <td><input id="app_enabledevelop" name="app_enabledevelop" type="text" value="<?php echo $zbp->Config('AppCentre')->enabledevelop; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['export_gzip_compressed']; ?></b><br/>
                      <span class="note"></span></p></td>
                  <td><input id="app_enablegzipapp" name="app_enablegzipapp" type="text" value="<?php echo $zbp->Config('AppCentre')->enablegzipapp; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['connect_type_background']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['connect_type_background_note']; ?></span></p></td>
                  <td>
<label><input name="app_networktype" type="radio" value="curl" <?php echo 'curl' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />curl(<?php echo $zbp->lang['msg']['default']; ?>)</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_networktype" type="radio" value="fsockopen" <?php echo 'fsockopen' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />fsockopen</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_networktype" type="radio" value="filegetcontents" <?php echo 'filegetcontents' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />filegetcontents</label>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['ignore_updated_apps']; ?></b></p></td>
                  <td>
<?php
if (!is_array($zbp->Config('AppCentre')->app_ignores)) {
        $zbp->Config('AppCentre')->app_ignores = [];
    }
    foreach ($zbp->Config('AppCentre')->app_ignores as $key => $value) {
        echo "<label><input type=\"checkbox\" name=\"app_ignores[]\" checked=\"checked\" value=\"{$value}\">&nbsp;{$value}</label>&nbsp;&nbsp;&nbsp;";
    }
    if (method_exists($zbp, 'GetPreActivePlugin')) {
        $aps = $GLOBALS['zbp']->GetPreActivePlugin();
    } else {
        $aps = array_unique(explode('|', $zbp->option['ZC_USING_PLUGIN_LIST']));
    }
    $aps = array_merge([$zbp->theme], $aps);

    foreach ($aps as $key => $value) {
        if (in_array($value, $zbp->Config('AppCentre')->app_ignores) || 'AppCentre' == $value) {
            continue;
        }
        echo "<label><input type=\"checkbox\" name=\"app_ignores[]\" value=\"{$value}\">&nbsp;{$value}</label>&nbsp;&nbsp;&nbsp;";
    } ?>
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_plugin_sort']; ?></b><br/>
                      <span class="note"></span></p></td>
                  <td><input id="app_enablepluginsort" name="app_enablepluginsort" type="text" value="<?php echo $zbp->Config('AppCentre')->enablepluginsort; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['domain_of_appcentre']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['domain_of_appcentre_note']; ?></span></p></td>
                  <td>
<label><input name="app_firstdomain" type="radio" value="zblogcn.com" <?php echo 'zblogcn.com' == $zbp->Config('AppCentre')->firstdomain ? 'checked="checked"' : ''; ?> />app.zblogcn.com(<?php echo $zbp->lang['msg']['default']; ?>)</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_firstdomain" type="radio" value="zblogcn.net" <?php echo 'zblogcn.net' == $zbp->Config('AppCentre')->firstdomain ? 'checked="checked"' : ''; ?> />app.zblogcn.net</label>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['force_enable_https']; ?></p></td>
                  <td><input id="app_forcehttps" name="app_forcehttps" type="text" value="<?php echo $zbp->Config('AppCentre')->forcehttps; ?>" class="checkbox"/></td>
                </tr>

              </table>
              <p>
                <input type="submit" value="<?php echo $zbp->lang['msg']['submit']; ?>" class="button" />
              </p>
            </form>
<?php
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
    AppCentre_SubMenus(4);
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
AppCentre_SubMenus(4);
?></div>
  <div id="divMain2">

            <form action="?act=save" method="post">
            <?php echo '<input id="token" name="token" type="hidden" value="' . $zbp->GetToken('AppCentre') . '"/>'; ?>
              <table width="100%" border="0">
                <tr height="32">
                  <th colspan="2" align="center"><?php echo $zbp->lang['AppCentre']['settings']; ?>
                    </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_automatic_updates']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['enable_automatic_updates_note']; ?></span></p></td>
                  <td><input id="app_enabledcheck" name="app_enabledcheck" type="text" value="<?php echo $zbp->Config('AppCentre')->enabledcheck; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['check_the_beta_version']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['check_the_beta_version_note']; ?></span></p></td>
                  <td><input id="app_checkbeta" name="app_checkbeta" type="text" value="<?php echo $zbp->Config('AppCentre')->checkbeta; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_developer_mode']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['enable_developer_mode_note']; ?></span></p></td>
                  <td><input id="app_enabledevelop" name="app_enabledevelop" type="text" value="<?php echo $zbp->Config('AppCentre')->enabledevelop; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['export_gzip_compressed']; ?></b><br/>
                      <span class="note"></span></p></td>
                  <td><input id="app_enablegzipapp" name="app_enablegzipapp" type="text" value="<?php echo $zbp->Config('AppCentre')->enablegzipapp; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['connect_type_background']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['connect_type_background_note']; ?></span></p></td>
                  <td>
<label><input name="app_networktype" type="radio" value="curl" <?php echo 'curl' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />curl(<?php echo $zbp->lang['msg']['default']; ?>)</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_networktype" type="radio" value="fsockopen" <?php echo 'fsockopen' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />fsockopen</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_networktype" type="radio" value="filegetcontents" <?php echo 'filegetcontents' == $zbp->Config('AppCentre')->networktype ? 'checked="checked"' : ''; ?> />filegetcontents</label>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['ignore_updated_apps']; ?></b></p></td>
                  <td>
<?php
if (!is_array($zbp->Config('AppCentre')->app_ignores)) {
    $zbp->Config('AppCentre')->app_ignores = [];
}
foreach ($zbp->Config('AppCentre')->app_ignores as $key => $value) {
    echo "<label><input type=\"checkbox\" name=\"app_ignores[]\" checked=\"checked\" value=\"{$value}\">&nbsp;{$value}</label>&nbsp;&nbsp;&nbsp;";
}
if (method_exists($zbp, 'GetPreActivePlugin')) {
    $aps = $GLOBALS['zbp']->GetPreActivePlugin();
} else {
    $aps = array_unique(explode('|', $zbp->option['ZC_USING_PLUGIN_LIST']));
}
$aps = array_merge([$zbp->theme], $aps);

foreach ($aps as $key => $value) {
    if (in_array($value, $zbp->Config('AppCentre')->app_ignores) || 'AppCentre' == $value) {
        continue;
    }
    echo "<label><input type=\"checkbox\" name=\"app_ignores[]\" value=\"{$value}\">&nbsp;{$value}</label>&nbsp;&nbsp;&nbsp;";
}

?>
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['enable_plugin_sort']; ?></b><br/>
                      <span class="note"></span></p></td>
                  <td><input id="app_enablepluginsort" name="app_enablepluginsort" type="text" value="<?php echo $zbp->Config('AppCentre')->enablepluginsort; ?>" class="checkbox"/></td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['domain_of_appcentre']; ?></b><br/>
                      <span class="note">&nbsp;&nbsp;<?php echo $zbp->lang['AppCentre']['domain_of_appcentre_note']; ?></span></p></td>
                  <td>
<label><input name="app_firstdomain" type="radio" value="zblogcn.com" <?php echo 'zblogcn.com' == $zbp->Config('AppCentre')->firstdomain ? 'checked="checked"' : ''; ?> />app.zblogcn.com(<?php echo $zbp->lang['msg']['default']; ?>)</label>&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="app_firstdomain" type="radio" value="zblogcn.net" <?php echo 'zblogcn.net' == $zbp->Config('AppCentre')->firstdomain ? 'checked="checked"' : ''; ?> />app.zblogcn.net</label>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr height="32">
                  <td width="30%" align="left"><p><b>· <?php echo $zbp->lang['AppCentre']['force_enable_https']; ?></p></td>
                  <td><input id="app_forcehttps" name="app_forcehttps" type="text" value="<?php echo $zbp->Config('AppCentre')->forcehttps; ?>" class="checkbox"/></td>
                </tr>

              </table>
              <hr/>
              <p>
                <input type="submit" value="<?php echo $zbp->lang['msg']['submit']; ?>" class="button" />
              </p>
              <hr/>
            </form>


    <script type="text/javascript">ActiveLeftMenu("aAppCentre");</script>
    <script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/AppCentre/logo.png'; ?>");</script>
  </div>
</div>
<?php
function Get_Content()
{
    global $zbp, $option;
    ob_start();
    $content = ob_get_clean();
    //内容获取结束
    return $content;
}

require $blogpath . 'zb_system/admin/admin_footer.php';

RunTime();
