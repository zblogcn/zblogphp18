<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require '../../../zb_system/admin2/function/admin2_function.php';
}
require 'zbpdk_include.php';

$zbp->Load();
$zbpdk = new zbpdk_t();
$zbpdk->scan_extensions();
//var_dump($zbpdk->objects);

$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('ZBPDK')) {
    $zbp->ShowError(48);
    die();
}

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require 'main2.php';
} else {
    require 'main1.php';
}