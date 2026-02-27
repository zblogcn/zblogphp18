<?php
require $blogpath . 'zb_system/admin/admin_header.php';
?>
<link rel="stylesheet" href="BlogConfig.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="../../css/jquery.contextMenu.css" type="text/css" media="screen"/>
<script type="text/javascript" src="../../js/jquery.contextMenu.js"></script>
<script type="text/javascript" src="BlogConfig.js"></script>
<script src="../../../../../zb_system/script/c_admin_js_add.php" type="text/javascript"></script>
<script src="../../../../../zb_system/script/jquery-ui.custom.min.js" type="text/javascript"></script>
<?php
require $blogpath . 'zb_system/admin/admin_top.php';
?>

<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle; ?></div>
  <div class="SubMenu"><?php echo $zbpdk->submenu->export('BlogConfig'); ?></div>
  <div id="divMain2">
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
//					console.log(this);
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
  </div>
</div>

<script>ActiveTopMenu('zbpdk');</script>
<script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/ZBPDK/logo.png'; ?>");</script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
