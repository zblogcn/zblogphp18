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
    switch ($_GET['act']) {
        case 'interface':
            $interface_name = GetVars('interface', 'POST');
            preg_match('/^(Action|Filter|Response)_/i', $interface_name, $matches);
            $interface_type = strtolower($matches[1]);
            if ('Filter_ZBPDK_Display_All' != $interface_name) {
                plugininterface_formatfilter($interface_name);
            } else {
                plugininterface_getall();
            }

            echo '<table width="100%"><tr><td height="40">挂接口数量（共' . count($GLOBALS['zbdk_interface_defined_plugins']['filter']) . '个）</td></tr>';
            foreach ($GLOBALS['zbdk_interface_defined_plugins']['filter'] as $temp) {
                echo '<tr onclick="show_code(\'' . $temp['orig'] . '\',$(this).attr(\'_interface\'),this)" _interface="' . $temp['interface_name'] . '">';
                echo '<td height="40">' . TransferHTML($temp['output'], '[html-format]') . '</td></tr>';
            }
            echo '</table>';

            exit();

            break;

        case 'showcode':
            $func_name = GetVars('func', 'POST');
            $interface_name = GetVars('if', 'POST');
            echo TransferHTML(plugininterface_outputfunc($interface_name, $func_name), '[html-format][enter]');

            exit();

            break;
    }
}

if (version_compare(ZC_VERSION, '1.8.0') >= 0) {
    require 'main2.php';
} else {
    require 'main1.php';
}
