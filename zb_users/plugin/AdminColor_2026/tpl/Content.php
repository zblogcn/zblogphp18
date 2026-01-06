<?php exit; ?>
{php}
<?php
$formColors = [
    'NormalColor' => '标准色',
    'BoldColor'   => '深色',
    'LightColor'  => '浅色',
    'HighColor'   => '高光色',
    'AntiColor'   => '反色',
];
?>
{/php}

<form action="{php}<?php echo BuildSafeURL('main.php?act=save'); ?>{/php}" method="post">
    <table width="100%" class="tableBorder table_striped">
        <tr>
            <th width="10%">项目</th>
            <th>内容</th>
            <th width="45%">说明</th>
        </tr>
        <tr>
            <td>开启配色功能</td>
            <td>{php}<?php zbpform::zbradio('opt_Enable', $zbp->Config('AdminColor_2026')->opt_Enable); ?>{/php}</td>
            <td></td>
        </tr>
        <!-- 预置色彩方案 -->
        <tr>
            <td>预置色彩方案</td>
            <td colspan="2">
                <div class="ac-preset-bar" id="acPresetBar"></div>
            </td>
        </tr>
        {foreach $formColors as $key => $label}
        <tr>
            <td>{$label}</td>
            <td>{php}<?php zbpform::text($key, $cfg_colors->{$key}, '90%', 'color-picker'); ?>{/php} <span class="ac-color-span span-{$key}" style="background-color: {$cfg_colors.$key};"></span></td>
            <td></td>
        </tr>
        {/foreach}
        <tr class="hidden">
            <td>代表色</td>
            <td colspan="2">
                {php}<?php zbpform::text('Square', $cfg_colors->Square, '90%'); ?>{/php}
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><input type="submit" value="提交" /></td>
        </tr>
    </table>
</form>

<script>
    // 预置数据
    const presets = JSON.parse('{php}<?php echo json_encode($preset_colors, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>{/php}');
</script>
