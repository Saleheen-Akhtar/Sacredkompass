<?php
/* CTA / Contact Section — split layout with Forminator form */

$email         = sk_option('footer_email', 'collective@sacredkompass.org');
$phone         = sk_option('footer_phone', '+65 84343915');
$phone_clean   = preg_replace('/[^+0-9]/', '', $phone);
$whatsapp      = sk_option('social_whatsapp', '');
$forminator_id = sk_option('forminator_form_id', ''); // set in ACF Site Settings

/* CTA text — ACF editable */
$cta_eyebrow = sk_option('cta_eyebrow', __('Begin Your Journey','sacred-kompass'));
$cta_heading = sk_option('cta_heading', ''); // fallback rendered inline
$cta_sub     = sk_option('cta_sub',     __('A unique fusion of sacred traditions and practical application. Not temporary fixes, but in-depth transformation that helps you thrive from the inside out.','sacred-kompass'));
?>
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
  <div class="wrap">
    <div class="cta-layout">

      <!-- Left: CTA copy ──────────────────────── -->
      <div class="cta-text-col reveal">
        <div class="eyebrow">
          <?php echo esc_html($cta_eyebrow); ?>
        </div>

        <h2 class="cta-h2" id="cta-heading">
          <?php if ($cta_heading) : ?>
            <?php echo wp_kses_post($cta_heading); ?>
          <?php else : ?>
            <?php esc_html_e('Ready to Reconnect With','sacred-kompass'); ?><br>
            <?php esc_html_e('Your','sacred-kompass'); ?> <em><?php esc_html_e('Inner Compass?','sacred-kompass'); ?></em>
          <?php endif; ?>
        </h2>

        <p class="cta-sub">
          <?php echo esc_html($cta_sub); ?>
        </p>

        <!-- Contact info rows -->
        <div class="cta-contact-info">

          <div class="cta-contact-row">
            <span class="cta-contact-dot"></span>
            <a href="mailto:<?php echo esc_attr($email); ?>">
              <?php echo esc_html($email); ?>
            </a>
          </div>

          <div class="cta-contact-row">
            <span class="cta-contact-dot"></span>
            <a href="tel:<?php echo esc_attr($phone_clean); ?>">
              <?php echo esc_html($phone); ?>
            </a>
          </div>

          <?php if ($whatsapp) : ?>
          <div class="cta-contact-row">
            <span class="cta-contact-dot"></span>
            <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">
              <?php esc_html_e('WhatsApp Us','sacred-kompass'); ?>
            </a>
          </div>
          <?php endif; ?>

          <div class="cta-contact-row">
            <span class="cta-contact-dot"></span>
            <?php esc_html_e('Bedok North, Singapore &middot; Online Worldwide','sacred-kompass'); ?>
          </div>

        </div>
      </div>

      <!-- Right: Forminator form ──────────────── -->
      <div class="cta-form-col reveal d2">

        <?php if ($forminator_id && function_exists('forminator_addon_load')) :
          // Render Forminator shortcode
          echo do_shortcode('[forminator_form id="' . absint($forminator_id) . '"]');

        elseif (shortcode_exists('forminator_form') && $forminator_id) :
          echo do_shortcode('[forminator_form id="' . absint($forminator_id) . '"]');

        else : ?>
          <!--
            Forminator form placeholder.
            1. Install & activate the Forminator plugin.
            2. Create a form with fields: Name, Email, Message (add phone if desired).
            3. In WP Admin → Site Settings → Forminator Form ID, enter the form's ID.
            The form will auto-render here once the ID is saved.
          -->
          <div class="sk-contact-fallback-form">
            <p style="font-family:var(--font-ui);font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:2rem;">
              <?php esc_html_e('Get in Touch','sacred-kompass'); ?>
            </p>
            <div class="sk-form-row">
              <label for="sk-name"><?php esc_html_e('Your Name','sacred-kompass'); ?></label>
              <input type="text" id="sk-name" name="name" placeholder="<?php esc_attr_e('Full name','sacred-kompass'); ?>"/>
            </div>
            <div class="sk-form-row">
              <label for="sk-email"><?php esc_html_e('Email Address','sacred-kompass'); ?></label>
              <input type="email" id="sk-email" name="email" placeholder="<?php esc_attr_e('your@email.com','sacred-kompass'); ?>"/>
            </div>
            <div class="sk-form-row">
              <label for="sk-message"><?php esc_html_e('Message','sacred-kompass'); ?></label>
              <textarea id="sk-message" name="message" placeholder="<?php esc_attr_e('How can we support you on your journey?','sacred-kompass'); ?>"></textarea>
            </div>
            <p style="font-family:var(--font-display);font-size:0.92rem;color:rgba(255,255,255,0.28);font-style:italic;line-height:1.7;margin-top:1.5rem;padding:1rem;border:1px solid rgba(255,255,255,0.06);">
              <?php esc_html_e('To activate this form: Install Forminator → create a form → enter its ID under Site Settings → Forminator Form ID.','sacred-kompass'); ?>
            </p>
          </div>

        <?php endif; ?>

      </div>

    </div>
  </div>
</section>
