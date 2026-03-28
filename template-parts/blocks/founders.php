<?php
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$founders = get_sub_field('founders_list');
?>
<section class="founders-section gsap-fade-up" id="founders">
  <div class="wrap">

    <div class="founders-header">
      <div class="founders-header-left">
        <h2 class="display-h2"><?php echo esc_html($heading); ?></h2>
      </div>
      <div class="founders-header-right">
        <?php echo esc_html($subheading); ?>
      </div>
    </div>

    <div class="founders-duo">
      <?php if($founders): foreach($founders as $founder): ?>
        <div class="founder-unit sk-rounded-card" style="padding: 2rem; border: none; margin: 10px;">
          <?php if($founder['image']): ?>
            <div class="founder-portrait sk-rounded-card">
              <img src="<?php echo esc_url($founder['image']['sizes']['large']); ?>" alt="<?php echo esc_attr($founder['name']); ?>">
            </div>
          <?php endif; ?>
          <div class="founder-meta">
            <h3 class="founder-name"><?php echo esc_html($founder['name']); ?></h3>
            <span class="founder-role-label"><?php echo esc_html($founder['role']); ?></span>
          </div>
          <p class="founder-bio"><?php echo esc_html($founder['bio']); ?></p>
        </div>
      <?php endforeach; endif; ?>
    </div>

  </div>
</section>
