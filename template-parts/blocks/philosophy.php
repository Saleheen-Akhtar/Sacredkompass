<?php
$pillars = get_sub_field('pillars');
?>
<section class="strip gsap-fade-up">
  <div class="wrap">
    <div class="strip-inner">
      <?php if($pillars): foreach($pillars as $pillar): ?>
        <div class="strip-pillar sk-rounded-card" style="border: none; margin: 10px;">
          <span class="strip-num"><?php echo esc_html($pillar['number']); ?></span>
          <h4><?php echo esc_html($pillar['title']); ?></h4>
          <p><?php echo esc_html($pillar['desc']); ?></p>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
