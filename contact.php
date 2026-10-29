<?php
$page_title = 'Contact Arabinfotec | Arabinfotec';
$page_description = 'Talk to Arabinfotec about your website, e-commerce, software or digital marketing project.';
$body_data_page = 'contact';

require_once __DIR__ . '/includes/header.php';
?>
    <section class="contact contact-page">
      <div class="wrap contact-grid">
        <div>
          <p class="eyebrow">LET’S TALK</p>
          <h1>Your next<br><em>chapter.</em></h1>
          <p>A new website, an online store or a better way to run your operations. Tell us what you have in mind.</p>
          <a class="contact-email" href="mailto:hello@arabinfotec.com">hello@arabinfotec.com ↗</a>
          <div class="contact-methods">
            <a href="tel:+971543697999">+971 54 369 7999</a>
            <a href="https://wa.me/971543697999" target="_blank" rel="noopener">Chat on WhatsApp ↗</a>
          </div>
          <div class="service-scene scene-contact" data-scene>
            <div class="scene-art">
              <div class="contact-journey">
                <span>01 <b>Your idea</b></span><i>→</i>
                <span>02 <b>A conversation</b></span><i>→</i>
                <span>03 <b>A clear plan</b></span>
              </div>
            </div>
            <div class="scene-caption">
              <span>How your project begins</span>
              <button type="button" class="scene-replay" hidden>↻ Replay</button>
            </div>
          </div>
          <div class="contact-expect">
            <h3>What happens next?</h3>
            <p>We discuss your goals and requirements, then work towards a clear scope and proposal.</p>
          </div>
        </div>

        <form id="brief-form" action="send-inquiry.php" method="POST">
          <input type="text" name="hp_name" style="display:none;" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_loaded_at" id="form_loaded_at" value="">
          <input type="hidden" name="ad_source" id="ad_source" value="">
          <input type="hidden" name="sourcetag" id="sourcetag" value="">
          <input type="hidden" name="utm_campaign" id="utm_campaign" value="">
          <input type="hidden" name="recaptcha_token" id="recaptcha_token" value="">

          <label for="name">
            Your name *
            <input id="name" name="name" autocomplete="name" placeholder="How should we address you?" required maxlength="100">
          </label>
          <label for="company">
            Company
            <input id="company" name="company" autocomplete="organization" placeholder="Your company name" maxlength="160">
          </label>
          <label for="email">
            Your email *
            <input id="email" name="email" type="email" autocomplete="email" placeholder="name@company.com" required maxlength="200">
          </label>
          <label for="phone">
            Phone / WhatsApp *
            <input id="phone" name="phone" type="tel" autocomplete="tel" placeholder="+971 50 123 4567" required maxlength="25">
          </label>
          <label for="service">
            I’m interested in *
            <select id="service" name="service">
              <option>Website design</option>
              <option>E-commerce</option>
              <option>Software &amp; mobile apps</option>
              <option>Digital marketing</option>
              <option>Let’s explore together</option>
            </select>
          </label>
          <label for="message">
            A little about your project
            <textarea id="message" name="message" rows="4" placeholder="What would you like to create or improve?" maxlength="2000"></textarea>
          </label>

          <div class="g-recaptcha" data-sitekey="6LcCZQYuAAAAAHFKJV_GCiQ_ilGN7hGUOPWwwnQy" style="margin: 18px 0 12px;"></div>

          <div class="form-buttons">
            <button class="button" type="submit" id="submit-btn">Send Enquiry <span>↗</span></button>
            <a class="button secondary" href="https://wa.me/971543697999" rel="noopener" target="_blank" style="text-align:center;text-decoration:none;">
        Chat on WhatsApp
        <span>
         &nearrow;
        </span>
       </a>
          </div>   
          <p class="form-note">Your enquiry is sent securely to our team. We'll get back to you shortly.</p>
          <p id="form-status" role="status" aria-live="polite"></p>
        </form>
      </div>
    </section>

    <section class="offices wrap" id="offices">
      <p class="eyebrow">GET IN TOUCH</p>
      <h2>Regional connections.<br><em>One team.</em></h2>
      <div class="office-grid">
        <article><h3>UAE</h3><p>Dubai</p><a href="tel:+97148520449">+971 4 852 0449</a></article>
        <article><h3>India</h3><p>Infopark, Cherthala</p><a href="tel:+914782554004">+91 478 255 4004</a></article>
        <article><h3>USA</h3><p>New York</p><a href="tel:+14788004004">+1 478 800 4004</a></article>
        <article><h3>Europe</h3><p>Netherlands</p><a href="tel:+31621988937">+31 6 2198 8937</a></article>
      </div>
    </section>
<?php
require_once __DIR__ . '/includes/footer.php';
?>
