<?php
$offerings = get_sub_field('offerings_list');
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
?>
<section class="offerings-section gsap-fade-up" id="offerings">
  <div class="wrap">
    <?php if($heading || $subheading): ?>
    <div class="offerings-header">
      <h2 class="display-h2"><?php echo esc_html($heading); ?></h2>
      <?php if($subheading): ?><p class="body-serif"><?php echo esc_html($subheading); ?></p><?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="offerings-grid">
      <?php if($offerings): foreach($offerings as $offering): ?>
        <div class="offering-card sk-rounded-card">
          <?php if($offering['image']): ?>
            <div class="offering-img sk-rounded-card" style="border-radius: 12px; margin-bottom: 15px;">
              <img src="<?php echo esc_url($offering['image']['sizes']['medium']); ?>" alt="<?php echo esc_attr($offering['title']); ?>">
            </div>
          <?php endif; ?>
          <span class="offering-tag"><?php echo esc_html($offering['tag']); ?></span>
          <h3 class="offering-title"><?php echo esc_html($offering['title']); ?></h3>
          <p class="offering-desc"><?php echo esc_html($offering['desc']); ?></p>
          <?php if($offering['price']): ?>
            <span class="offering-price"><?php echo esc_html($offering['price']); ?></span>
          <?php endif; ?>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
