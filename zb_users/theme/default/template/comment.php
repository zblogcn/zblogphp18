{* Template Name:单条评论 *}
<ul class="msg" id="cmt{$comment.ID}">
	<li class="msgname">
		<img class="avatar" src="{$comment.Author.Avatar}" alt="" width="32"/>
		<span class="commentname"><a href="{$comment.Author.HomePage}" rel="nofollow" target="_blank">{$comment.Author.StaticName}</a></span>
		<small>{$lang['default']['comment_post_on']} {$comment.Time()} <span class="revertcomment"><a href="#comment" onclick="zbp.comment.reply('{$comment.ID}')">{$lang['default']['reply']}</a></span></small>
	</li>
	<li class="msgarticle">{$comment.Content}
		{foreach $comment.Comments as $comment}
		{template:comment}
		{/foreach}
	</li>
</ul>