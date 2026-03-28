<?php
$heading = get_sub_field('heading');
$values = get_sub_field('values_list');
?>
<section class="values-section gsap-fade-up">
  <div class="wrap">
    <?php if($heading): ?>
      <div class="values-header">
        <h2 class="display-h2"><?php echo esc_html($heading); ?></h2>
      </div>
    <?php endif; ?>

    <div class="values-grid" style="border:none;">
      <?php if($values): foreach($values as $value): ?>
        <div class="value-card sk-rounded-card" style="border: 1px solid var(--border-light) !important;">
          <?php if($value['number']): ?>
            <span class="value-num"><?php echo esc_html($value['number']); ?></span>
          <?php endif; ?>
          <h3><?php echo esc_html($value['title']); ?></h3>
          <p><?php echo esc_html($value['desc']); ?></p>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
