<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
require '../../../zb_system/admin2/function/admin2_function.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('Totoro')) {
    $zbp->ShowError(48);
    die();
}
Totoro_init();
$blogtitle = 'Totoro反垃圾评论';

if (GetVars('type', 'GET') == 'test') {
    Post_Content();
}

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/Totoro/logo.png',
    'Content' => Get_Content(),
    'SubMenu' => $Totoro->export_submenu('online_test'),
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
    if (GetVars('type', 'GET') == 'test') {
        $comment = new Comment();
        $comment->Name = GetVars('name', 'POST');
        $comment->HomePage = GetVars('url', 'POST');
        $comment->IP = GetVars('ip', 'POST');
        $comment->Content = GetVars('string', 'POST');

        //  var_dump($comment);
        $score = $Totoro->get_score($comment, true);
        echo "\n" . 'MAX_SCORE: ' . $score;
        if ($score >= $Totoro->config_array['SV_SETTING']['SV_THRESHOLD']['VALUE']) {
            echo "\n该评论被审核";
        }

        exit();
    }
}

function Get_Content()
{
    global $zbp, $lang, $Totoro;
    ob_start();
?>
    <table style="margin-top:1em;" class="table_hover table_striped tableFull">
      <tr height="40">
        <td width="50%"><label for="username">· 用户名</label>
          <input type="text" name="username" id="username" style="width:90%" /></td>
        <td>结果</td>
      </tr>

      <tr>
        <td><label for="url">· 网址　</label>
            <input type="text" name="url" id="url" style="width:90%"/></td>
        <td rowspan="5" style="text-indent:0;vertical-align:top"><div id="result"></div></td>
      </tr>
      <tr>
        <td><label for="ip">· IP　　</label>
            <input type="text" name="ip" id="ip" value="<?php echo GetVars('REMOTE_ADDR', 'SERVER'); ?>" style="width:90%"/></td>
        <td rowspan="5" style="text-indent:0;vertical-align:top"><div id="result"></div></td>
      </tr>
      <tr height="40">
        <td>· 内容</td>
      </tr>
      <tr>
        <td><textarea rows="6" name="regexp" id="regexp" style="width:99%" ></textarea></td>
      </tr>
      <tr>
        <td><input type="button" class="button" value="提交测试" id="buttonsubmit"/></td>
      </tr>
    </table>
    <script type="text/javascript">
    $(function() {
        $("#buttonsubmit").bind("click",function(){
            $("#result").html("Testing...");
            var o = $.ajax({
                url : "?type=test",
                async : false,
                type : "POST",
                data : {
          "name":$("#username").val(),
          "url":$("#url").val(),
          "ip":$("#ip").val(),
          "string":$("#regexp").val()
        },
                dataType : "script",
            });
            $("#result").html(o.responseText.replace(/\n/g, "<br/>"));
        });
    });
    </script>
<?php
    $content = ob_get_clean();
    return $content;
}
?>