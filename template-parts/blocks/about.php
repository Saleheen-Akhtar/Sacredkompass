<?php
$heading = get_sub_field('heading');
$body = get_sub_field('body');
$quote = get_sub_field('quote');
$tags = explode(',', get_sub_field('tags'));
?>
<section class="about-section gsap-fade-up" id="about">
  <div class="wrap">
    <div class="about-layout">
      <div class="about-left">
        <h2 class="display-h2"><?php echo esc_html($heading); ?></h2>
        <div class="about-text"><?php echo wp_kses_post($body); ?></div>
      </div>
      <div class="about-right">
        <?php if($quote): ?>
        <div class="about-pull sk-rounded-card">
          <blockquote>"<?php echo esc_html($quote); ?>"</blockquote>
        </div>
        <?php endif; ?>
        <?php if(!empty($tags[0])): ?>
        <div class="tradition-tags">
          <?php foreach($tags as $t): ?>
            <span class="trad-tag"><?php echo esc_html(trim($t)); ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
