<?php
$large_bg_text = get_sub_field('large_bg_text');
$quote = get_sub_field('quote');
$author = get_sub_field('author');
$eyebrow = get_sub_field('eyebrow');
?>
<section class="quote-band gsap-fade-up">
  <?php if($large_bg_text): ?>
    <div class="quote-band-large-q"><?php echo esc_html($large_bg_text); ?></div>
  <?php endif; ?>

  <div class="wrap">
    <?php if($eyebrow): ?>
      <div class="eyebrow eyebrow-c"><?php echo esc_html($eyebrow); ?></div>
    <?php endif; ?>

    <?php if($quote): ?>
      <blockquote>"<?php echo esc_html($quote); ?>"</blockquote>
    <?php endif; ?>

    <?php if($author): ?>
      <div class="quote-by"><?php echo esc_html($author); ?></div>
    <?php endif; ?>
  </div>
</section>
