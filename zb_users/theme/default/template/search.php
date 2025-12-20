{* Template Name:搜索页 *}
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
        <div class="post istop istop-post">
          <h2 class="post-title">{$article.Title}</h2>
        </div>
        {foreach $articles as $article}
        {template:post-search}
        {/foreach}
        {if count($articles)>0}
        <div class="pagebar">{template:pagebar}</div>
        {/if}
      </div>
      <div id="divSidebar">
        {template:sidebar}
      </div>
    </div>
    
    {template:footer}
  </div>
</body>

</html>