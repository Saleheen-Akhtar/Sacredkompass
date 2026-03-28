<?php
$founders = [
  [
    'key'      => 'kalai',
    'name'     => 'Kalai',
    'surname'  => 'Somoo',
    'origin'   => 'Singapore',
    'role'     => 'Founder and Lead Guide',
    'bio'      => 'Kalai founded Sacred Kompass with a vision to reconnect people to their inner wisdom. With deep roots in Vedic philosophy, sacred feminine practices, Jyotish astrology, and women\'s empowerment, she guides individuals and organisations through transformative, inside-out growth.',
    'tags'     => ["Women's Wellness", "Vedic Philosophy", "Jyotish Astrology", "Sacred Feminine", "Coaching"],
    'initials' => 'K',
    'acf_key'  => 'founder_image_kalai',
  ],
  [
    'key'      => 'christophe',
    'name'     => 'Christophe',
    'surname'  => 'Grigri',
    'origin'   => 'France',
    'role'     => 'International Coordination and Communication',
    'bio'      => 'Christophe brings decades of international experience bridging cultures through compassionate dialogue and conscious leadership. Trained in Gandhian non-violence and NVC, he coordinates Sacred Kompass\'s global outreach and shapes the communicative heart of the collective.',
    'tags'     => ['NVC', 'Gandhian Non-Violence', 'International Coordination', 'Conscious Leadership'],
    'initials' => 'C',
    'acf_key'  => 'founder_image_christophe',
  ],
];
?>
<section class="founders-section" id="founders" aria-labelledby="founders-heading">
  <div class="wrap">

    <!-- Header: two-column editorial -->
    <div class="founders-header">
      <div class="founders-header-left">
        <div class="eyebrow reveal"><?php esc_html_e('The Founders','sacred-kompass'); ?></div>
        <h2 class="display-h2 reveal d1" id="founders-heading">
          <?php esc_html_e('The Guides Behind','sacred-kompass'); ?><br>
          <em><?php esc_html_e('Sacred Kompass','sacred-kompass'); ?></em>
        </h2>
      </div>
      <p class="founders-header-right reveal d2">
        <?php esc_html_e('Two souls, one vision. Uniting Eastern wisdom and Western heart in service of conscious living.','sacred-kompass'); ?>
      </p>
    </div>

    <!-- Founder portraits -->
    <div class="founders-duo">
      <?php foreach ($founders as $i => $f) :
        $img = [];
        if (function_exists('get_field')) {
          $img = get_field($f['acf_key']) ?: get_field($f['acf_key'], 'option');
        }
      ?>
      <div class="founder-unit reveal<?php echo $i ? ' d2' : ''; ?>">

        <div class="founder-portrait">
          <?php if (!empty($img['url'])) : ?>
            <img src="<?php echo esc_url($img['url']); ?>"
                 alt="<?php echo esc_attr($f['name'] . ' ' . $f['surname']); ?>"
                 loading="lazy"/>
          <?php else : ?>
            <div class="founder-portrait-art" aria-hidden="true">
              <span class="founder-initials-large"><?php echo esc_html($f['initials']); ?></span>
            </div>
          <?php endif; ?>
          <span class="founder-origin-badge"><?php echo esc_html($f['origin']); ?></span>
        </div>

        <div class="founder-meta">
          <h3 class="founder-name">
            <?php echo esc_html($f['name']); ?> <em><?php echo esc_html($f['surname']); ?></em>
          </h3>
          <span class="founder-role-label"><?php echo esc_html($f['role']); ?></span>
        </div>

        <p class="founder-bio"><?php echo esc_html($f['bio']); ?></p>

        <div class="founder-tags">
          <?php foreach ($f['tags'] as $tag) : ?>
            <span class="trad-tag"><?php echo esc_html($tag); ?></span>
          <?php endforeach; ?>
        </div>

      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
