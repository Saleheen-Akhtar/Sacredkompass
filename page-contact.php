<?php
/*
 * Template Name: Contact Page
 */
get_header();
$email       = sk_option('footer_email', 'collective@sacredkompass.org');
$phone       = sk_option('footer_phone', '+65 84343915');
$phone_clean = preg_replace('/[^+0-9]/', '', $phone);
?>
<main id="main" style="padding-top:8rem;">
  <section style="padding:6rem 0 6rem;">
    <div class="wrap-narrow">
      <div class="eyebrow reveal"><?php esc_html_e('Get in Touch','sacred-kompass'); ?></div>
      <h1 class="display-h2 reveal d1" style="margin:1rem 0 1.5rem;">
        <?php esc_html_e('Begin Your','sacred-kompass'); ?> <em><?php esc_html_e('Journey','sacred-kompass'); ?></em>
      </h1>
      <p class="body-serif reveal d2" style="margin-bottom:3rem;">
        <?php esc_html_e('We offer a free 20-minute discovery call to understand where you are and what you are seeking. Reach out and we will lovingly guide you toward what feels most aligned.','sacred-kompass'); ?>
      </p>
      <div class="reveal d3" style="display:flex;gap:2.5rem;flex-wrap:wrap;margin-bottom:4rem;">
        <div>
          <p style="font-family:var(--font-ui);font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--terra);margin-bottom:0.4rem;"><?php esc_html_e('Email','sacred-kompass'); ?></p>
          <a href="mailto:<?php echo esc_attr($email); ?>" style="font-family:var(--font-display);font-size:1.1rem;color:var(--ink);"><?php echo esc_html($email); ?></a>
        </div>
        <div>
          <p style="font-family:var(--font-ui);font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--terra);margin-bottom:0.4rem;"><?php esc_html_e('Phone','sacred-kompass'); ?></p>
          <a href="tel:<?php echo esc_attr($phone_clean); ?>" style="font-family:var(--font-display);font-size:1.1rem;color:var(--ink);"><?php echo esc_html($phone); ?></a>
        </div>
        <div>
          <p style="font-family:var(--font-ui);font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--terra);margin-bottom:0.4rem;"><?php esc_html_e('Location','sacred-kompass'); ?></p>
          <span style="font-family:var(--font-display);font-size:1.1rem;color:var(--ink);">Bedok North, Singapore</span>
        </div>
      </div>
      <div class="reveal d4">
        <?php if (function_exists('forminator_form')) { forminator_form(1); } else { echo '<p style="font-family:var(--font-display);font-size:1rem;color:var(--ink-muted);">' . esc_html__('Contact form will appear here once Forminator plugin is active.','sacred-kompass') . '</p>'; } ?>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
