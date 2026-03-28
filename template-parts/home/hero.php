<?php
/* Hero — Editorial split: narrative left, image right with parallax */

/* ACF hero fields (from Options page) */
$stage1  = sk_option('hero_stage1',  __('The world pulls at you from every direction.', 'sacred-kompass'));
$stage2a = sk_option('hero_stage2a', __('Something inside you', 'sacred-kompass'));
$stage2b = sk_option('hero_stage2b', __('is calling for stillness.', 'sacred-kompass'));
$stage3a = sk_option('hero_stage3a', __('We walk you', 'sacred-kompass'));
$stage3b = sk_option('hero_stage3b', __('back to yourself.', 'sacred-kompass'));
$sub     = sk_option('hero_sub',     __('Sacred Kompass is a transformative wellness consultancy weaving Vedic philosophy, Jyotish astrology, and compassionate practice into in-depth, inside-out transformation.', 'sacred-kompass'));
$cta1_t  = sk_option('hero_cta1_text', __('Book a Free Discovery Call', 'sacred-kompass'));
$cta1_u  = sk_option('hero_cta1_url',  home_url('/#contact'));
$cta2_t  = sk_option('hero_cta2_text', __('Explore Offerings', 'sacred-kompass'));
$cta2_u  = sk_option('hero_cta2_url',  '#offerings');

/* Hero image — ACF or founder image fallback */
$hero_img = [];
if ( function_exists('get_field') ) {
  $hero_img = get_field('hero_image', 'option') ?: [];
}
?>

<section class="hero" aria-label="<?php esc_attr_e('Welcome to Sacred Kompass','sacred-kompass'); ?>">

  <!-- Floating celestial orbs -->
  <div class="orb hero-orb-1" aria-hidden="true"></div>
  <div class="orb hero-orb-2" aria-hidden="true"></div>

  <!-- Left: Journey narrative ────────────────── -->
  <div class="hero-left">
    <div class="hero-rule" aria-hidden="true"></div>

    <div class="hero-journey">

      <!-- Stage 1: Chaos -->
      <p class="stage-chaos journey-stage">
        <?php echo esc_html($stage1); ?>
      </p>

      <!-- Stage 2: Turning point -->
      <p class="stage-turning journey-stage">
        <?php echo esc_html($stage2a); ?><br>
        <?php echo esc_html($stage2b); ?>
      </p>

      <!-- Stage 3: Calm — the promise -->
      <p class="stage-calm journey-stage">
        <?php echo esc_html($stage3a); ?><br>
        <em><?php echo esc_html($stage3b); ?></em>
      </p>

    </div>

    <p class="hero-sub">
      <?php echo esc_html($sub); ?>
    </p>

    <div class="hero-actions">
      <a href="<?php echo esc_url($cta1_u); ?>" class="btn btn-primary">
        <?php echo esc_html($cta1_t); ?>
      </a>
      <a href="<?php echo esc_url($cta2_u); ?>" class="btn btn-outline">
        <?php echo esc_html($cta2_t); ?>
      </a>
    </div>

    <p class="hero-location">
      <?php esc_html_e('Bedok North, Singapore', 'sacred-kompass'); ?>
      <span>&middot;</span>
      <?php esc_html_e('Online Worldwide', 'sacred-kompass'); ?>
    </p>
  </div>

  <!-- Right: Editorial image with parallax ───── -->
  <div class="hero-right" role="presentation">

    <!-- Parallax wrapper — JS drives translateY -->
    <div class="hero-image-parallax" id="sk-hero-parallax">
      <div class="hero-image-frame">

        <?php if (!empty($hero_img['url'])) : ?>
          <img
            src="<?php echo esc_url($hero_img['url']); ?>"
            alt="<?php echo esc_attr($hero_img['alt'] ?? __('Sacred Kompass — inner journey','sacred-kompass')); ?>"
            loading="eager"
          />
        <?php else : ?>
          <!-- Placeholder: celestial halo art until image is added via ACF -->
          <div class="hero-image-placeholder" aria-hidden="true">
            <div class="hero-image-placeholder-circle">
              <span class="hero-placeholder-symbol">&#9788;</span>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- Ghost ambient words -->
    <div class="hero-ambient" aria-hidden="true">
      <span class="hero-ambient-word">Stillness</span>
      <span class="hero-ambient-word">Clarity</span>
      <span class="hero-ambient-word">Peace</span>
    </div>

  </div>

</section>
