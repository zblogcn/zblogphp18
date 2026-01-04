<?php exit(); ?>

{php}<?php
function OutputOptionItemsOfUrl($type)
{
    $ua = [
        'ZC_ARTICLE_REGEX' => [
            '{%host%}?id={%id%}',
            '{%host%}index.php/post/{%id%}.html',
            '{%host%}post/{%id%}.html',
            '{%host%}post/{%alias%}.html',
            '{%host%}{%year%}/{%month%}/{%id%}/',
            '{%host%}{%category%}/{%alias%}/',
        ],

        'ZC_PAGE_REGEX' => [
            '{%host%}?id={%id%}',
            '{%host%}index.php/{%id%}.html',
            '{%host%}{%id%}.html',
            '{%host%}{%alias%}.html',
            '{%host%}{%alias%}/',
            //'{%host%}{%alias%}',
        ],

        'ZC_INDEX_REGEX' => [
            '{%host%}?page={%page%}',
            '{%host%}index.php/page_{%page%}.html',
            '{%host%}page_{%page%}.html',
            '{%host%}page_{%page%}/',
            //'{%host%}page_{%page%}',
            '{%host%}page/{%page%}/',
        ],

        'ZC_CATEGORY_REGEX' => [
            '{%host%}?cate={%id%}&page={%page%}',
            '{%host%}index.php/category-{%id%}_{%page%}.html',
            '{%host%}category-{%id%}_{%page%}.html',
            '{%host%}category-{%alias%}_{%page%}.html',
            '{%host%}category/{%alias%}/{%page%}/',
            '{%host%}category/{%id%}/{%page%}/',
        ],

        'ZC_TAGS_REGEX' => [
            '{%host%}?tags={%id%}&page={%page%}',
            '{%host%}index.php/tags-{%id%}_{%page%}.html',
            '{%host%}tags-{%id%}_{%page%}.html',
            '{%host%}tags-{%alias%}_{%page%}.html',
            '{%host%}tags/{%alias%}/{%page%}/',
        ],

        'ZC_DATE_REGEX' => [
            '{%host%}?date={%date%}&page={%page%}',
            '{%host%}index.php/date-{%date%}_{%page%}.html',
            '{%host%}date-{%date%}_{%page%}.html',
            '{%host%}post/{%date%}_{%page%}.html',
            '{%host%}date/{%date%}/{%page%}/',
        ],

        'ZC_AUTHOR_REGEX' => [
            '{%host%}?auth={%id%}&page={%page%}',
            '{%host%}index.php/author-{%id%}_{%page%}.html',
            '{%host%}author-{%id%}_{%page%}.html',
            '{%host%}author/{%id%}/{%page%}/',
            '{%host%}author/{%alias%}/{%page%}/',
        ],
    ];

    global $zbp;
    $s = '';
    $d = 'style="display:none;"';
    if ('ACTIVE' == $zbp->option['ZC_STATIC_MODE'] || false !== strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php')) {
        $r = 'disabled="disabled"';
    } else {
        $r = '';
    }

    $i = 0;
    foreach ($ua[$type] as $key => $value) {
        $s .= '<p ' . $d . '><label><input ' . $r . ' type="radio" name="radio' . $type . '" value="' . $value . '" onclick="$(\'#' . $type . '\').val($(this).val())" />&nbsp;' . $value . '</label></p>';
        ++$i;
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
<table class="tableFull tableBorder table_striped">
<tr>
    <th class="td20"><p align='left'><b>·静态化选项</b><br><span class='note'>&nbsp;&nbsp;使用伪静态前必须确认主机是否支持</span></p></th>
    <th>
<p><label><input type="radio" {trim($option['ZC_STATIC_MODE'] == 'ACTIVE' ? 'checked="checked"'  : '')} value="ACTIVE" name="ZC_STATIC_MODE" onchange="changeOptions(0);" /> &nbsp;&nbsp;动态</label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" {trim( !($option['ZC_STATIC_MODE'] == 'REWRITE' && strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php') === false) ? '' : 'checked="checked"' )}  value="REWRITE"  name="ZC_STATIC_MODE" onchange="changeOptions(2);" />&nbsp;&nbsp;伪静态</label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" {trim( !($option['ZC_STATIC_MODE'] == 'REWRITE' && strpos($zbp->option['ZC_ARTICLE_REGEX'], '{%host%}index.php') !== false) ? '' : 'checked="checked"' )}  value="REWRITE"  name="ZC_STATIC_MODE" onchange="changeOptions(1);" />&nbsp;&nbsp;index.php式仿伪静态</label>

</p>
    </th>
    </tr>
<tr>
    <td><p align='left'><b>·文章的URL配置</b></p></td>
    <td><input id='ZC_ARTICLE_REGEX' name='ZC_ARTICLE_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_ARTICLE_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_ARTICLE_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·页面的URL配置</b></p></td>
    <td><input id='ZC_PAGE_REGEX' name='ZC_PAGE_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_PAGE_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_PAGE_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·首页的URL配置</b></p></td>
    <td><input id='ZC_INDEX_REGEX' name='ZC_INDEX_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_INDEX_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_INDEX_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·分类页的URL配置</b></p></td>
    <td><input id='ZC_CATEGORY_REGEX' name='ZC_CATEGORY_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_CATEGORY_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_CATEGORY_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·标签页的URL配置</b></p></td>
    <td><input id='ZC_TAGS_REGEX' name='ZC_TAGS_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_TAGS_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_TAGS_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·日期页的URL配置</b></p></td>
    <td><input id='ZC_DATE_REGEX' name='ZC_DATE_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_DATE_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_DATE_REGEX')}</td>
</tr>
<tr>
    <td><p align='left'><b>·作者页的URL配置</b></p></td>
    <td><input id='ZC_AUTHOR_REGEX' name='ZC_AUTHOR_REGEX' style='width:500px;' type='text' value='{$zbp->option['ZC_AUTHOR_REGEX']}'></td>
</tr>
<tr>
    <td></td>
    <td>{OutputOptionItemsOfUrl('ZC_AUTHOR_REGEX')}</td>
</tr>
<?php

?>
</table>
      <hr/>
      <p>
        <a href="https://docs.zblogcn.com/php/#/books/start-30-rewrite" target="_blank"><i class="icon-flag-fill" style="font-size:small; margin-right: 0.2em;"></i>伪静态配置指南</a>
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
