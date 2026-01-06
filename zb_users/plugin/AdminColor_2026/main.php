<?php

// 引入系统
require '../../../zb_system/function/c_system_base.php';

require '../../../zb_system/function/c_system_admin_function.php';

require '../../../zb_system/admin2/function/admin2_function.php';

// 加载系统
$zbp->Load();

// 验证权限
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);

    exit;
}
// 插件启用验证
if (!$zbp->CheckPlugin('AdminColor_2026')) {
    $zbp->ShowError(48);

    exit;
}

// 保存设置
$act = GetVars('act', 'GET');
$suc = GetVars('suc', 'GET');
if ('save' == $act) {
    CheckIsRefererValid();
    $post_colors = [];
    foreach ($_POST as $key => $val) {
        if ('read_' == substr($key, 0, 5)) {
            continue;
        }
        if ('opt_' == substr($key, 0, 4)) {
            $zbp->Config('AdminColor_2026')->{$key} = trim($val);

            continue;
        }
        $post_colors[$key] = trim($val);
    }
    $zbp->Config('AdminColor_2026')->colors = (object) $post_colors;
    $zbp->SaveConfig('AdminColor_2026');
    AdminColor_2026_GenCSS();
    $zbp->SetHint('good');
    Redirect('./main.php' . (null == $suc ? '' : "?act={$suc}"));
}

// 初始化
InstallPlugin_AdminColor_2026();

// 用于当前配置页的变量，样式和脚本引入
$cfg_colors = $zbp->Config('AdminColor_2026')->colors;
$zbp->template_admin->SetTags('cfg_colors', $cfg_colors);
$zbp->template_admin->SetTags('preset_colors', AdminColor_2026_GetColors());
// 在后台头部引入样式
$style = AdminColor_2026_Path('source/pickr.min.css', 'host');
$zbp->header .= "<link rel=\"stylesheet\" href=\"{$style}\">";
$style = AdminColor_2026_Path('source/plugin.css', 'host');
$zbp->header .= "<link rel=\"stylesheet\" href=\"{$style}\">";
// 在后台底部引入脚本
$script = AdminColor_2026_Path('source/pickr.min.js', 'host');
$zbp->footer .= "<script src=\"{$script}\"></script>";
$script = AdminColor_2026_Path('source/plugin.js', 'host');
$zbp->footer .= "<script src=\"{$script}\"></script>";

// 内容构建
$blogtitle = '后台配色器_2026';
$content = $zbp->template_admin->Output('plugin_AdminColor_2026_Content');
$ActionInfo = (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => 'icon-brush-fill',
    'SubMenu' => '',
    'ActiveTopMenu' => '',
    'ActiveLeftMenu' => '',
    'Action' => $zbp->action,
    'Content' => $content,
];

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

RunTime();
