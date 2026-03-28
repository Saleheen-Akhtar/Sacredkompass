<?php
/**
 * Sacred Kompass — functions.php v5.0.0
 * Fully ACF Flexible Content, GSAP Enqueue, and Forminator Rate Limiting.
 */

/* ── Enqueue ────────────────────────────────────────────── */
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'sacred-kompass-style',
    get_stylesheet_uri(),
    [],
    '5.0.0'
  );

  // Enqueue GSAP Core & ScrollTrigger
  wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], '3.12.2', true);
  wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', ['gsap-core'], '3.12.2', true);

  wp_enqueue_script(
    'sacred-kompass-main',
    get_template_directory_uri() . '/assets/js/main.js',
    ['gsap-core', 'gsap-scrolltrigger'],
    '5.0.0',
    true
  );
});

/* ── Theme support ──────────────────────────────────────── */
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption']);
  register_nav_menus([
    'primary' => __('Primary Navigation', 'sacred-kompass'),
    'footer'  => __('Footer Menu',        'sacred-kompass'),
  ]);
});

/* ── Helpers ────────────────────────────────────────────── */
function sk_field( $key, $post_id = false, $fallback = '' ) {
  if ( function_exists('get_field') ) {
    $v = $post_id ? get_field($key, $post_id) : get_field($key);
    if ( $v !== null && $v !== '' ) return $v;
  }
  return $fallback;
}
function sk_option( $key, $fallback = '' ) {
  if ( function_exists('get_field') ) {
    $v = get_field($key, 'option');
    if ( $v !== null && $v !== '' ) return $v;
  }
  return $fallback;
}

/* ════════════════════════════════════════════════════════════
   FORMINATOR RATE LIMITING & RETURNING VISITOR
   ════════════════════════════════════════════════════════════ */
define( 'SK_EMAIL_FIELD', 'email-1' );

add_filter( 'forminator_custom_form_submit_errors', 'sk_forminator_rate_limit', 10, 3 );
function sk_forminator_rate_limit( $submit_errors, $form_id, $field_data_array ) {
    global $wpdb;

    $email = '';
    if ( is_array( $field_data_array ) ) {
      foreach ( $field_data_array as $field ) {
        $name = $field['name'] ?? '';
        if ( $name === SK_EMAIL_FIELD || stripos( $name, 'email' ) !== false ) {
          $email = sanitize_email( $field['value'] ?? '' );
          if ( $email ) break;
        }
      }
    }

    if ( empty( $email ) ) return $submit_errors;

    $time_limit = date('Y-m-d H:i:s', strtotime('-24 hours'));
    $query = $wpdb->prepare(
        "SELECT COUNT(*)
         FROM {$wpdb->prefix}frmt_form_entry e
         JOIN {$wpdb->prefix}frmt_form_entry_meta m ON e.entry_id = m.entry_id
         WHERE m.meta_key = %s
         AND m.meta_value = %s
         AND e.date_created >= %s",
        SK_EMAIL_FIELD,
        $email,
        $time_limit
    );

    $recent_submissions = (int) $wpdb->get_var( $query );

    if ( $recent_submissions >= 3 ) {
        $submit_errors[][ SK_EMAIL_FIELD ] = esc_html__( "You've reached out a few times recently! Please wait a moment before sending another message, or email us directly.", 'sacred-kompass' );
    }

    return $submit_errors;
}

add_filter( 'forminator_custom_form_success_message', 'sk_returning_visitor_message', 10, 4 );
function sk_returning_visitor_message( $message, $custom_form, $form_id, $field_data_array ) {
  global $wpdb;

  $email = '';
  if ( is_array( $field_data_array ) ) {
    foreach ( $field_data_array as $field ) {
      $name = $field['name'] ?? '';
      if ( $name === SK_EMAIL_FIELD || stripos( $name, 'email' ) !== false ) {
        $email = sanitize_email( $field['value'] ?? '' );
        if ( $email ) break;
      }
    }
  }

  if ( empty( $email ) ) {
    return esc_html__( 'Your message has been received. We will connect with you soon.', 'sacred-kompass' );
  }

  $count = (int) $wpdb->get_var(
    $wpdb->prepare(
      "SELECT COUNT(DISTINCT entry_id)
       FROM   {$wpdb->prefix}frmt_form_entry_meta
       WHERE  meta_key   = %s
       AND    meta_value = %s",
      SK_EMAIL_FIELD,
      $email
    )
  );

  if ( $count > 1 ) {
    return esc_html__( "Welcome back \xe2\x80\x94 it\xe2\x80\x99s good to hear from you again. We\xe2\x80\x99ll reconnect with you shortly.", 'sacred-kompass' );
  }

  return esc_html__( 'Your message has been received. We will connect with you soon.', 'sacred-kompass' );
}

/* ═══════════════════════════════════════════════════════════
   ACF FLEXIBLE CONTENT REGISTRATION (All Pages)
   ═══════════════════════════════════════════════════════════ */
