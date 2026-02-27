<?php

$blogtitle = 'Z-Blog PHP Development';

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/ZBPDK/logo.png',
    'Content' => Get_Content(),
    'SubMenu' => $zbpdk->submenu->export('PluginInterface'),
    'ActiveTopMenu' => 'zbpdk',
    'HtmlHeader' => '',
]);

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

function Get_Content()
{
    global $zbpdk, $zbp;
    ob_start(); ?>
<script type="text/javascript">
<?php
$defined_interface = [
    'action'   => [],
    'filter'   => [],
    'response' => [],
];
    if (isset($hooks)) {
        $zbpdk_allhooks = &$hooks;
    } else {
        $zbpdk_allhooks = $GLOBALS;
    }

    foreach ($zbpdk_allhooks as $temp_name => $temp_value) {
        if (preg_match('/^(Action|Filter|Response)_/i', $temp_name, $matches)) {
            array_push($defined_interface[strtolower($matches[1])], '"' . $temp_name . '"');
        }
    } ?>
var defined_interface = {
    "action":[<?php echo implode(',', $defined_interface['action']); ?>],
    "filter":["Filter_ZBPDK_Display_All",<?php echo implode(',', $defined_interface['filter']); ?>],
    "response":[<?php echo implode(',', $defined_interface['response']); ?>],
}
function write_list(type_name)
{
    var str = "" , p = defined_interface[type_name];
    for(var i=0; i<=p.length-1; i++){
        var o = p[i];
        str += "<option value='"+o+"'>"+o+"</option>"
    }
    return str;
}

function show_code(func_name,if_name,tr_obj)
{
    $.post("main.php?act=showcode",{"func":func_name,"if":if_name},function(data){$(tr_obj).attr("onclick","").find("td").html('<pre>'+data+'</pre>')})
}
</script>
<style type="text/css">
td,th{text-indent:0}
</style>


    <form id="form1" onSubmit="return false">
      <label for="interface">输入接口名</label>
      <input type="text" name="interface" id="interface" style="width:80%;display:block!important;" value="Filter_ZBPDK_Display_All"/>
      <input type="submit" name="ok" id="ok" value="查看" onClick=""/>
      <p>或选择接口名：
        <select name="type" id="type" onclick="$('#list').html(write_list($(this).val()))">
          <!--<option value="action">Action</option>-->
          <option value="filter">Filter</option>
         <!-- <option value="response">Response</option>
          <option value="all">All</option>-->
        </select>
        <select name="list" id="list" style="width:80%;display:block!important;" onclick="$('#interface').val($(this).val())">
        </select>
      </p>
    </form>
    <div id="result"></div>
<script type="text/javascript">
$(document).ready(function() {
    $('#list').html(write_list('filter'));
    $("#form1").bind("submit",function(){
        $("#result").html("Waiting...");
        $.post(
            "main.php?act=interface",
            {"interface":$("#interface").val()},
            function(data)
            {
                $("#result").html(data);
                bmx2table();
            }
        );
    })
});
</script>
<?php
    $content = ob_get_clean();

    return $content;
}
