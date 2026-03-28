<?php
$quote = sk_field('quote_text', false, __("We envision a world where well-being and performance coexist harmoniously. By reconnecting people to their inner compass, we help them navigate life's complexities with purpose and alignment.", 'sacred-kompass'));
?>
<div class="quote-band" aria-label="<?php esc_attr_e('Our Vision','sacred-kompass'); ?>">
  <span class="quote-band-large-q" aria-hidden="true">&ldquo;</span>
  <div class="wrap-narrow" style="position:relative;z-index:1;">
    <div class="eyebrow eyebrow-c reveal"><?php esc_html_e('Our Vision','sacred-kompass'); ?></div>
    <blockquote class="reveal d1">
      <?php
      $parts = explode('inner compass', $quote);
      if (count($parts) === 2) {
        echo esc_html($parts[0]) . '<span class="qa">' . esc_html__('inner compass','sacred-kompass') . '</span>' . esc_html($parts[1]);
      } else {
        echo esc_html($quote);
      }
      ?>
    </blockquote>
    <p class="quote-by reveal d2"><?php esc_html_e('Sacred Kompass Collective, Vision Statement','sacred-kompass'); ?></p>
  </div>
</div>
