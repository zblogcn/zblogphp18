<?php exit(); ?>
<script {if isset($main.Js_Nonce)}nonce="{$main.Js_Nonce}"{/if}>
    AddHeaderFontIcon("{$main.HeaderIcon}");
    ActiveTopMenu("{$main.ActiveTopMenu}");
    ActiveLeftMenu("{$main.ActiveLeftMenu}");
</script>
{$footer}
{php}HookFilterPlugin('Filter_Plugin_Admin_Footer');{/php}
