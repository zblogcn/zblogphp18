<?php

RegisterPlugin('AdminColor_2026', 'ActivePlugin_AdminColor_2026');

function ActivePlugin_AdminColor_2026()
{
    Add_Filter_Plugin('Filter_Plugin_Admin_SettingMng_SubMenu', 'AdminColor_2026_submenu');
    Add_Filter_Plugin('Filter_Plugin_Zbp_PrepareTemplateAdmin', 'AdminColor_2026_GenTpl');
}

//挂上新接口
function AdminColor_2026_GenTpl(&$template_admin)
{
    $tplCont = file_get_contents(AdminColor_2026_Path('tpl-Content'));
    $template_admin->AddTemplate('plugin_AdminColor_2026_Content', $tplCont);
}

function AdminColor_2026_submenu()
{
    global $zbp;
    echo MakeSubMenu('后台配色_2026', AdminColor_2026_Path('main', 'host'), 'm-right', null, null, null, 'icon-brush-fill');
}

function AdminColor_2026_Path($file, $t = 'path')
{
    global $zbp;
    $result = $zbp->{$t}.'zb_users/plugin/AdminColor_2026/';

    switch ($file) {
        case 'tpl-Content':
            return $result.'tpl/Content.php';

            break;

        case 'usr':
            return $result.'usr/';

            break;

        case 'var':
            return $result.'var/';

            break;

        case 'main':
            return $result.'main.php';

            break;

        default:
            return $result.$file;
    }
}

function InstallPlugin_AdminColor_2026()
{
}

function UninstallPlugin_AdminColor_2026()
{
}
