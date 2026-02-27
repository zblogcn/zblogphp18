<?php
$blogtitle = 'Z-Blog PHP Development';

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/ZBPDK/logo.png',
    'Content' => Get_Content(),
]);

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

function Get_Content()
{
    global $zbpdk, $zbp;
    ob_start(); ?>
    <p>ZBPDK，全称Z-Blog PHP Development Kit，是为Z-BlogPHP开发人员开发的一套工具包。它集合了许多开发中常用的工具，可以帮助开发者更好地进行开发。</p>
    <p>该插件有一定的危险性，一旦进行了误操作可能导致博客崩溃，请谨慎使用。</p>
    <p>&nbsp;</p>
    <p>工具列表：</p>
    <p>&nbsp;</p>
    <table class="table_hover table_striped tableFull">
      <tr height="40">
        <td width="50">ID</td>
        <td width="120">工具名</td>
        <td>信息</td>
      </tr>
        <?php
        foreach ($zbpdk->objects as $k => $v) {
            echo '<tr height="40">';
            echo '<td>' . ($k + 1) . '</td>';
            echo '<td>' . "<a href=\"extensions/{$v->id}/{$v->url}\" target=\"_blank\">{$v->id}</a>" . '</td>';
            echo '<td>' . $v->description . '</td>';
            echo '</tr>';
        } ?>
    </table>
<?php
    $content = ob_get_clean();

    return $content;
}
