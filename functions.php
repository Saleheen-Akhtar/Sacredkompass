<?php
/**
 * Sacred Kompass — functions.php v4.0.0
 * ACF field groups registered in PHP (portable, no DB dependency).
 * v4 additions:
 *   - Phase 2: Returning visitor detection via Forminator hook
 *   - Success message filter (new user vs returning visitor)
 */
defined('ABSPATH') || exit;

/* ── ACF Options page ──────────────────────────────────── */
if ( function_exists('acf_add_options_page') ) {
  acf_add_options_page([
    'page_title' => 'Site Settings',
    'menu_title' => 'Site Settings',
    'menu_slug'  => 'sk-site-settings',
    'capability' => 'manage_options',
    'icon_url'   => 'dashicons-star-filled',
    'position'   => 30,
  ]);
}

/* ── Enqueue ────────────────────────────────────────────── */
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'sacred-kompass-style',
    get_stylesheet_uri(),
    [],
    '4.0.0'
  );
  wp_enqueue_script(
    'sacred-kompass-main',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    '4.0.0',
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
   PHASE 2 — RETURNING VISITOR DETECTION (Forminator)
   ════════════════════════════════════════════════════════════

   HOW IT WORKS:
   ─────────────
   1. User submits Forminator form.
   2. Forminator saves entry to {prefix}_frmt_form_entry_meta.
   3. This filter fires AFTER the entry is saved.
   4. We query how many DISTINCT entries share this email in DB.
        count = 1  →  brand new lead
        count > 1  →  returning visitor
   5. Forminator returns the filtered message in its JSON response.
      No page reload. Inline, seamless.

   FIELD NAME NOTE:
   ─────────────────
   Forminator names fields by type + sequence: email-1, email-2 etc.
   Check your form's field names in Forminator → Edit Form → field settings.
   Update SK_EMAIL_FIELD below if yours is different.

   SUCCESS MESSAGES:
   ──────────────────
   New user:      "Your message has been received. We will connect with you soon."
   Returning:     "Welcome back — it's good to hear from you again.
                   We'll reconnect with you shortly."
   ════════════════════════════════════════════════════════════ */

/** Email field name as configured in Forminator. Update if renamed. */
define( 'SK_EMAIL_FIELD', 'email-1' );

/**
 * Filter Forminator's success message based on whether the
 * email has been seen before (returning) or is new.
 */
add_filter( 'forminator_custom_form_success_message', 'sk_returning_visitor_message', 10, 4 );

function sk_returning_visitor_message( $message, $custom_form, $form_id, $field_data_array ) {

  global $wpdb;

  /* 1. Pull email out of submitted field data */
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

  /* 2. No email found — fallback to new-user message */
  if ( empty( $email ) ) {
    return esc_html__( 'Your message has been received. We will connect with you soon.', 'sacred-kompass' );
  }

  /* 3. Count distinct entries with this email in Forminator meta table.
        The CURRENT submission is already written when this filter fires,
        so count > 1 means they have submitted previously. */
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

  /* 4. Return message */
  if ( $count > 1 ) {
    /* Returning visitor — warm, understated */
    return esc_html__( "Welcome back \xe2\x80\x94 it\xe2\x80\x99s good to hear from you again. We\xe2\x80\x99ll reconnect with you shortly.", 'sacred-kompass' );
  }

  /* New lead */
  return esc_html__( 'Your message has been received. We will connect with you soon.', 'sacred-kompass' );
}

/* ═══════════════════════════════════════════════════════════
   ACF FIELD GROUPS — registered via PHP for portability
   ═══════════════════════════════════════════════════════════ */
add_action('acf/init', 'sk_register_acf_fields');
function sk_register_acf_fields() {
  if ( ! function_exists('acf_add_local_field_group') ) return;

  /* ── GROUP 1: Site Settings (Options page) ─── */
  acf_add_local_field_group([
    'key'      => 'group_sk_site_settings',
    'title'    => 'Site Settings',
    'location' => [[['param'=>'options_page','operator'=>'==','value'=>'sk-site-settings']]],
    'fields'   => [

      ['key'=>'field_sk_hero_tab','label'=>'Hero','name'=>'','type'=>'tab'],
      ['key'=>'field_sk_hero_image',   'label'=>'Hero Image (right panel)',
       'name'=>'hero_image','type'=>'image','return_format'=>'array','preview_size'=>'medium'],
      ['key'=>'field_sk_hero_stage1',  'label'=>'Stage 1 — Chaos text',
       'name'=>'hero_stage1','type'=>'text','placeholder'=>'The world pulls at you…'],
      ['key'=>'field_sk_hero_stage2a', 'label'=>'Stage 2 Line 1',
       'name'=>'hero_stage2a','type'=>'text','placeholder'=>'Something inside you'],
      ['key'=>'field_sk_hero_stage2b', 'label'=>'Stage 2 Line 2',
       'name'=>'hero_stage2b','type'=>'text','placeholder'=>'is calling for stillness.'],
      ['key'=>'field_sk_hero_stage3a', 'label'=>'Stage 3 Line 1',
       'name'=>'hero_stage3a','type'=>'text','placeholder'=>'We walk you'],
      ['key'=>'field_sk_hero_stage3b', 'label'=>'Stage 3 Line 2 (italic terra accent)',
       'name'=>'hero_stage3b','type'=>'text','placeholder'=>'back to yourself.'],
      ['key'=>'field_sk_hero_sub',     'label'=>'Hero Sub-text',
       'name'=>'hero_sub','type'=>'textarea','rows'=>3],
      ['key'=>'field_sk_hero_cta1_text','label'=>'CTA 1 Button Text',
       'name'=>'hero_cta1_text','type'=>'text','default_value'=>'Book a Free Discovery Call'],
      ['key'=>'field_sk_hero_cta1_url', 'label'=>'CTA 1 Button URL',
       'name'=>'hero_cta1_url','type'=>'url'],
      ['key'=>'field_sk_hero_cta2_text','label'=>'CTA 2 Button Text',
       'name'=>'hero_cta2_text','type'=>'text','default_value'=>'Explore Offerings'],
      ['key'=>'field_sk_hero_cta2_url', 'label'=>'CTA 2 Button URL',
       'name'=>'hero_cta2_url','type'=>'url'],

      ['key'=>'field_sk_cta_tab','label'=>'Contact Section','name'=>'','type'=>'tab'],
      ['key'=>'field_sk_cta_eyebrow','label'=>'Contact Eyebrow',
       'name'=>'cta_eyebrow','type'=>'text','default_value'=>'Begin Your Journey'],
      ['key'=>'field_sk_cta_heading','label'=>'Contact Heading (HTML allowed)',
       'name'=>'cta_heading','type'=>'wysiwyg','toolbar'=>'basic','media_upload'=>0],
      ['key'=>'field_sk_cta_sub',    'label'=>'Contact Sub-text',
       'name'=>'cta_sub','type'=>'textarea','rows'=>3],
      ['key'=>'field_sk_form_id','label'=>'Forminator Form ID',
       'name'=>'forminator_form_id','type'=>'number',
       'instructions'=>'Create a Forminator form with fields: First Name, Last Name, Email (field name must be email-1), Phone (optional), Inquiry Type (select), Message. Enter the form ID here.'],

      ['key'=>'field_sk_footer_tab','label'=>'Footer & Social','name'=>'','type'=>'tab'],
      ['key'=>'field_sk_footer_email',  'label'=>'Contact Email',     'name'=>'footer_email',     'type'=>'email'],
      ['key'=>'field_sk_footer_phone',  'label'=>'Contact Phone',     'name'=>'footer_phone',     'type'=>'text'],
      ['key'=>'field_sk_social_ig',     'label'=>'Instagram URL',     'name'=>'social_instagram', 'type'=>'url'],
      ['key'=>'field_sk_social_fb',     'label'=>'Facebook URL',      'name'=>'social_facebook',  'type'=>'url'],
      ['key'=>'field_sk_social_wa',     'label'=>'WhatsApp Link',     'name'=>'social_whatsapp',  'type'=>'url',
       'instructions'=>'Format: https://wa.me/6512345678'],
    ],
  ]);

  /* ── GROUP 2: Offerings repeater ─── */
  acf_add_local_field_group([
    'key'      => 'group_sk_offerings',
    'title'    => 'Offerings',
    'location' => [[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
    'fields'   => [
      [
        'key'   => 'field_sk_offerings_repeater',
        'label' => 'Offerings',
        'name'  => 'offerings',
        'type'  => 'repeater',
        'layout'     => 'block',
        'min'        => 0,
        'max'        => 8,
        'button_label' => 'Add Offering',
        'sub_fields' => [
          ['key'=>'field_sk_off_image','label'=>'Image (optional)','name'=>'offering_image','type'=>'image','return_format'=>'array','preview_size'=>'medium'],
          ['key'=>'field_sk_off_tag',  'label'=>'Tag / Category',  'name'=>'offering_tag',  'type'=>'text'],
          ['key'=>'field_sk_off_title','label'=>'Title',           'name'=>'offering_title','type'=>'text'],
          ['key'=>'field_sk_off_desc', 'label'=>'Description',     'name'=>'offering_desc', 'type'=>'textarea','rows'=>3],
          ['key'=>'field_sk_off_price','label'=>'Price (optional)','name'=>'offering_price','type'=>'text',
           'instructions'=>'e.g. "From SGD 120" or leave blank'],
        ],
      ],
    ],
  ]);

  /* ── GROUP 3: FAQ repeater ─── */
  acf_add_local_field_group([
    'key'      => 'group_sk_faqs',
    'title'    => 'FAQs',
    'location' => [[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
    'fields'   => [
      [
        'key'   => 'field_sk_faqs_repeater',
        'label' => 'FAQ Items',
        'name'  => 'faqs',
        'type'  => 'repeater',
        'layout'       => 'block',
        'button_label' => 'Add FAQ',
        'sub_fields'   => [
          ['key'=>'field_sk_faq_q','label'=>'Question','name'=>'faq_question','type'=>'text'],
          ['key'=>'field_sk_faq_a','label'=>'Answer',  'name'=>'faq_answer',  'type'=>'textarea','rows'=>4],
        ],
      ],
    ],
  ]);

  /* ── GROUP 4: Founder photos ─── */
  acf_add_local_field_group([
    'key'      => 'group_sk_founders',
    'title'    => 'Founder Photos',
    'location' => [[['param'=>'options_page','operator'=>'==','value'=>'sk-site-settings']]],
    'fields'   => [
      ['key'=>'field_sk_founder_tab','label'=>'Founder Photos','name'=>'','type'=>'tab'],
      ['key'=>'field_sk_founder_kalai',       'label'=>'Kalai — Portrait Photo',
       'name'=>'founder_image_kalai',       'type'=>'image','return_format'=>'array','preview_size'=>'medium',
       'instructions'=>'Portrait format, min 520×700px recommended.'],
      ['key'=>'field_sk_founder_christophe',  'label'=>'Christophe — Portrait Photo',
       'name'=>'founder_image_christophe',  'type'=>'image','return_format'=>'array','preview_size'=>'medium',
       'instructions'=>'Portrait format, min 520×700px recommended.'],
    ],
  ]);
}
