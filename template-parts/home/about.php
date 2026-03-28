<?php
$heading  = sk_field('about_heading', false, __('Where the Sacred Meets the Everyday', 'sacred-kompass'));
$default  = '<p>' . __('Sacred Kompass is a transformative wellness and consciousness-based consultancy. We weave together ancient wisdom, Vedic philosophy, Jyotish astrology, meditation, and self-awareness, with modern frameworks like Nonviolent Communication and emotional resilience practices.', 'sacred-kompass') . '</p>'
          . '<p>' . __('We are not about temporary fixes. We are about in-depth transformation, supporting individuals, leaders, and organisations in cultivating inner clarity, compassionate engagement, and sustainable growth from the inside out.', 'sacred-kompass') . '</p>';
$body     = sk_field('about_body', false, '') ?: $default;
$traditions = ['Vedic Philosophy','Jyotish Astrology','Meditation','NVC','Sacred Feminine','Breathwork','Energy Healing','Emotional Resilience'];
?>
<section class="about-section" id="about" aria-labelledby="about-heading">
  <div class="wrap">

    <div class="reveal">
      <div class="eyebrow"><?php esc_html_e('Our Philosophy','sacred-kompass'); ?></div>
    </div>

    <div class="about-layout">

      <div>
        <h2 class="display-h2 reveal d1" id="about-heading">
          <?php echo esc_html($heading); ?>
        </h2>
        <div class="about-text reveal d2">
          <?php echo wp_kses_post($body); ?>
        </div>
        <div class="tradition-tags reveal d3">
          <?php foreach ($traditions as $t) : ?>
            <span class="trad-tag"><?php echo esc_html($t); ?></span>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <div class="about-right-large reveal" aria-hidden="true">Wisdom</div>
        <div class="about-pull reveal d2">
          <blockquote>
            <?php esc_html_e('"True transformation is not found. It is remembered. We walk with you back to what was always whole."', 'sacred-kompass'); ?>
          </blockquote>
          <span class="attr"><?php esc_html_e('Sacred Kompass, Our Philosophy', 'sacred-kompass'); ?></span>
        </div>
      </div>

    </div>
  </div>
</section>
