<?php
/* Offerings — ACF repeater: offering_title, offering_desc, offering_tag, offering_price, offering_image */

$acf_offerings = function_exists('get_field') ? get_field('offerings') : [];
$fallback = [
  ['offering_title' => __('Meditation & Mindfulness',           'sacred-kompass'), 'offering_desc' => __('Tailored practices for stress reduction, focus, and emotional balance, meeting you wherever you are on your inner journey.', 'sacred-kompass'), 'offering_tag' => __('Personal',    'sacred-kompass'), 'offering_price' => '', 'offering_image' => null],
  ['offering_title' => __('Compassionate Communication',        'sacred-kompass'), 'offering_desc' => __('Nonviolent Communication tools to foster empathy, resolve conflicts, and build stronger, more authentic relationships.',     'sacred-kompass'), 'offering_tag' => __('Relational',  'sacred-kompass'), 'offering_price' => '', 'offering_image' => null],
  ['offering_title' => __('Astrology & Strategic Insight',      'sacred-kompass'), 'offering_desc' => __("Vedic Jyotish astrology as a living guidance system for clarity on aligned decision-making, timing, and sacred cycles.",     'sacred-kompass'), 'offering_tag' => __('Guidance',    'sacred-kompass'), 'offering_price' => '', 'offering_image' => null],
  ['offering_title' => __("Women's Wellness & Empowerment",     'sacred-kompass'), 'offering_desc' => __("Programmes supporting women in reclaiming their sacred power, well-being, and intuitive wisdom through the sacred feminine.",  'sacred-kompass'), 'offering_tag' => __('Empowerment', 'sacred-kompass'), 'offering_price' => '', 'offering_image' => null],
  ['offering_title' => __('Leadership & Organisational Alignment','sacred-kompass'),'offering_desc' => __('Workshops to integrate conscious leadership, emotional resilience, and holistic growth — culture built from the inside out.',  'sacred-kompass'), 'offering_tag' => __('Corporate',   'sacred-kompass'), 'offering_price' => '', 'offering_image' => null],
];
$offerings = $acf_offerings ?: $fallback;
?>
<section class="offerings-section" id="offerings" aria-labelledby="offerings-heading">
  <div class="wrap">

    <div class="offerings-header">
      <div class="eyebrow eyebrow-c reveal"><?php esc_html_e('What We Offer','sacred-kompass'); ?></div>
      <h2 class="display-h2 reveal d1" id="offerings-heading">
        <?php esc_html_e('Pathways of','sacred-kompass'); ?> <em><?php esc_html_e('Guidance','sacred-kompass'); ?></em>
      </h2>
      <p class="body-serif reveal d2">
        <?php esc_html_e('Each pathway is an invitation, not a prescription. We meet you exactly where you are, and walk with you from there.','sacred-kompass'); ?>
      </p>
    </div>

    <div class="offerings-grid reveal">
      <?php foreach ($offerings as $idx => $o) :
        $num   = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        $image = $o['offering_image'] ?? null;
      ?>
      <div class="offering-card">

        <?php if (!empty($image['url'])) : ?>
          <div class="offering-img">
            <img src="<?php echo esc_url($image['url']); ?>"
                 alt="<?php echo esc_attr($image['alt'] ?? $o['offering_title']); ?>"
                 loading="lazy"/>
          </div>
        <?php endif; ?>

        <span class="offering-num"><?php echo esc_html($num); ?></span>
        <span class="offering-tag"><?php echo esc_html($o['offering_tag'] ?? ''); ?></span>
        <h3 class="offering-title"><?php echo esc_html($o['offering_title'] ?? ''); ?></h3>
        <p  class="offering-desc"><?php echo esc_html($o['offering_desc']  ?? ''); ?></p>

        <?php if (!empty($o['offering_price'])) : ?>
          <span class="offering-price"><?php echo esc_html($o['offering_price']); ?></span>
        <?php endif; ?>

        <a class="offering-link" href="<?php echo esc_url(home_url('/#contact')); ?>">
          <?php esc_html_e('Enquire','sacred-kompass'); ?>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="offerings-cta reveal">
      <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-primary">
        <?php esc_html_e('Book a Free Discovery Call','sacred-kompass'); ?>
      </a>
    </div>

  </div>
</section>
