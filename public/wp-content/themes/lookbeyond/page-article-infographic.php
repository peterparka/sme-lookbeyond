<?php
/*
Template Name: Article Infographic
*/
get_header();

?>

<!-- WRAPPER -->
<main role="main">

	<?php get_template_part('template-parts/nav'); ?>

  <section class="bg-white no-pad article">

  <article class="os-animation" data-os-animation="fadeInUp">
    <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sit amet </h3>
    <h5>Aug 16, 2016</h5>
    <?php get_template_part('template-parts/share'); ?>
    <div class="infographic-wrap">
      <img src="<?php echo get_template_directory_uri(); ?>/_img/article-infographic.jpg" alt="">
    </div>
    <p>
      Think back to the first music you owned that was truly yours. A song spoke to you in a special way, so you went out and bought the record, or you begged your parents for the tape, or you traded your best friend for the CD, or maybe you convinced your brother to let you download it on his mp3 player.
    </p>


    <div class="row-no-max grid-spaceBetween tags-wrap">

			<div class="col grid-middle">

				<div class="col">
					<?php get_template_part('template-parts/icon-article'); ?>
					<h5>Article</h5>
				</div>
        <div class="col">
          <h5>Look Again</h5>
        </div>
        <div class="col">
          <h5>Look Back</h5>
        </div>

			</div>

</div>

    <?php get_template_part('template-parts/share'); ?>

  </article>

  </section>

  <section class="bg-shaded box-wrap">

    <h4>Related Content</h4>

    <ul class="row-no-max grid-center">

      <li class="col">
        <a href="/article/">
          <article>

            <div class="box-image">
              <img src="<?php echo get_template_directory_uri(); ?>/_img/article-innovation.jpg" alt="" >
            </div>

            <div>

              <div class="grid-middle">
                <?php get_template_part('template-parts/icon-article'); ?>
                <span class="theme-2">Look Again</span>
                <span class="theme-3">Look Back</span>
              </div>

              <div class="grid">
                <h4 class="col-12">Love music? The way you listen to it has completely changed because of oil and gas</h4>
                <span>Aug 16, 2016</span>
                <div class="grid-right">
                  <span>102</span>
                  <?php get_template_part('template-parts/icon-heart'); ?>
                </div>
              </div>

            </div>

          </article>
        </a>
      </li>

      <li class="col">
        <a href="/article/">
          <article>

            <div class="box-image">
              <img src="<?php echo get_template_directory_uri(); ?>/_img/article-90s.jpg" alt="nintendo" >
            </div>

            <div>

              <div class="grid-middle">
                <?php get_template_part('template-parts/icon-article'); ?>
                <span class="theme-3">Look Back</span>
              </div>

              <div class="grid">
                <h4 class="col-12">90s flashback: You know all of these toys but you didn’t know what they were made from</h4>
                <span>July 16, 2016</span>
                <div class="grid-right">
                  <span>49</span>
                  <?php get_template_part('template-parts/icon-heart'); ?>
                </div>
              </div>

            </div>

          </article>
        </a>
      </li>

      <li class="col">
        <a href="/article/">
          <article>

            <div class="box-image">
              <img src="<?php echo get_template_directory_uri(); ?>/_img/article-quiz.jpg" alt="nintendo" >
            </div>

            <div>

              <div class="grid-middle">
                <?php get_template_part('template-parts/icon-article'); ?>
                <span class="theme-1">Look Around</span>
              </div>

              <div class="grid">
                <h4 class="col-12">Quiz: These items have one surprising thing in common. How many have you used already today?</h4>
                <span>March 16, 2016</span>
                <div class="grid-right">
                  <span>106</span>
                  <?php get_template_part('template-parts/icon-heart'); ?>
                </div>
              </div>

            </div>

          </article>
        </a>
      </li>
    </ul>

</section>

<?php get_footer(); ?>
