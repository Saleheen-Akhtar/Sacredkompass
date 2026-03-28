<?php
/*
 * Template Name: Privacy Policy
 */
get_header();
?>
<main id="main" class="wrap" style="padding-top:9rem;padding-bottom:8rem;max-width:760px;min-height:60vh;">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
      <h1 class="display-h2" style="margin-bottom:2.5rem;"><?php the_title(); ?></h1>
      <div class="body-serif"><?php the_content(); ?></div>
    </article>
  <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
