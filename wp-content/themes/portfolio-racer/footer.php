</div></section><!-- content-main -->

<?php show_widget_area('sidebar'); ?>

<?php show_widget_area('margin'); ?>

<?php if (sidebar_not_empty('footer-column-1') || sidebar_not_empty('footer-column-2') || sidebar_not_empty('footer-column-3')) : ?>
<footer id="footer-area">
		<?php show_widget_area('footer-column-1'); ?>
		<?php show_widget_area('footer-column-2'); ?>
		<?php show_widget_area('footer-column-3'); ?>
</footer>
<?php endif; ?>

<footer id="footer-wrap">
	<?php show_widget_area('footer-main'); ?>
	
	<div id="footer-margin">
		<?php dynamic_sidebar('footer-margin'); ?>
		<p class="powered-by">
			<span>Powered by <a href="http://wordpress.org">WordPress</a></span> and <a href="http://portfolio.konstruktors.com/">Portfolio Racer</a>
			<!-- <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds-->
		</p>
	</div>
</footer><!--footer-wrap -->

</div><!-- soul -->

<?php wp_footer(); ?>
</body>
</html>