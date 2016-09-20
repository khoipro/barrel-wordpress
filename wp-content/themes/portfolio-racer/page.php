<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<article class="page-wrap" id="page-<?php the_ID(); ?>">
		<?php edit_post_link('Edit', '<p class="edit">', '</p>'); ?>
		<h1><?php the_title(); ?></h1>
		
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		
		<p class="page-meta-footer">Updated: <?php the_modified_date(); ?></p>
	</article><!--post-->
	
	<?php $page_walk = get_neighbour_links();
	if (!empty($page_walk)) : ?>
		<ul class="page-nav">
		<?php if (!empty($page_walk['prev']))
				print str_replace("%link", $page_walk['prev'], '<li class="prev"><span>&laquo;</span> <strong>%link</strong></li>'); ?>
		<?php if (!empty($page_walk['next']))
				print str_replace("%link", $page_walk['next'], '<li class="next"><span>&raquo;</span> <strong>%link</strong></li>'); ?>
		</ul>
	<?php endif; ?>
	
	
	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	
<?php get_footer(); ?>