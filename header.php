<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Mobile full-screen overlay -->
<div class="nav-mobile-overlay" id="sk-mobile-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Mobile navigation','sacred-kompass'); ?>">
  <ul>
    <li><a href="<?php echo esc_url(home_url('/#about'));     ?>"><?php esc_html_e('About',     'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#offerings')); ?>"><?php esc_html_e('Offerings', 'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#founders'));  ?>"><?php esc_html_e('Founders',  'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#faq'));       ?>"><?php esc_html_e('FAQ',        'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#contact'));   ?>"><?php esc_html_e('Contact',   'sacred-kompass'); ?></a></li>
  </ul>
  <div class="nav-mobile-divider"></div>
  <div class="nav-mobile-cta">
    <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-primary">
      <?php esc_html_e('Book a Free Discovery Call', 'sacred-kompass'); ?>
    </a>
  </div>
</div>

<nav class="nav" id="sk-nav" role="navigation" aria-label="<?php esc_attr_e('Main navigation','sacred-kompass'); ?>">
  <a class="nav-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Sacred Kompass home','sacred-kompass'); ?>">
    Sacred <em>Kompass</em>
  </a>

  <ul class="nav-links">
    <li><a href="<?php echo esc_url(home_url('/#about'));     ?>"><?php esc_html_e('About',    'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#offerings')); ?>"><?php esc_html_e('Offerings','sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#founders'));  ?>"><?php esc_html_e('Founders', 'sacred-kompass'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/#faq'));       ?>"><?php esc_html_e('FAQ',       'sacred-kompass'); ?></a></li>
  </ul>

  <div class="nav-cta">
    <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-primary">
      <?php esc_html_e('Book a Call', 'sacred-kompass'); ?>
    </a>
  </div>

  <!-- Hamburger -->
  <button class="nav-hamburger" id="sk-hamburger"
          aria-label="<?php esc_attr_e('Toggle menu','sacred-kompass'); ?>"
          aria-expanded="false"
          aria-controls="sk-mobile-menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>
