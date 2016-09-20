<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="post-wrap" id="post-<?php the_ID(); ?>"> 
		<?php edit_post_link('Edit', '<p class="edit">', '</p>'); ?>
		<h1><?php the_title(); ?></h1>
		
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p class="post-pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		<footer class="post-footer">
			<p class="meta-all"><em>On</em> <?php the_time('F j<\s\u\p>S</\s\u\p>, Y') ?> <?php the_category(', ') ?> <?php the_tags( '<span class="acc"><strong>tagged</strong>: ', ', ', '</span>'); ?></p>
			<ul class="page-nav">
				<?php next_post_link('<li class="next"><span>&raquo;</span> <strong>%link</strong></li>'); ?>
				<?php previous_post_link('<li class="prev"><span>&laquo;</span> <strong>%link</strong></li>') ?>
			</ul>
		</footer>
	</article><!--post-->

	<?php comments_template(); ?>
	
<?php endwhile; else: ?>
	<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>

<?php get_footer(); ?>