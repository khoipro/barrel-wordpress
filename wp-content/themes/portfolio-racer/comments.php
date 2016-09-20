<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
	<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php 
	return; 
}

$oddcomment = "alt";
if (have_comments()) : ?>

<h2 class="comment-count" id="comments"><?php comments_number('No Responses', 'One Comment', '% Comments');?></h2>

<p class="comment-add-link">
<?php if ('open' == $post->comment_status) : ?>
	<a href="#respond" class="comment-anchor">Add a Comment</a>
<?php else : ?>
	Comments closed
<?php endif; ?>
<?php if (('open' == $post-> comment_status) || ('open' == $post->ping_status)) : ?>
	<a href="<?php trackback_url(); ?>" rel="nofollow trackback" class="trackback-url">Trackback URL</a>
<?php endif; ?>
</p>

<?php 
foreach ($comments as $comment) :
	$comment_type = get_comment_type();
	if ($comment_type !== 'comment') $havetrackbacks = true;
	if ($comment_type == 'comment') $havecomments = true;
endforeach;

if ($havecomments) : ?>

<dl class="comments">

<script type="text/javascript">/* <![CDATA[ */
function addAuthor($authorName, $commentId) {
  var $author = '<a href="#comment-' + $commentId + '">' + $authorName + '</a>, ';
  document.getElementById('comment').value += $author;
}
function moveToComment() { location.href  = '#comment'; document.getElementById('comment').focus(); }
/* ]]> */</script>

<?php 
$counter = 0;
foreach ($comments as $comment) : 
	$comment_type = get_comment_type();
	if ($comment_type !== 'comment')
		$hastrackbacks = true;
		
	if ($comment_type == 'comment') :  ++$counter;
?>

<dt class="comment <?php if ($counter % 2) echo $oddcomment; ?> <?php if ($comment->user_id == get_the_author_ID()) print 'by-author'; ?>" id="comment-<?php comment_ID() ?>">

<?php if (get_comment_author_url() !== '') : ?>
	<cite class="comment-author"><a href="<?php comment_author_url(); ?>" rel="nofollow"><?php echo get_avatar($comment, $size = '40'); ?> <strong><?php comment_author() ?></strong></a></cite>
<?php else: ?>
	<cite><?php echo get_avatar($comment, $size = '40'); ?> <strong><?php comment_author() ?></strong></cite>
<?php endif; ?>		
	<a class="date" href="#comment-<?php comment_ID() ?>" title="Link to this comment" rel="nofollow"><abbr title="<?php comment_date('r') ?>"><?php comment_date('M j') ?>, <?php comment_time('G:i') ?></abbr></a>
</dt>
	
<dd>
<script type="text/javascript">
document.write('<a href="#comment" onmouseup="moveToComment()" onclick="addAuthor(\'<?php comment_author();  ?>\', \'<?php comment_ID();  ?>\');return false;" class="reply" rel="nofollow" title="Automatically include a link to the original comment">Reply</a>');
</script>

	<?php if ($comment->comment_approved == '0') : ?><p class="note"><em>Your comment is awaiting moderation.</em></p><?php endif; ?>
	<?php comment_text() ?>
</dd>

<?php endif; ?>
<?php endforeach; // comment ?>
</dl><!--comments-->
<?php endif; ?>

<?php if ($havetrackbacks) :  ?>
<div class="trackbacks">
	<h3 id="trackbacks">On other blogs (trackbacks):</h3>
	
	<ul>
	<?php $counter = 0; 
		foreach ($comments as $comment) : 
		$comment_type = get_comment_type();
		if ($comment_type !== 'comment') : ++$counter;
	?>
		<li class="<?php if ($counter % 2) echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<a href="<?php comment_author_url() ?>"><?php comment_author() ?></a> <a href="#comment-<?php comment_ID() ?>" title="<?php comment_date('F j, Y') ?> at <?php comment_time() ?>" class="datetime">#</a>
		</li>
		
		<?php endif; ?>
	<?php endforeach; // eachtrackbacks ?>
	</ul>
	</div>
	<?php endif; // iftrackbacks ?>
<?php endif; // comments ?>
<?php 
/* Add Comment */
if ('open' == $post->comment_status) : ?>
<h2 id="respond">Leave a Comment</h2>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<div class="comment-input">
		  <p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="1"></textarea></p>
		</div>
		<?php if ( $user_ID ) : ?>
			<div class="author-inputs">
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
			</div>
		<?php else : ?>
			<div class="credits">
			
			<?php 
			if (function_exists('is_user_openid')) $openid_active = true;
			
			if ($openid_active) : ?>
				<p><label for="url">OpenID <em>or</em> Website</label>
				<span><input title="Enter your OpenID or website URL" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="2" /></span></p>
			<?php endif; ?>
			
			<p><label for="author">Name <?php if ($req) echo "(required)"; ?></label>
			<span><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="3" /></span></p>
			<p><label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label>
			<span><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="4" /></span></p>
		
			<?php if (!$openid_active) : ?>
				<p><label for="url">Website</label>
				<span><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="5" /></span></p>	
			<?php endif; ?>
		
		</div>
		
		<?php endif; ?>
<div class="commentform-footer">
		<p class="comment-buttons"><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></p>
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		<?php do_action('comment_form', $post->ID); ?>
</div>
</form>
<?php endif; // If registration required and not logged in ?>
<?php endif; ?>

<?php if ($post->comment_status == 'closed') : ?>
<p class="comments-closed">Comments closed. <a href="/blog/contact?subject=Comment about &#8216;<?php print the_title(); ?>&#8217;" rel="nofollow">Leave me a message &raquo;</a></p>
<?php endif; ?>