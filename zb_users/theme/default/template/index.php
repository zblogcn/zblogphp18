{* Template Name:首页及列表页 *}
<!DOCTYPE html>
<html lang="{$lang['lang_bcp47']}">

<head>
  {template:header}
</head>

<body class="multi {$type}">
  <div id="divAll">
    <div id="divTop">
      <div class="content-wrapper">
        <h1 id="BlogTitle"><a href="{$host}">{$name}</a></h1>
        <div id="divNavBar">
          <div class="menu-toggle"><span></span><span></span><span></span></div>
          <ul>
            {module:navbar}
          </ul>
        </div>
      </div>
    </div>
    
    <div id="divMiddle">
      <div id="divMain">
        {foreach $articles as $article}

        {if $article.TopType}
        {template:post-istop}
        {else}
        {template:post-multi}
        {/if}

        {/foreach}
        <div class="pagebar">{template:pagebar}</div>
      </div>
      <div id="divSidebar">
        {template:sidebar}
      </div>
    </div>
    
    {template:footer}
  </div>
</body>

</html>