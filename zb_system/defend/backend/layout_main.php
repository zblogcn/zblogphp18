<?php exit(); ?>
<section class="main {$action}">
{php}$zbp->GetHint();{/php}
{php}HookFilterPlugin('Filter_Plugin_Admin_Hint');{/php}
  <div id="divMain">
    <div class="divHeader">{$main.Header}</div>
    <div class="SubMenu">{$main.SubMenu}</div>
    <div id="divMain2">
        {$main.Content}
    </div>
  </div>
</section>
