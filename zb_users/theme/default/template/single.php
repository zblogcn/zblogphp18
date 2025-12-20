{* Template Name:文章页单页 *}
<!DOCTYPE html>
<html lang="{$lang['lang_bcp47']}">

<head>
  {template:header}
</head>

<body class="single {$type}">
  <div id="divAll">
    <div id="divTop">
      <div class="content-wrapper">
        <h1 id="BlogTitle"><a href="{$host}">{$name}</a></h1>
        <div id="divNavBar">
          <div class="menu-toggle"><span></span><span></span><span></span></div>
          <ul>
            {$modules['navbar'].Content}
          </ul>
        </div>
      </div>
    </div>

    <div id="divMiddle">
      <div id="divMain">
        {if $article.Type==ZC_POST_TYPE_ARTICLE}
        {template:post-single}
        {else}
        {template:post-page}
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