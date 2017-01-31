<div class="row-no-max grid-spaceBetween tags-wrap">

	<div class="col grid-middle">

		<?php $category = get_the_terms( get_the_ID(), 'category' )[0];

		if( $category ): ?>

		<div class="col">

			<?php get_template_part('template-parts/icon-' . $category->slug ); ?>

			<h5><?php echo $category->name; ?></h5>
		</div>

		<?php endif;

		$tags = get_the_tags();

		$tags_ids = [];

		if( $tags ) {

			foreach($tags as $tag):

				array_push( $tags_ids, $tag->term_id ); ?>

				<div class="col">

					<h5><?php echo $tag->name; ?></h5>
				</div>

			<?php endforeach;
		} ?>

	</div>

</div>


