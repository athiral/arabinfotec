<?php
/**
 * Common Footer for Arabinfotec
 *
 * Accepted variables:
 * - $base_url      : Optional path prefix, defaults to '' (e.g. '../../' for subdirectories)
 * - $extra_scripts : Optional raw HTML script tags inserted before </body>
 */
$base_url = isset($base_url) ? $base_url : '';
?>
  </main>
  <footer class="global-footer" id="global-presence">
   <div class="global-stage wrap">
    <div class="global-heading">
     <p class="eyebrow">
      ROOTED IN DUBAI. CONNECTED TO THE WORLD.
     </p>
     <h2>
      One team.
      <br/>
      Across
      <em>
       borders.
      </em>
     </h2>
     <p>
      Local understanding.
      <br/>
      Ideas without boundaries.
     </p>
     <a class="global-contact" href="<?php echo $base_url; ?>contact">
      Start a conversation
      <span>
       &nearrow;
      </span>
     </a>
    </div>
    <svg aria-hidden="true" class="world-map" viewbox="0 0 1000 500">
     <defs>
      <pattern height="8" id="land-dots" patternunits="userSpaceOnUse" width="8">
       <circle cx="3" cy="3" fill="#bd9ad5" r="1.7">
       </circle>
      </pattern>
      <radialgradient id="map-glow">
       <stop stop-color="#aa5bab" stop-opacity=".24">
       </stop>
       <stop offset="1" stop-color="#aa5bab" stop-opacity="0">
       </stop>
      </radialgradient>
     </defs>
     <ellipse cx="590" cy="240" fill="url(#map-glow)" rx="400" ry="230">
     </ellipse>
     <g fill="url(#land-dots)" opacity=".55">
      <path d="M65 100 110 70 170 55 230 72 277 65 300 94 270 125 241 139 225 175 197 195 183 230 160 225 140 197 117 181 109 145 80 137Z M172 224 195 232 205 250 228 259 233 275 216 272 196 256Z M270 40 310 25 346 48 325 91 294 111 268 90Z">
      </path>
      <path d="M228 270 263 262 303 280 332 301 320 340 298 366 281 400 259 443 244 421 251 382 236 346 219 310Z">
      </path>
      <path d="M445 118 458 99 488 92 509 105 535 96 549 123 536 141 510 149 489 139 480 156 462 150 449 132Z M441 98 452 84 460 92 451 117 440 114Z M481 80 498 49 518 54 510 83Z">
      </path>
      <path d="M456 169 490 152 526 163 551 191 570 214 555 247 538 278 518 327 496 337 481 308 475 271 450 248 431 215 437 188Z M554 285 564 275 567 297 556 318 550 309Z">
      </path>
      <path d="M526 93 560 73 611 64 660 55 704 64 744 56 795 74 839 74 889 105 910 125 879 144 851 127 832 154 797 171 781 200 749 219 725 210 699 232 683 269 664 264 645 229 623 219 607 198 579 190 566 162 541 147Z M558 189 583 193 605 220 583 237 568 216Z M712 238 735 246 750 278 736 282 722 264Z M775 211 788 221 781 247 772 231Z M839 161 851 148 855 163 846 180 836 187Z M739 291 771 296 787 308 814 311 826 327 793 324 763 314Z">
      </path>
      <path d="M800 345 835 329 874 343 896 365 888 400 857 416 834 401 803 404 788 381Z M918 405 928 391 936 406 920 430 909 438Z">
      </path>
     </g>
     <g fill="none" opacity=".7" stroke="#d7a8df" stroke-width="1.2">
      <path class="map-route" d="M235 160 Q400 20 587 219">
      </path>
      <path class="map-route" d="M495 126 Q560 115 587 219">
      </path>
      <path class="map-route" d="M587 219 Q650 188 687 265">
      </path>
     </g>
     <g fill="#edc6eb" stroke="#edc6eb30" stroke-width="13">
      <circle cx="235" cy="160" r="4">
      </circle>
      <circle cx="495" cy="126" r="4">
      </circle>
      <circle cx="587" cy="219" r="5">
      </circle>
      <circle cx="687" cy="265" r="4">
      </circle>
     </g>
     <g fill="#eadbec" font-family="Arial,sans-serif" font-size="13" letter-spacing="2">
      <text x="200" y="141">
       USA
      </text>
      <text x="455" y="106">
       EUROPE
      </text>
      <text x="553" y="249">
       UAE
      </text>
      <text x="701" y="287">
       INDIA
      </text>
     </g>
    </svg>
   </div>
   <div class="global-regions wrap">
    <a href="<?php echo $base_url; ?>contact#offices">
     <span>
      01 / UAE
     </span>
     <strong>
      Dubai
     </strong>
     <i aria-hidden="true">
      &nearrow;
     </i>
    </a>
    <a href="<?php echo $base_url; ?>contact#offices">
     <span>
      02 / India
     </span>
     <strong>
      Infopark, Cherthala
     </strong>
     <i aria-hidden="true">
      &nearrow;
     </i>
    </a>
    <a href="<?php echo $base_url; ?>contact#offices">
     <span>
      03 / USA
     </span>
     <strong>
      North America
     </strong>
     <i aria-hidden="true">
      &nearrow;
     </i>
    </a>
    <a href="<?php echo $base_url; ?>contact#offices">
     <span>
      04 / Europe
     </span>
     <strong>
      Netherlands
     </strong>
     <i aria-hidden="true">
      &nearrow;
     </i>
    </a>
   </div>
   <div class="global-links wrap">
    <div class="global-brand">
     <a href="<?php echo $base_url ? $base_url : './'; ?>">
      <img alt="arabinfotec" class="logo" height="45" loading="lazy" src="<?php echo $base_url; ?>assets/logo.png" width="195"/>
     </a>
     <p>
      AIT Information Technology L.L.C
      <br/>
      Dubai, United Arab Emirates
     </p>
     <a class="group-link" href="https://virtualsysglobal.com/" target="_blank" rel="noopener">
      Part of Virtualsys Global Group
     </a>
     <button type="button" class="brochure-download-btn" id="open-brochure-modal" aria-haspopup="dialog" aria-controls="brochure-modal">
      <span>Download Our Brochure</span>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
     </button>
    </div>
    <div>
     <h3>
      Discover
     </h3>
     <a href="<?php echo $base_url; ?>solutions">
      Solutions
     </a>
     <a href="<?php echo $base_url; ?>about">
      About us
     </a>
     <a href="<?php echo $base_url; ?>team">
      Our team
     </a>
     <a href="<?php echo $base_url; ?>work">
      Our work
     </a>
     <a href="<?php echo $base_url; ?>contact">
      Contact
     </a>
    </div>
    <div>
     <h3>
      What we do
     </h3>
     <a href="<?php echo $base_url; ?>website-design">
      Website design
     </a>
     <a href="<?php echo $base_url; ?>e-commerce">
      E-commerce
     </a>
     <a href="<?php echo $base_url; ?>app-development">
      Software &amp; apps
     </a>
     <a href="<?php echo $base_url; ?>digital-marketing">
      Digital marketing
     </a>
    </div>
    <div>
     <h3>
      Let&rsquo;s connect
     </h3>
     <a href="mailto:hello@arabinfotec.com">
      hello@arabinfotec.com
     </a>
     <a href="tel:+971543697999">
      +971 54 369 7999
     </a>
     <a class="pay-link" href="https://arabinfotechllc.com/quick_pay.php" rel="noopener noreferrer" target="_blank">
      Quick Pay
      <span aria-hidden="true">
       &nearrow;
      </span>
      <span class="sr-only">
       (opens in a new tab)
      </span>
     </a>
     <div class="footer-socials" aria-label="Social media">
      <a href="https://www.facebook.com/arabinfotec" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
       <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.52-.14-2.73-.14-2.84 0-4.77 1.73-4.77 4.9V9.5H7v4h3V22h4v-8.5z"/></svg>
      </a>
      <a href="https://x.com/arabinfotec" target="_blank" rel="noopener noreferrer" aria-label="X (formerly Twitter)">
       <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      </a>
      <a href="https://www.linkedin.com/company/5303815/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
       <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
      </a>
      <a href="https://www.youtube.com/channel/UConU2gg52rHALzD6QNU2DoQ" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
       <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
      </a>
      <a href="https://www.instagram.com/arabinfotec_/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
       <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
      </a>
     </div>
    </div>
   </div>
   <div class="global-bottom wrap">
    <span>
     &copy; 2026 Arabinfotec
    </span>
    <nav aria-label="Legal information">
     <a href="<?php echo $base_url; ?>privacy-policy">
      Privacy policy
     </a>
     <a href="<?php echo $base_url; ?>terms">
      Terms &amp; conditions
     </a>
     <a href="<?php echo $base_url; ?>refund-policy">
      Cancellation &amp; refunds
     </a>
    </nav>
    <a href="#">
     Back to top &uarr;
    </a>
   </div>
  </footer>
  <!-- Brochure Download Modal -->
  <div class="brochure-modal-overlay" id="brochure-modal" aria-hidden="true" role="dialog" aria-labelledby="brochure-modal-title">
   <div class="brochure-modal-backdrop" id="brochure-modal-backdrop"></div>
   <div class="brochure-modal-card">
    <button type="button" class="brochure-modal-close" id="close-brochure-modal" aria-label="Close modal">
     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="brochure-modal-header">
     <!-- <div class="brochure-badge">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
       <span>Company Profile 2026 - 2027</span>
     </div> -->
     <h3 id="brochure-modal-title">Download Our Brochure</h3>
     <p>Please provide your contact details to download the official Arabinfotec company profile and service overview.</p>
    </div>

    <form id="brochure-form" class="brochure-form" method="POST" action="<?php echo $base_url; ?>send-brochure.php" data-download-url="<?php echo $base_url; ?>download-brochure.php" novalidate>
     <!-- Honeypot & Security -->
     <div style="display:none;" aria-hidden="true">
      <input type="text" name="hp_name" tabindex="-1" autocomplete="off" />
      <input type="hidden" name="form_loaded_at" id="brochure-form-loaded-at" value="" />
      <input type="hidden" name="download_url" value="<?php echo $base_url; ?>download-brochure.php" />
     </div>

     <div class="brochure-form-grid">
      <div class="brochure-field">
       <label for="brochure-name">Your Full Name <span class="required">*</span></label>
       <input type="text" id="brochure-name" name="name" placeholder="e.g. John Doe" required autocomplete="name" />
       <span class="brochure-field-error" id="error-brochure-name"></span>
      </div>

      <div class="brochure-field">
       <label for="brochure-email">Email Address <span class="required">*</span></label>
       <input type="email" id="brochure-email" name="email" placeholder="e.g. john@company.com" required autocomplete="email" />
       <span class="brochure-field-error" id="error-brochure-email"></span>
      </div>

      <div class="brochure-field">
       <label for="brochure-phone">Phone / WhatsApp </label>
       <input type="tel" id="brochure-phone" name="phone" placeholder="e.g. +971 50 123 4567" autocomplete="tel" />
       <span class="brochure-field-error" id="error-brochure-phone"></span>
      </div>

      <div class="brochure-field">
       <label for="brochure-company">Company Name</label>
       <input type="text" id="brochure-company" name="company" placeholder="e.g. ACME Corp" autocomplete="organization" />
      </div>
     </div>

     <div class="brochure-field full-width">
      <label for="brochure-message">Project Requirements / Notes <span class="optional">(Optional)</span></label>
      <textarea id="brochure-message" name="message" rows="2" placeholder="Tell us briefly about your interest or requirements..."></textarea>
     </div>

     <div class="brochure-form-actions">
      <button type="submit" class="brochure-submit-btn" id="brochure-submit-btn">
       <span>Download Company Profile</span>
       <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      </button>
     </div>

     <div class="brochure-status" id="brochure-status" role="status" aria-live="polite"></div>
    </form>
   </div>
  </div>
  <script src="<?php echo $base_url; ?>app.js?v=3.4"></script>
  <?php if (!empty($extra_scripts)) echo $extra_scripts; ?>
 </body>
</html>
<?php
if (ob_get_level() > 0) {
    $cleanOutput = ob_get_clean();
    $cleanOutput = preg_replace('/(<br\s*\/?>)?\s*<b>Warning<\/b>:\s*Module\s+"imagick"[^<]*?(line\s*<b>0<\/b>|<br\s*\/?>)?/i', '', $cleanOutput);
    echo $cleanOutput;
}
?>