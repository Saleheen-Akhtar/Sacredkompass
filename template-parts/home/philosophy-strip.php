<?php
$pillars = [
  ['num' => '01', 'title' => __('Ancient Wisdom',         'sacred-kompass'), 'desc' => __('Rooted in Vedic philosophy, Jyotish astrology, and centuries of sacred contemplative tradition.',                                'sacred-kompass')],
  ['num' => '02', 'title' => __('Compassionate Practice', 'sacred-kompass'), 'desc' => __('Nonviolent Communication and emotional resilience as tools for deeper human connection and understanding.',                       'sacred-kompass')],
  ['num' => '03', 'title' => __('Inner Stillness',        'sacred-kompass'), 'desc' => __('Meditation, breathwork, and mindfulness practices that restore a deep, unshakeable sense of calm and clarity.', 'sacred-kompass')],
];
?>
<div class="strip" aria-label="<?php esc_attr_e('Core Pillars','sacred-kompass'); ?>">
  <div class="wrap">
    <div class="strip-inner">
      <?php foreach ($pillars as $i => $p) : ?>
      <div class="strip-pillar reveal<?php echo $i ? " d{$i}" : ''; ?>">
        <span class="strip-num"><?php echo esc_html($p['num']); ?></span>
        <h4><?php echo esc_html($p['title']); ?></h4>
        <p><?php echo esc_html($p['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
