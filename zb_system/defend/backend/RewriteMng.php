<?php die(); ?>

{php}<?php
function OutputOptionItemsOfUrl($type)
{
    global $ua, $zbp;
    $s = '';
    $d = 'style="display:none;"';
    if ($zbp->option['ZC_STATIC_MODE'] == 'ACTIVE' || strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php') !== false) {
        $r = 'disabled="disabled"';
    } else {
        $r = '';
    }

    $i = 0;
    foreach ($ua[$type] as $key => $value) {
        $s .= '<p ' . $d . '><label><input ' . $r . ' type="radio" name="radio' . $type . '" value="' . $value . '" onclick="$(\'#' . $type . '\').val($(this).val())" />&nbsp;' . $value . '</label></p>';
        $i++;
        if ($i > 1) {
            $d = '';
        }
    }

    echo $s;
}

$csrfToken = $zbp->GetCSRFToken();
?>{/php}
<form id="frmTheme" method="post" action="{BuildSafeCmdURL('act=RewriteMng')}">
<input type="hidden" name="csrfToken" value="{$csrfToken}">
<input id="reset" name="reset" type="hidden" value="" />
<table border="1" class="tableFull tableBorder">
<tr>
    <th class="td20"><p align='left'><b>·静态化选项</b><br><span class='note'>&nbsp;&nbsp;使用伪静态前必须确认主机是否支持</span></p></th>
    <th>
<p><label><input type="radio" <?php echo $zbp->option['ZC_STATIC_MODE'] == 'ACTIVE' ? 'checked="checked"' : ''?> value="ACTIVE" name="ZC_STATIC_MODE" onchange="changeOptions(0);" /> &nbsp;&nbsp;动态</label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" <?php echo !($zbp->option['ZC_STATIC_MODE'] == 'REWRITE' && strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php') === false) ? '' : 'checked="checked"'?>  value="REWRITE"  name="ZC_STATIC_MODE" onchange="changeOptions(2);" />&nbsp;&nbsp;伪静态</label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" <?php echo !($zbp->option['ZC_STATIC_MODE'] == 'REWRITE' && strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php') !== false) ? '' : 'checked="checked"'?>  value="REWRITE"  name="ZC_STATIC_MODE" onchange="changeOptions(1);" />&nbsp;&nbsp;index.php式仿伪静态</label>

</p>
    </th>
    </tr>
<tr>
    <td><p align='left'><b>·文章的URL配置</b></p></td>
    <td><input id='ZC_ARTICLE_REGEX' name='ZC_ARTICLE_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_ARTICLE_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_ARTICLE_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·页面的URL配置</b></p></td>
    <td><input id='ZC_PAGE_REGEX' name='ZC_PAGE_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_PAGE_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_PAGE_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·首页的URL配置</b></p></td>
    <td><input id='ZC_INDEX_REGEX' name='ZC_INDEX_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_INDEX_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_INDEX_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·分类页的URL配置</b></p></td>
    <td><input id='ZC_CATEGORY_REGEX' name='ZC_CATEGORY_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_CATEGORY_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_CATEGORY_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·标签页的URL配置</b></p></td>
    <td><input id='ZC_TAGS_REGEX' name='ZC_TAGS_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_TAGS_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_TAGS_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·日期页的URL配置</b></p></td>
    <td><input id='ZC_DATE_REGEX' name='ZC_DATE_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_DATE_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_DATE_REGEX')?></td>
</tr>
<tr>
    <td><p align='left'><b>·作者页的URL配置</b></p></td>
    <td><input id='ZC_AUTHOR_REGEX' name='ZC_AUTHOR_REGEX' style='width:500px;' type='text' value='<?php echo $zbp->option['ZC_AUTHOR_REGEX']?>'></td>
</tr>
<tr>
    <td></td>
    <td><?php OutputOptionItemsOfUrl('ZC_AUTHOR_REGEX')?></td>
</tr>
<?php

?>
</table>
      <hr/>
      <p>
        1· 规则可以自定义，请注意如果规则解析过于广泛会覆盖之后的规则，浏览页面时就会出现故障.
        <br/>2· index.php式仿伪静态在Apache,IIS下可以不用生成伪静态规则.
      </p>
      <p>
        <input type="submit" class="button" value="{$lang['msg']['submit']}" />
      </p>
      <p>
        &nbsp;
      </p>
    </form>
    <script type="text/javascript">
function changeOptions(i){
    $('input[name^=ZC_]').each(function(){
        var s='radio' + $(this).prop('name');
        $(this).val( $("input[type='radio'][name='"+s+"']").eq(i).val() );
    });
    if(i=='0'){
        $("input[name^='radio']").prop('disabled',true);
        $("input[name='ZC_STATIC_MODE']").val('ACTIVE');
    }else if(i=='1'){
        $("input[name^='radio']").prop('disabled',true);
        $("input[name='ZC_STATIC_MODE']").val('REWRITE');
    }else{
        $("input[name^='radio']").prop('disabled',false);
        $("input[name='ZC_STATIC_MODE']").val('REWRITE');
    }

}
    </script>



</form>
