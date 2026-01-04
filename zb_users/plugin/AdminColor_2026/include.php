<?php

require __DIR__ . '/function.php';

RegisterPlugin('AdminColor_2026', 'ActivePlugin_AdminColor_2026');

function ActivePlugin_AdminColor_2026()
{
    Add_Filter_Plugin('Filter_Plugin_Admin_SettingMng_SubMenu', 'AdminColor_2026_submenu');
    Add_Filter_Plugin('Filter_Plugin_Admin_Header', 'AdminColor_2026_Main_Header');
    Add_Filter_Plugin('Filter_Plugin_Admin_Footer', 'AdminColor_2026_Main_Footer');
    Add_Filter_Plugin('Filter_Plugin_Zbp_PrepareTemplateAdmin', 'AdminColor_2026_GenTpl');
}

// 挂上新接口
function AdminColor_2026_GenTpl(&$template_admin)
{
    $tplCont = file_get_contents(AdminColor_2026_Path('tpl-Content'));
    $template_admin->AddTemplate('plugin_AdminColor_2026_Content', $tplCont);
}

// 在后台头部引入样式
function AdminColor_2026_Main_Header()
{
    global $zbp;
    // 如果网址里含有 AdminColor_2026 则引入样式
    if (strpos($zbp->currenturl, 'AdminColor_2026') !== false) {
        echo '<link rel="stylesheet" href="' . AdminColor_2026_Path("tpl/plugin.css", "host") . '">';
    }
    echo '<link rel="stylesheet" type="text/css" href="' . AdminColor_2026_Path("usr/style.css", "host") . '">';
}

// 在后台底部引入脚本
function AdminColor_2026_Main_Footer()
{
    global $zbp;
    // 如果网址里含有 AdminColor_2026 则引入脚本
    if (strpos($zbp->currenturl, 'AdminColor_2026') !== false) {
        echo '<script src="' . AdminColor_2026_Path("tpl/plugin.js", "host") . '"></script>';
    }
}

function AdminColor_2026_submenu()
{
    global $zbp;
    echo MakeSubMenu('后台配色_2026', AdminColor_2026_Path('main', 'host'), 'm-right', null, null, null, 'icon-brush-fill');
}

function AdminColor_2026_Path($file, $t = 'path')
{
    global $zbp;
    $result = $zbp->{$t} . 'zb_users/plugin/AdminColor_2026/';

    switch ($file) {
        case 'tpl-Content':
            return $result . 'tpl/Content.php';

            break;

        case 'usr':
            return $result . 'usr/';

            break;

        case 'var':
            return $result . 'var/';

            break;

        case 'main':
            return $result . 'main.php';

            break;

        default:
            return $result . $file;
    }
}

function InstallPlugin_AdminColor_2026()
{
    global $zbp;
    $Colors = AdminColor_2026_GetColors();
    if (!$zbp->HasConfig('AdminColor_2026')) {
        $zbp->Config('AdminColor_2026')->version = 1;
        $zbp->Config('AdminColor_2026')->colors = (object) $Colors[0];
        $zbp->SaveConfig('AdminColor_2026');
    }

    $file = AdminColor_2026_Path("usr/style.css");
    if (!is_file($file)) {
        @mkdir(dirname($file));
        AdminColor_2026_GenCSS();
    }
}

function UninstallPlugin_AdminColor_2026() {}
