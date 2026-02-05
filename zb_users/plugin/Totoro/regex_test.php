<?php
require '../../../zb_system/function/c_system_base.php';

require '../../../zb_system/function/c_system_admin.php';

require '../../../zb_system/admin2/function/admin2_function.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);

    exit();
}
if (!$zbp->CheckPlugin('Totoro')) {
    $zbp->ShowError(48);

    exit();
}
Totoro_init();
$blogtitle = 'Totoro反垃圾评论';

if ('test' == GetVars('type', 'GET')) {
    Post_Content();
}

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/Totoro/logo.png',
    'Content' => Get_Content(),
    'SubMenu' => $Totoro->export_submenu('regex_test'),
]);

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

RunTime();

exit;
function Post_Content()
{
    global $zbp, $Totoro;
    if ('test' == GetVars('type', 'GET')) {
        set_error_handler('emptyFunction');
        set_exception_handler('emptyFunction');
        register_shutdown_function('emptyFunction');
        $regex = GetVars('regexp', 'POST');
        $regex = '/(' . $regex . ')/si';
        $matches = [];
        $string = GetVars('string', 'POST');
        $value = preg_match_all($regex, $string, $matches);
        if ($value) {
            foreach ($matches[0] as $v) {
                //echo $v;
                $string = str_replace($v, '$$$fuabcdeck$$a$' . $v . '$$a$fuckd$b$', $string);
            }
            $string = TransferHTML($string, '[html-format]');
            $string = str_replace('$$$fuabcdeck$$a$', '<span style="background-color:#92d050">', $string);
            $string = str_replace('$$a$fuckd$b$', '</span>', $string);
            echo $string;
        } else {
            echo '正则有误或未匹配到：<br/><br/>可能的情况是：<ol><li>少打了某个符号</li><li>没有在[ ] ( ) ^ . ? !等符号前加\\</li></ol>';
        }

        exit();
    }
}

function Get_Content()
{
    global $zbp, $lang, $Totoro;
    ob_start(); ?>
    <table style="margin-top:1em;" class="table_hover table_striped tableFull">
      <tr height="40">
        <td width="50%">输入待测试内容</td>
        <td>结果</td>
      </tr>
      <tr>
        <td><textarea rows="6" name="test" id="test" style="width:99%" ></textarea></td>
        <td rowspan="4" style="text-indent:0;vertical-align:top"><div id="result"></div></td>
      </tr>
      <tr height="40">
        <td>输入黑词列表或过滤词列表</td>
      </tr>
      <tr>
        <td><textarea rows="6" name="regexp" id="regexp" style="width:99%" ></textarea></td>
      </tr>
      <tr>
        <td><input type="button" class="button" value="提交测试" id="buttonsubmit"/></td>
      </tr>
    </table>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#buttonsubmit").bind("click",function(){
        var o = $.ajax({
            url : "regex_test.php?type=test",
            async : false,
            type : "POST",
            data : {"string":$("#test").attr("value"),"regexp":$("#regexp").attr("value")},
            dataType : "script"
        });
        $("#result").html(o.responseText);
    });
});
</script>
<?php
    $content = ob_get_clean();

    return $content;
}
?>