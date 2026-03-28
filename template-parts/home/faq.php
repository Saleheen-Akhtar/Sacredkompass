<?php
/* FAQ — ACF repeater: faq_question, faq_answer */

$acf_faqs = function_exists('get_field') ? get_field('faqs') : [];
$fallback_faqs = [
  [__('What is Jyotish astrology?','sacred-kompass'),                          __("Jyotish is the ancient Vedic science of light — a system of astrology that predates Western traditions by thousands of years. It maps the soul's journey through planetary cycles, helping us understand our dharma, karmic patterns, and the auspicious timing of major life decisions.",'sacred-kompass')],
  [__('Do I need prior experience to attend?','sacred-kompass'),               __('No experience is needed for any of our offerings. We welcome complete beginners alongside seasoned practitioners. Our guides meet you exactly where you are, with patience, warmth, and deep respect for your unique path.','sacred-kompass')],
  [__('Are sessions available online?','sacred-kompass'),                       __('Yes. Most private sessions are available online via video call. In-person sessions are held at our space in Bedok North, Singapore. Please contact us to confirm the format when booking.','sacred-kompass')],
  [__('What is Nonviolent Communication (NVC)?','sacred-kompass'),              __("Developed by Marshall Rosenberg, NVC is a language of the heart — a framework for expressing ourselves honestly and listening to others with deep empathy. We use it as both a practical communication tool and a spiritual practice of compassion.",'sacred-kompass')],
  [__('How do I know which service is right for me?','sacred-kompass'),         __("We offer a free 20-minute discovery call to understand where you are and what you're seeking. From there, our team will lovingly suggest which offering, format, and guide feels most aligned with your current chapter of life.",'sacred-kompass')],
  [__('Do you offer corporate or organisational programmes?','sacred-kompass'), __('Yes. We design bespoke workshops and consulting engagements for teams and organisations seeking to integrate conscious leadership, emotional resilience, and compassionate culture. Please reach out directly to discuss your needs.','sacred-kompass')],
];

/* Merge ACF repeater rows into consistent format */
$faqs = [];
if ($acf_faqs) {
  foreach ($acf_faqs as $row) {
    $faqs[] = [
      $row['faq_question'] ?? '',
      $row['faq_answer']   ?? '',
    ];
  }
} else {
  $faqs = $fallback_faqs;
}
?>
<section class="faq-section" id="faq" aria-labelledby="faq-heading">
  <div class="wrap">
    <div class="faq-layout">

      <div class="faq-left reveal">
        <div class="eyebrow"><?php esc_html_e('Questions','sacred-kompass'); ?></div>
        <h2 class="display-h2" id="faq-heading">
          <?php esc_html_e('Frequently','sacred-kompass'); ?><br>
          <em><?php esc_html_e('Asked','sacred-kompass'); ?></em>
        </h2>
        <p class="body-serif">
          <?php esc_html_e('If you have more questions, we warmly invite you to reach out. Every journey begins with a conversation.','sacred-kompass'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-outline">
          <?php esc_html_e('Book a Free Call','sacred-kompass'); ?>
        </a>
      </div>

      <div class="faq-list reveal d2" role="list">
        <?php foreach ($faqs as $idx => [$q, $a]) : ?>
        <div class="faq-item" role="listitem">
          <button class="faq-trigger"
                  aria-expanded="false"
                  aria-controls="faq-body-<?php echo $idx; ?>">
            <span class="faq-q"><?php echo esc_html($q); ?></span>
            <span class="faq-toggle" aria-hidden="true"><span></span><span></span></span>
          </button>
          <div class="faq-body" id="faq-body-<?php echo $idx; ?>" role="region">
            <div class="faq-body-inner"><?php echo esc_html($a); ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>
