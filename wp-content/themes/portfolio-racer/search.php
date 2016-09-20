<?php get_header(); ?>

<div class="body-main">

<div id="content-main" class="bb-t20"><div class="searchresults content-inside">
	
    <?php if (have_posts()) : ?>
    <div class="archives"><div class="post">
    <h1 class="sec-title">Search results for <em><?php the_search_query(); ?></em></h1>
    
		<?php while (have_posts()) : the_post(); ?>
    		<div class="post bb-tbase" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<p class="postinfo">
					<em class="date"><?php the_time('F jS') ?></em> &bull; 
					<span class="commentcount"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>  &bull;
					<span class="categories">Under: <?php the_category(', ') ?></span> <?php the_tags( '&bull; Tags: ', ', ', ''); ?>
                    <?php edit_post_link('Edit', ' &bull; ', ''); ?>
                </p>
					
				<?php the_content('Read more &raquo;'); ?>
			</div>
		<?php endwhile; ?>

	<div class="bb-tbase nav-entry-pages">
		<p class="bb-t10 bb-fa"><?php next_posts_link('&laquo; Older Entries') ?></p>
		<p class="bb-t10 bb-fc next"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
	</div>
	</div></div>
	<?php else : ?>
	<div class="post">
		<h1>No results for <em><?php the_search_query(); ?></em></h1>
		<p>Try some other keywords or <a href="<?php bloginfo('url'); ?>/">go to the start page</a> of <?php echo bloginfo('name'); ?>.</p>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		<div class="bb-tbase widget">
		<div class="bb-t15 bb-fa"></div>
		<div class="bb-t12 bb-fc"><?php include (TEMPLATEPATH . '/widget-postrelated.php'); ?><?php dynamic_sidebar('sidebar-postnav'); ?></div>
		</div>
	</div>
	<?php endif; ?>
	
</div></div>
	
<div id="content-sub" class="bb-t9">
	<?php get_sidebar(); ?>
	<?php dynamic_sidebar('secondary content'); ?>
</div>

</div><!--body-main-->

<div class="body-margin">
<div id="content-margin"><div class="content-inside">
	<?php dynamic_sidebar('margin'); ?>
</div></div>
</div>

<?php get_footer(); ?>
