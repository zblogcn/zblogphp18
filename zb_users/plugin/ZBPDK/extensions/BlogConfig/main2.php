<?php

$blogtitle = 'Z-Blog PHP Development';

$ActionInfo = zbp_admin2_GetActionInfo($action, (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => $bloghost . 'zb_users/plugin/ZBPDK/logo.png',
    'Content' => Get_Content(),
    'SubMenu' => $zbpdk->submenu->export('BlogConfig'),
    'ActiveTopMenu' => 'zbpdk',
    'HtmlHeader' => '<style>#divMain2{padding-top:1em!important ;}</style><link rel="stylesheet" href="BlogConfig.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="../../css/jquery.contextMenu.css" type="text/css" media="screen"/>
<script type="text/javascript" src="../../js/jquery.contextMenu.js"></script>
<script type="text/javascript" src="BlogConfig.js"></script>',
]);

// 输出页面
$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

function Get_Content()
{
    global $zbpdk, $zbp;
    ob_start(); ?>
    <div class="DIVBlogConfig">
      <div class="DIVBlogConfignav" name="tree" id="tree">
        <ul>
            <?php echo blogconfig_left(); ?>
        </ul>
        <script type="text/javascript">
        $(document).ready(function() {
            $.contextMenu({
                selector: '#tree ul li', 
                items: {
                    "open": {name: "打开"},
                    "rename": {name: "重命名"},
                    "del": {name: "删除"}
                }, 
                callback: function (key, options) {
//                  console.log(this);
                    run(key, $(this).find("a").attr("id"));
                }
            });
        });
      </script></div>
      <div id="content" class="DIVBlogConfigcontent">
        <div class="DIVBlogConfigcontentbody">请选择</div>
      </div>
      <div class="clear"></div>
    </div>
<?php
    $content = ob_get_clean();

    return $content;
}
