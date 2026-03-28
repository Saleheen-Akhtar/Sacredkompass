<?php
$acf_values = function_exists('get_field') ? get_field('values') : [];
$fallback = [
  ['value_title' => 'Sacred Presence',    'value_desc' => 'We believe transformation begins with stillness. Every session, every conversation, every offering is held in a space of deep, unhurried presence.'],
  ['value_title' => 'Compassionate Truth','value_desc' => 'We speak from the heart and listen with the same depth. Nonviolent Communication is not just a tool. It is a way of being that runs through everything we do.'],
  ['value_title' => 'Ancient Wisdom',     'value_desc' => 'We honour the timeless traditions that have guided human flourishing for millennia, as living, breathing guides.'],
  ['value_title' => 'Conscious Growth',   'value_desc' => 'We believe sustainable change comes from within. Our work is about remembering what was always whole, and living outward from that place.'],
];
$values = $acf_values ?: $fallback;
?>
<section class="values-section" id="values" aria-labelledby="values-heading">
  <div class="wrap">

    <div class="values-header">
      <div class="eyebrow eyebrow-c reveal"><?php esc_html_e('What We Stand For','sacred-kompass'); ?></div>
      <h2 class="display-h2 reveal d1" id="values-heading">
        <?php esc_html_e('Our Core','sacred-kompass'); ?> <em><?php esc_html_e('Values','sacred-kompass'); ?></em>
      </h2>
    </div>

    <div class="values-grid">
      <?php foreach ($values as $idx => $v) :
        $delay = 'd' . min($idx + 1, 5);
      ?>
      <div class="value-card reveal <?php echo $delay; ?>">
        <span class="value-num" aria-hidden="true">0<?php echo $idx + 1; ?></span>
        <h3><?php echo esc_html($v['value_title']); ?></h3>
        <p><?php echo esc_html($v['value_desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
