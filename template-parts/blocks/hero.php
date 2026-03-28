<?php
$bg = get_sub_field('bg_image');
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
?>
<section class="hero-centered gsap-parallax" style="background-image: url('<?php echo esc_url($bg); ?>');">
  <div class="hero-overlay"></div>
  <div class="hero-content wrap gsap-fade-up">
    <?php if($heading): ?>
      <h1 class="display-xl"><?php echo wp_kses_post($heading); ?></h1>
    <?php endif; ?>
    <?php if($subheading): ?>
      <p class="hero-sub"><?php echo wp_kses_post($subheading); ?></p>
    <?php endif; ?>
  </div>
</section>
