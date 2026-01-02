<?php exit(); ?>
<div class="sub">
<!-- 搜索 -->
<form class="search" id="search" method="post" action="#">
		<select class="edit" size="1" name="category">
			<option value="">所有分类</option>
			{foreach $zbp.categoriesbyorder as $id => $cate}
			<option value="{$cate->ID}">{$cate->SymbolName}</option>
			{/foreach}
		</select>
		<select class="edit" size="1" name="status">
			<option value="">所有类型</option>
			<option value="0">{$zbp.lang['post_status_name']['0']}</option>
			<option value="1">{$zbp.lang['post_status_name']['1']}</option>
			<option value="2">{$zbp.lang['post_status_name']['2']}</option>
		</select>
		<label>
			<input type="checkbox" name="istop" value="True">{$zbp.lang['msg']['top']}
		</label>
		<input name="search" type="text" placeholder="请输入…" value="">
		<input type="submit" class="button" value="{$zbp.lang['msg']['submit']}">
</form>
</div><!-- div class="sub" -->
<form method="post" action="{$zbp.host}zb_system/cmd.php?act=PostBat&type={$post_type}">
<!-- 文章列表 -->

<div class="postlist">

				<div class="tr thead">
					<div class="td-5 td-id">ID{$button_id_html}</div>
					<div class="td-10 td-cate">分类{$button_cateid_html}</div>
					<div class="td-10 td-author">作者{$button_authorid_html}</div>
					<div class="td-full td-title">标题</div>
					<div class="td-20 td-date">日期{$button_posttime_html}</div>
					<!-- <div class="td-10 td-view">浏览</div> -->
					<div class="td-10 td-cmt">评论</div>
					<div class="td-10 td-status">状态</div>
					<div class="td-10 td-action">操作</div>
				</div>


	{foreach $articles as $article}

	<div class="tr">
		<div class="td-5 td-id">{$article.ID}</div>
		<div class="td-10 td-cate"><a href="">{$article.Category.Name}</a></div>
		<div class="td-10 td-author"><a href="">{$article.Author.Name}</a></div>
		<div class="td-full td-title"><a href="{$article.Url}">{$article.Title}</a></div>
		<div class="td-20 td-date">{$article.Time()}</div>
		<!-- <div class="td-10 td-view">{$article.ViewNums}</div> -->
		<div class="td-10 td-cmt">{$article.CommNums}</div>
		<div class="td-10 td-status"><span>{$article.StatusName}</span></div>
		<div class="td-10 td-action">
			<a href="../../cmd.php?act=ArticleEdt&amp;id={$article.ID}" class="edit">编辑</a>
			<a href="return confirmDelete();" href="{BuildSafeCmdURL('act=ArticleDel&amp;id=' . $article->ID)}" class="del">删除</a>
		</div>
	</div>

	{/foreach}
<!-- div class="postlist" -->
</div>
<!-- 分页 -->
<p class="pagebar">
	{foreach $p->buttons as $k => $v}
	{if $k == $p->PageNow}
	<span class="now-page">{$k}</span>
	{else}
	<a href="{$v}">{$k}</a>
	{/if}
	{/foreach}

	<!-- 批量删除按钮 -->
	{if $zbp.CheckRights('PostBat') && $zbp.option['ZC_POST_BATCH_DELETE']}

	<input type="submit" class="button pull-right" value="{$zbp.lang['msg']['all_del']}" name="all_del" onclick="return confirmDelete();">

	{/if}
</p>

</form>
<script>
	function confirmDelete() {
		const message = "{$zbp.lang['msg']['confirm_operating']}";
		const confirmed = window.confirm(message);
		return confirmed;
	}
	$("a.order_button").parent().bind("mouseenter mouseleave", function() {
		$(this).find("a.order_button").toggleClass("element-visibility-hidden");
	});
</script>