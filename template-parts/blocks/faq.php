<?php
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$faqs = get_sub_field('faqs_list');
?>
<section class="faq-section gsap-fade-up" id="faq">
  <div class="wrap">
    <div class="faq-layout">
      <div class="faq-left">
        <h2 class="display-h2"><?php echo esc_html($heading); ?></h2>
        <p class="body-serif"><?php echo esc_html($subheading); ?></p>
      </div>

      <div class="faq-right">
        <div class="faq-list">
          <?php if($faqs): $i = 0; foreach($faqs as $faq): $i++; ?>
            <div class="faq-item sk-rounded-card" style="margin-bottom: 1rem; border: 1px solid var(--border-light); padding: 1rem 1.5rem;">
              <button class="faq-trigger" aria-expanded="false" aria-controls="faq-body-<?php echo $i; ?>">
                <span class="faq-q"><?php echo esc_html($faq['question']); ?></span>
                <span class="faq-toggle"><span></span><span></span></span>
              </button>
              <div class="faq-body" id="faq-body-<?php echo $i; ?>">
                <div class="faq-body-inner">
                  <?php echo esc_html($faq['answer']); ?>
                </div>
              </div>
            </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
