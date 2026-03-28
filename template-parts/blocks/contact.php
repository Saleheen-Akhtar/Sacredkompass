<?php
$heading = get_sub_field('heading');
$subtext = get_sub_field('subtext');
$form_id = get_sub_field('form_id');
?>
<section class="cta-section gsap-fade-up" id="contact">
  <div class="wrap">
    <div class="cta-layout">
      <div class="cta-text-col">
        <h2 class="cta-h2"><?php echo esc_html($heading); ?></h2>
        <p class="cta-sub"><?php echo esc_html($subtext); ?></p>
      </div>
      <div class="cta-form-col sk-rounded-card">
        <?php
        if($form_id) {
          echo do_shortcode('[forminator_form id="'. esc_attr($form_id) .'"]');
        }
        ?>
      </div>
    </div>
  </div>
</section>
