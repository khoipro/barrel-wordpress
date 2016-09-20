<form method="get" class="searchform" action="<?php bloginfo('url'); ?>/"><fieldset>
	<label for="searchinput" class="acc">Search:</label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="searchinput" class="searchfield" />
	<input type="submit" class="searchsubmit" value="Search" />
</fieldset></form>