add_action('acf/init', 'sk_register_acf_fields');
function sk_register_acf_fields() {
  if ( ! function_exists('acf_add_local_field_group') ) return;

  if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page([
      'page_title' => 'Global Settings',
      'menu_slug'  => 'sk-site-settings',
    ]);
  }

  acf_add_local_field_group([
    'key'      => 'group_sk_global',
    'title'    => 'Global Footer Settings',
    'location' => [[['param'=>'options_page','operator'=>'==','value'=>'sk-site-settings']]],
    'fields'   => [
      ['key'=>'field_g_footer_tagline','label'=>'Footer Tagline','name'=>'footer_tagline','type'=>'textarea', 'default_value'=>'Ancient wisdom for the modern soul. Transformative guidance for individuals, leaders, and organisations.'],
      ['key'=>'field_g_footer_copy','label'=>'Copyright Text','name'=>'footer_copyright','type'=>'text', 'default_value'=>'Sacred Kompass Collective · Singapore'],
      ['key'=>'field_g_footer_email','label'=>'Contact Email','name'=>'footer_email','type'=>'email', 'default_value'=>'collective@sacredkompass.org'],
      ['key'=>'field_g_footer_phone','label'=>'Contact Phone','name'=>'footer_phone','type'=>'text', 'default_value'=>'+65 84343915'],
    ],
  ]);

  /* The Universal Page Builder (Flexible Content) */
  acf_add_local_field_group([
    'key'      => 'group_sk_page_builder',
    'title'    => 'Page Builder',
    'location' => [[['param'=>'post_type','operator'=>'==','value'=>'page']]],
    'fields'   => [
      [
        'key' => 'field_sk_builder',
        'label' => 'Page Sections',
        'name' => 'page_sections',
        'type' => 'flexible_content',
        'button_label' => 'Add Section',
        'layouts' => [

          /* Hero Section */
          'layout_hero' => [
            'key' => 'layout_hero', 'name' => 'hero', 'label' => 'Hero (Centered)', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'hero_bg', 'label'=>'Background Image', 'name'=>'bg_image', 'type'=>'image', 'return_format'=>'url'],
              ['key'=>'hero_h1', 'label'=>'Main Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'The world pulls at you. Something inside you is calling for stillness. We walk you back to yourself.'],
              ['key'=>'hero_sub', 'label'=>'Sub Heading', 'name'=>'subheading', 'type'=>'textarea', 'default_value'=>'Vedic philosophy, Jyotish astrology, and compassionate practice.'],
            ]
          ],

          /* About Section */
          'layout_about' => [
            'key' => 'layout_about', 'name' => 'about', 'label' => 'About', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'about_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'A sanctuary for the modern soul.'],
              ['key'=>'about_body', 'label'=>'Body Text', 'name'=>'body', 'type'=>'wysiwyg', 'default_value'=>'<p>Sacred Kompass is a spiritual wellness collective dedicated to bridging ancient Vedic wisdom with modern life.</p><p>Through meditation, communication, Jyotish astrology, and conscious leadership, we offer transformative guidance for individuals, leaders, and organisations seeking profound alignment.</p>'],
              ['key'=>'about_quote', 'label'=>'Pull Quote', 'name'=>'quote', 'type'=>'textarea', 'default_value'=>'Stillness is not the absence of movement, but the deep presence of self.'],
              ['key'=>'about_tags', 'label'=>'Tradition Tags (Comma separated)', 'name'=>'tags', 'type'=>'text', 'default_value'=>'Vedic Philosophy, Jyotish Astrology, Compassionate Practice'],
            ]
          ],

          /* Philosophy Strip */
          'layout_philosophy' => [
            'key' => 'layout_philosophy', 'name' => 'philosophy', 'label' => 'Philosophy Strip', 'display' => 'block',
            'sub_fields' => [
              [
                'key'=>'phil_rep', 'label'=>'Pillars', 'name'=>'pillars', 'type'=>'repeater', 'max'=>3,
                'sub_fields' => [
                  ['key'=>'phil_num', 'label'=>'Number', 'name'=>'number', 'type'=>'text'],
                  ['key'=>'phil_title', 'label'=>'Title', 'name'=>'title', 'type'=>'text'],
                  ['key'=>'phil_desc', 'label'=>'Description', 'name'=>'desc', 'type'=>'textarea'],
                ]
              ]
            ]
          ],

          /* Offerings */
          'layout_offerings' => [
            'key' => 'layout_offerings', 'name' => 'offerings', 'label' => 'Offerings', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'off_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'Our Offerings'],
              ['key'=>'off_sub', 'label'=>'Subheading', 'name'=>'subheading', 'type'=>'textarea', 'default_value'=>'Paths to deeper alignment.'],
              [
                'key'=>'off_rep', 'label'=>'Offerings List', 'name'=>'offerings_list', 'type'=>'repeater',
                'sub_fields' => [
                  ['key'=>'off_r_img', 'label'=>'Image', 'name'=>'image', 'type'=>'image', 'return_format'=>'array'],
                  ['key'=>'off_r_tag', 'label'=>'Tag', 'name'=>'tag', 'type'=>'text'],
                  ['key'=>'off_r_tit', 'label'=>'Title', 'name'=>'title', 'type'=>'text'],
                  ['key'=>'off_r_dsc', 'label'=>'Description', 'name'=>'desc', 'type'=>'textarea'],
                  ['key'=>'off_r_prc', 'label'=>'Price', 'name'=>'price', 'type'=>'text'],
                ]
              ]
            ]
          ],

          /* Quote Band */
          'layout_quote_band' => [
            'key' => 'layout_quote_band', 'name' => 'quote_band', 'label' => 'Quote Band', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'qb_bg_txt', 'label'=>'Large Background Text', 'name'=>'large_bg_text', 'type'=>'text', 'default_value'=>'AWAKEN'],
              ['key'=>'qb_eye', 'label'=>'Eyebrow', 'name'=>'eyebrow', 'type'=>'text', 'default_value'=>'The Vision'],
              ['key'=>'qb_qt', 'label'=>'Quote', 'name'=>'quote', 'type'=>'textarea', 'default_value'=>'The quieter you become, the more you can hear.'],
              ['key'=>'qb_auth', 'label'=>'Author', 'name'=>'author', 'type'=>'text', 'default_value'=>'— Ram Dass'],
            ]
          ],

          /* Founders */
          'layout_founders' => [
            'key' => 'layout_founders', 'name' => 'founders', 'label' => 'Founders', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'fnd_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'The Collective'],
              ['key'=>'fnd_sub', 'label'=>'Subheading', 'name'=>'subheading', 'type'=>'textarea', 'default_value'=>'Guided by deep lineage and lived experience.'],
              [
                'key'=>'fnd_rep', 'label'=>'Founders List', 'name'=>'founders_list', 'type'=>'repeater',
                'sub_fields' => [
                  ['key'=>'fnd_r_img', 'label'=>'Portrait Image', 'name'=>'image', 'type'=>'image', 'return_format'=>'array'],
                  ['key'=>'fnd_r_nm', 'label'=>'Name', 'name'=>'name', 'type'=>'text'],
                  ['key'=>'fnd_r_rl', 'label'=>'Role', 'name'=>'role', 'type'=>'text'],
                  ['key'=>'fnd_r_bio', 'label'=>'Bio', 'name'=>'bio', 'type'=>'textarea'],
                ]
              ]
            ]
          ],

          /* Values */
          'layout_values' => [
            'key' => 'layout_values', 'name' => 'values', 'label' => 'Values', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'val_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'Core Values'],
              [
                'key'=>'val_rep', 'label'=>'Values List', 'name'=>'values_list', 'type'=>'repeater',
                'sub_fields' => [
                  ['key'=>'val_r_num', 'label'=>'Number', 'name'=>'number', 'type'=>'text'],
                  ['key'=>'val_r_tit', 'label'=>'Title', 'name'=>'title', 'type'=>'text'],
                  ['key'=>'val_r_dsc', 'label'=>'Description', 'name'=>'desc', 'type'=>'textarea'],
                ]
              ]
            ]
          ],

          /* FAQ */
          'layout_faq' => [
            'key' => 'layout_faq', 'name' => 'faq', 'label' => 'FAQ', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'faq_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'Frequently Asked Questions'],
              ['key'=>'faq_sub', 'label'=>'Subheading', 'name'=>'subheading', 'type'=>'textarea', 'default_value'=>'Clarity on the journey.'],
              [
                'key'=>'faq_rep', 'label'=>'FAQs List', 'name'=>'faqs_list', 'type'=>'repeater',
                'sub_fields' => [
                  ['key'=>'faq_r_q', 'label'=>'Question', 'name'=>'question', 'type'=>'text'],
                  ['key'=>'faq_r_a', 'label'=>'Answer', 'name'=>'answer', 'type'=>'textarea'],
                ]
              ]
            ]
          ],

          /* Contact Forminator */
          'layout_contact' => [
            'key' => 'layout_contact', 'name' => 'contact', 'label' => 'Contact Form', 'display' => 'block',
            'sub_fields' => [
              ['key'=>'contact_h2', 'label'=>'Heading', 'name'=>'heading', 'type'=>'text', 'default_value'=>'Begin Your Journey'],
              ['key'=>'contact_sub', 'label'=>'Subtext', 'name'=>'subtext', 'type'=>'textarea', 'default_value'=>'Connect with us to explore how we can support your path.'],
              ['key'=>'contact_form_id', 'label'=>'Forminator Form ID', 'name'=>'form_id', 'type'=>'number'],
            ]
          ],

        ],
      ],
    ],
  ]);
}
