<?php get_header(); ?>

<?php get_sec_title(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article class="post-wrap" id="post-<?php the_ID(); ?>">
	<?php edit_post_link('Edit', '<p class="edit">', '</p>'); ?>	
	<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<p class="post-meta-top">
		<em><abbr title="<?php the_time('r'); ?>" class="date"><?php the_time('M j'); ?></abbr></em> 
		<?php if (get_the_category()) : ?> <span class="categories"><?php the_category(', '); ?></span><?php endif; ?>
	</p>	
	<?php
		$more_link_text = 'Read&nbsp;more&nbsp;&raquo;';
		the_content($more_link_text);
	?>
</article>
<?php endwhile; ?>
<?php else : ?>
	<p>No content has been added yet.</p>
<?php endif; ?>

<?php if (get_previous_posts_link() || get_next_posts_link()) : ?>
	<ul class="page-nav">
		<li class="next"><?php previous_posts_link('<span>&raquo;</span> <strong>Next Posts</strong>') ?></li>
		<li class="prev"><?php next_posts_link('<span>&laquo;</span> <strong>Previous Posts</strong>') ?></li>
	</ul>
<?php endif; ?>

<?php get_footer(); ?>