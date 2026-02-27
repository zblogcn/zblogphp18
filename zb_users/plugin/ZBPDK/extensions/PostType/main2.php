<?php

$blogtitle = 'Z-Blog PHP Development';

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/ZBPDK/logo.png',
    'Content' => Get_Content(),
    'SubMenu' => $zbpdk->submenu->export('PostType'),
    'ActiveTopMenu' => 'zbpdk',
    'HtmlHeader' => '',
]);

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

function Get_Content()
{
    global $zbpdk, $zbp, $posttype;
    ob_start(); ?>
    <form id="form1" onSubmit="return false">
<?php

$defined_route = ['default'=>'Default默认路由', 'active'=>'Active动态路由', 'rewrite'=>'Rewrite伪静路由'];
    $replace_array = [
        'name' => '名称<br/>',
        'classname' => '类名 - 默认是Post，但也可以是继承自BasePost类型的新类<br/>',
        'template' => '类的模板名 - 分别是自身的模板 对应分类的模板 对应Tag的模板 列表的模板(含日期列表) 搜索页的模板<br/>',
        'single_urlrule' => '类的Url原始规则 - 分别是自身单个规则 列表规则 分类列表规则 Tag列表规则 作者列表规则 日期列表规则 搜索列表规则<br/>',
        'actions' => '权限命令数组 - 权限名称分别是 新建 编辑 删除 提交 公开发布 管理 全部管理 查看 搜索<br/>',
        'routes' => '路由数组<br/>',
    ];

    foreach ($posttype as $id => $array) {
        echo '<table class="table_hover table_striped tableFull" style="margin:1em 0;"><thead style="background-color: var(--color-bg-normal);"><tr><th title="点击查看详细信息" style="cursor:pointer;" onclick="$(this).parentsUntil(\'table\').next().toggle();">' . ucfirst($array['name']) . '类型<b style="font-weight:normal;"> (posttype = ' . $id . ')</b></th></tr></thead><tbody style="display:none;">';
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                echo '<tr><td>' . GetValueInArray($replace_array, $key) . '"<b>' . $key . '</b>" => <b>' . $value . '</b>';
                echo '</td></tr>';
            } else {
                echo '<tr><td>' . GetValueInArray($replace_array, $key) . '"<b>' . $key . '</b>" => ';
                if ('routes' == $key) {
                    $rs = [];
                    foreach ($value as $k1 => $v2) {
                        $rs[$k1] = $v2;
                    }
                    $value = $rs;
                }
                $t = var_export($value, true);
                echo $t;
                echo '</td></tr>';
            }
        }
        echo '</tbody></table>';
    } ?>
    </form>
<?php
    $content = ob_get_clean();

    return $content;
}
