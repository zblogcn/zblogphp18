<?php

require '../../../../../zb_system/function/c_system_base.php';

require '../../../../../zb_system/function/c_system_admin.php';
if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require '../../../../../zb_system/admin2/function/admin2_function.php';
}

require '../../zbpdk_include.php';
header('Cache-Control: no-cache, must-revalidate');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');

$zbp->Load();
$zbpdk = new zbpdk_t();
$zbpdk->scan_extensions();
//var_dump($zbpdk->objects);

$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);

    exit();
}
if (!$zbp->CheckPlugin('ZBPDK')) {
    $zbp->ShowError(48);

    exit();
}

if (isset($_GET['act'])) {
    if (function_exists('CheckHTTPRefererValid') && !CheckHTTPRefererValid()) {
        return;
    }

    switch ($_GET['act']) {
        case 'open':
            echo blogconfig_exportlist($_GET['name']);

            exit();

            break;

        case 'readleft':
            echo blogconfig_left();

            exit();

            break;

        case 'rename':
            $sql = $zbp->db->sql->Update($zbp->table['Config'], ['conf_Name' => $_GET['edit']], [['=', 'conf_Name', $_GET['name']]]);
            $zbp->db->Update($sql);
            echo '操作成功';

            exit();

            break;

        case 'del':
            $zbp->DelConfig($_GET['name']);
            echo '操作成功';

            exit();

            break;

        case 'new':
            $zbp->SaveConfig($_GET['name']);
            echo blogconfig_exportlist($_GET['name']);

            exit();

            break;

        default:
    }
}

if (isset($_POST['act'])) {
    if (function_exists('CheckHTTPRefererValid') && !CheckHTTPRefererValid()) {
        return;
    }

    switch ($_POST['act']) {
        case 'e_del':
            $zbp->configs[$_POST['name2']]->Del($_POST['name1']);
            $zbp->SaveConfig($_POST['name2']);
            echo blogconfig_exportlist($_POST['name2']);

            exit();

            break;

        case 'e_edit':
            $name1 = $_POST['name1'];
            $config = $zbp->configs[$_POST['name2']]->{$name1};
            $value = $_POST['post'];
            if ('boolean' == gettype($config)) {
                $value = (bool) $value;
            } elseif ('integer' == gettype($config)) {
                $value = (int) $value;
            }
            $name1 = $_POST['name1'];
            $zbp->configs[$_POST['name2']]->{$name1} = $value;
            $zbp->SaveConfig($_POST['name2']);
            echo blogconfig_exportlist($_POST['name2']);

            exit();

        default:
    }
}

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require 'main2.php';
} else {
    require 'main1.php';
}
