<?php die();?>


 <form action="{php}<?php echo BuildSafeURL("main.php?act=save");?>{/php}" method="post">
   <table width="100%" class="tableBorder table_striped">
   <tr>
     <th width="10%">项目</th>
     <th>内容</th>
     <th width="45%">说明</th>
   </tr>
   <tr>
     <td>标准色</td>
     <td>{php}<?php zbpform::text("NormalColor", $zbp->Config("AdminColor_2026")->NormalColor, "90%"); ?>{/php}</td>
     <td></td>
   </tr>
   <tr>
     <td>深色</td>
     <td>{php}<?php zbpform::text("BlodColor", $zbp->Config("AdminColor_2026")->BlodColor, "90%"); ?>{/php}</td>
     <td></td>
   </tr>
   <tr>
     <td>浅色</td>
     <td>{php}<?php zbpform::text("LightColor", $zbp->Config("AdminColor_2026")->LightColor, "90%"); ?>{/php}</td>
     <td></td>
   </tr>
   <tr>
     <td>高光色</td>
     <td>{php}<?php zbpform::text("HighColor", $zbp->Config("AdminColor_2026")->HighColor, "90%"); ?>{/php}</td>
     <td></td>
   </tr>
   <tr>
     <td>反色</td>
     <td>{php}<?php zbpform::text("AntiColor", $zbp->Config("AdminColor_2026")->AntiColor, "90%"); ?>{/php}</td>
     <td></td>
   </tr>
   <tr>
   <td></td>
   <td colspan="2"><input type="submit" value="提交" /></td>
   </tr>
   </table>
 </form>
