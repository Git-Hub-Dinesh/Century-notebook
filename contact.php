<?php
/* ============================================================
   Century Printograph – Contact Form Handler
   ============================================================ */

$success = '';
$error   = '';
$fields  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ---- Sanitise & collect ---- */
    $fields['name']        = htmlspecialchars(trim($_POST['name']        ?? ''));
    $fields['email']       = htmlspecialchars(trim($_POST['email']       ?? ''));
    $fields['phone']       = htmlspecialchars(trim($_POST['phone']       ?? ''));
    $fields['institution'] = htmlspecialchars(trim($_POST['institution'] ?? ''));
    $fields['product']     = htmlspecialchars(trim($_POST['product']     ?? ''));
    $fields['quantity']    = htmlspecialchars(trim($_POST['quantity']    ?? ''));
    $fields['message']     = htmlspecialchars(trim($_POST['message']     ?? ''));

    /* ---- Validate ---- */
    $errors = [];
    if (empty($fields['name']))    $errors[] = 'Your name is required.';
    if (empty($fields['email']))   $errors[] = 'Your email address is required.';
    elseif (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL))
                                   $errors[] = 'Please enter a valid email address.';
    if (!empty($fields['phone']) && !preg_match('/^[0-9\+\-\s]{7,15}$/', $fields['phone']))
                                   $errors[] = 'Please enter a valid phone number.';
    if (empty($fields['message'])) $errors[] = 'Please enter your message.';

    if (!empty($errors)) {
        $error = implode(' ', $errors);
    } else {
        /* ---- Build email ---- */
        $to      = 'info@centuryprintograph.com';           // change to real address
        $subject = 'New Enquiry from ' . $fields['name'] . ' – Century Printograph';
        $body    = "Name       : {$fields['name']}\n"
                 . "Email      : {$fields['email']}\n"
                 . "Phone      : {$fields['phone']}\n"
                 . "Institution: {$fields['institution']}\n"
                 . "Product    : {$fields['product']}\n"
                 . "Quantity   : {$fields['quantity']}\n\n"
                 . "Message:\n{$fields['message']}\n";
        $headers = "From: {$fields['email']}\r\n"
                 . "Reply-To: {$fields['email']}\r\n"
                 . "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $body, $headers)) {
            $success = 'Thank you! Your enquiry has been sent. We\'ll get back to you within 24 hours.';
            $fields  = [];          // clear form on success
        } else {
            $error = 'Sorry, there was a problem sending your message. Please call us directly.';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Contact Century Printograph – get a quote for engineering records, exam booklets, B.Ed notebooks and more." />
  <title>Contact Us | Century Printograph</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { primary:'#0EA5E9', pdark:'#0284C7', plight:'#38BDF8', gold:'#F43F5E' },
          fontFamily: { sans:['Inter','system-ui','sans-serif'], display:['"Playfair Display"','Georgia','serif'] },
          container: { center:true, padding:{ DEFAULT:'1rem', sm:'1.5rem', lg:'2rem' } },
        },
      },
    };
  </script>
</head>
<body class="bg-white">

<!-- ══════════════════════════════════════════════════════════════════════════
     NAVBAR
     ══════════════════════════════════════════════════════════════════════════ -->
<nav id="navbar">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
      <a href="index.html" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold"
             style="background:linear-gradient(135deg,#0EA5E9,#0284C7);color:#fff;">C</div>
        <div>
          <div class="nav-logo-text">Century Printograph</div>
          <div class="nav-logo-sub">Notebook Manufacturers</div>
        </div>
      </a>
      <div class="hidden md:flex items-center gap-8">
        <a href="index.html"          class="nav-link">Home</a>
        <a href="about.html"          class="nav-link">About</a>
        <a href="products.html"       class="nav-link">Products</a>
        <a href="infrastructure.html" class="nav-link">Infrastructure</a>
        <a href="contact.php"         class="nav-link active">Contact</a>
        <a href="tel:+919876543210" class="nav-phone">
          <i class="fa-solid fa-phone-volume"></i> +91 98765 43210
        </a>
      </div>
      <button id="hamburger" class="hamburger md:hidden"><span></span><span></span><span></span></button>
    </div>
  </div>
  <div id="mobile-menu">
    <a href="index.html"          class="mobile-nav-link"><i class="fa-solid fa-house mr-2 opacity-70"></i>Home</a>
    <a href="about.html"          class="mobile-nav-link"><i class="fa-solid fa-circle-info mr-2 opacity-70"></i>About Us</a>
    <a href="products.html"       class="mobile-nav-link"><i class="fa-solid fa-book mr-2 opacity-70"></i>Products</a>
    <a href="infrastructure.html" class="mobile-nav-link"><i class="fa-solid fa-industry mr-2 opacity-70"></i>Infrastructure</a>
    <a href="contact.php"         class="mobile-nav-link active"><i class="fa-solid fa-envelope mr-2 opacity-70"></i>Contact</a>
  </div>
</nav>

<!-- ══════════════════════════════════════════════════════════════════════════
     PAGE HERO BANNER
     ══════════════════════════════════════════════════════════════════════════ -->
<section class="page-hero">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 content">
    <div class="section-tag" style="color:var(--secondary);background:rgba(244,63,94,0.12);border-left-color:var(--secondary);">
      <i class="fa-solid fa-envelope text-xs"></i> Get In Touch
    </div>
    <h1>Contact <span>Us</span></h1>
    <nav class="breadcrumb">
      <a href="index.html">Home</a>
      <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
      <span>Contact</span>
    </nav>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════════════
     CONTACT LAYOUT
     ══════════════════════════════════════════════════════════════════════════ -->
<section class="section nb-ruled-bg">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-5 gap-12 items-start">

      <!-- ── Left: Contact Info Column ── -->
      <aside class="lg:col-span-2 fade-in-left nb-margin">
        <div class="section-tag nb-tab"><i class="fa-solid fa-address-book text-xs"></i> <span class="nb-handwritten">Our Details</span></div>
        <h2 class="section-title mb-6">Get In Touch<br /><span>With Us</span></h2>
        <div class="gold-line"></div>
        <p class="text-gray-600 text-sm leading-relaxed mb-8">
          Whether you need a custom quote, want to place a bulk order, or simply have a question about
          our products — we're here and ready to help. Reach out through any channel below.
        </p>

        <div class="space-y-4">

          <div class="contact-info-card">
            <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
            <div class="text">
              <h4>Factory &amp; Office Address</h4>
              <p style="color:var(--primary);">No. 12, Industrial Estate,<br />Tirunelveli – 627 001,<br />Tamil Nadu, India</p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="icon"><i class="fa-solid fa-phone"></i></div>
            <div class="text">
              <h4>Phone / WhatsApp</h4>
              <p style="color:var(--primary);"><a style="color:var(--primary);" href="tel:+919876543210">+91 98765 43210</a><br />
                 <a style="color:var(--primary);" href="tel:+914622222222">0462 – 222 2222</a></p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="icon"><i class="fa-solid fa-envelope"></i></div>
            <div class="text">
              <h4>Email Us</h4>
              <p style="color:var(--primary);"><a style="color:var(--primary);" href="mailto:info@centuryprintograph.com">info@centuryprintograph.com</a><br />
                 <a style="color:var(--primary);" href="mailto:sales@centuryprintograph.com">sales@centuryprintograph.com</a></p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="icon"><i class="fa-solid fa-clock"></i></div>
            <div class="text">
              <h4>Business Hours</h4>
              <p style="color:var(--primary);">Monday – Saturday: 9:00 AM – 6:00 PM<br />Sunday: Closed</p>
            </div>
          </div>

        </div>

        <!-- Social links -->
        <div class="mt-8">
          <p class="text-xs uppercase tracking-widest font-semibold text-gray-400 mb-3">Follow Us</p>
          <div class="flex gap-3">
            <a href="#" class="social-link" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="social-link" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-link" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#" class="social-link" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
          </div>
        </div>
      </aside>

      <!-- ── Right: Contact Form ── -->
      <div class="lg:col-span-3 fade-in-right">

        <!-- PHP Success / Error Alerts -->
        <?php if ($success) : ?>
          <div class="alert alert-success mb-6" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i>
            <?= $success ?>
          </div>
        <?php endif; ?>

        <?php if ($error) : ?>
          <div class="alert alert-error mb-6" role="alert">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            <?= $error ?>
          </div>
        <?php endif; ?>

        <div class="p-8 lg:p-10 rounded-2xl shadow-xl nb-paper-card nb-stacked" style="border:1.5px solid var(--accent);">
          <h3 class="text-2xl font-bold mb-2" style="font-family:'Playfair Display',serif;color:var(--primary-dark);">
            Send Us a Message
          </h3>
          <p class="text-sm text-gray-400 mb-8">Fields marked <span class="text-red-500 font-bold">*</span> are required.</p>

          <form action="contact.php" method="POST" id="contact-form" novalidate class="space-y-5">

            <div class="grid sm:grid-cols-2 gap-5">
              <!-- Name -->
              <div class="form-group">
                <label for="name">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" class="form-input"
                       placeholder="Eg. Dr. Ramesh Kumar"
                       value="<?= htmlspecialchars($fields['name'] ?? '') ?>"
                       required autocomplete="name" />
              </div>
              <!-- Email -->
              <div class="form-group">
                <label for="email">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" class="form-input"
                       placeholder="yourname@institution.edu"
                       value="<?= htmlspecialchars($fields['email'] ?? '') ?>"
                       required autocomplete="email" />
              </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <!-- Phone -->
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-input"
                       placeholder="+91 98765 43210"
                       value="<?= htmlspecialchars($fields['phone'] ?? '') ?>"
                       autocomplete="tel" />
              </div>
              <!-- Institution -->
              <div class="form-group">
                <label for="institution">Institution / College Name</label>
                <input type="text" id="institution" name="institution" class="form-input"
                       placeholder="Eg. Anna University, Chennai"
                       value="<?= htmlspecialchars($fields['institution'] ?? '') ?>" />
              </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <!-- Product -->
              <div class="form-group">
                <label for="product">Product Interest</label>
                <select id="product" name="product" class="form-input">
                  <option value="" <?= empty($fields['product']) ? 'selected' : '' ?>>– Select a product –</option>
                  <optgroup label="Engineering / Polytechnic">
                    <option value="Engineering Record Note"      <?= ($fields['product'] ?? '') === 'Engineering Record Note'      ? 'selected' : '' ?>>Engineering Record Note</option>
                    <option value="Engineering Test Note"        <?= ($fields['product'] ?? '') === 'Engineering Test Note'        ? 'selected' : '' ?>>Test Note</option>
                    <option value="Engineering Class Note"       <?= ($fields['product'] ?? '') === 'Engineering Class Note'       ? 'selected' : '' ?>>Class Note</option>
                    <option value="Exam Booklet – Standard"      <?= ($fields['product'] ?? '') === 'Exam Booklet – Standard'      ? 'selected' : '' ?>>Exam Booklet – Standard</option>
                    <option value="Exam Booklet – Autonomous"    <?= ($fields['product'] ?? '') === 'Exam Booklet – Autonomous'    ? 'selected' : '' ?>>Exam Booklet – Autonomous</option>
                    <option value="Polytechnic Record Note"      <?= ($fields['product'] ?? '') === 'Polytechnic Record Note'      ? 'selected' : '' ?>>Polytechnic Record Note</option>
                    <option value="Engineering Drawing Record"   <?= ($fields['product'] ?? '') === 'Engineering Drawing Record'   ? 'selected' : '' ?>>Engineering Drawing Record</option>
                    <option value="Graph / Blank Note"           <?= ($fields['product'] ?? '') === 'Graph / Blank Note'           ? 'selected' : '' ?>>Graph / Blank Note</option>
                  </optgroup>
                  <optgroup label="Pharmacy">
                    <option value="Pharmacy Record Note"         <?= ($fields['product'] ?? '') === 'Pharmacy Record Note'         ? 'selected' : '' ?>>Pharmacy Record Note</option>
                  </optgroup>
                  <optgroup label="B.Ed">
                    <option value="B.Ed 21 Record Note"          <?= ($fields['product'] ?? '') === 'B.Ed 21 Record Note'          ? 'selected' : '' ?>>B.Ed 21 Record Note</option>
                    <option value="Lesson Plan Book"             <?= ($fields['product'] ?? '') === 'Lesson Plan Book'             ? 'selected' : '' ?>>Lesson Plan Book</option>
                    <option value="Practice Teaching Record"     <?= ($fields['product'] ?? '') === 'Practice Teaching Record'     ? 'selected' : '' ?>>Practice Teaching Record</option>
                  </optgroup>
                  <option value="Custom / Other"                 <?= ($fields['product'] ?? '') === 'Custom / Other'               ? 'selected' : '' ?>>Custom / Other</option>
                </select>
              </div>
              <!-- Quantity -->
              <div class="form-group">
                <label for="quantity">Quantity Required</label>
                <input type="text" id="quantity" name="quantity" class="form-input"
                       placeholder="Eg. 500 units, 50 boxes"
                       value="<?= htmlspecialchars($fields['quantity'] ?? '') ?>" />
              </div>
            </div>

            <!-- Message -->
            <div class="form-group">
              <label for="message">Your Message <span class="text-red-500">*</span></label>
              <textarea id="message" name="message" rows="5" class="form-input"
                        placeholder="Tell us about your requirements – size, page count, branding, delivery timeline..."
                        required><?= htmlspecialchars($fields['message'] ?? '') ?></textarea>
            </div>

            <!-- Submit -->
            <div class="pt-2">
              <button type="submit" class="btn-primary w-full flex items-center justify-center gap-3 text-base"
                      style="padding:14px 24px;border-radius:10px;">
                <i class="fa-solid fa-paper-plane"></i>
                Send Enquiry
              </button>
              <p class="text-xs text-gray-400 text-center mt-3">
                <i class="fa-solid fa-lock mr-1"></i>
                Your information is private and will never be shared with third parties.
              </p>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════════════
     GOOGLE MAP EMBED
     ══════════════════════════════════════════════════════════════════════════ -->
<section class="section-alt" style="padding:0;">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="text-center mb-10 fade-in">
      <div class="section-tag nb-tab mx-auto"><i class="fa-solid fa-map-location-dot text-xs"></i> <span class="nb-handwritten">Find Us</span></div>
      <h2 class="section-title">Visit Our<br /><span>Factory &amp; Office</span></h2>
    </div>
    <div class="rounded-2xl overflow-hidden shadow-xl fade-in" style="height:420px;">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63115.46396543609!2d77.62779025!3d8.7273453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b04171c8a4ede95%3A0x8bc81fc0d5fd5695!2sTirunelveli%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
        width="100%" height="420"
        style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Century Printograph – Tirunelveli, Tamil Nadu">
      </iframe>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════════════
     CTA STRIP
     ══════════════════════════════════════════════════════════════════════════ -->
<section class="section" style="padding:4rem 0;">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="rounded-3xl p-10 text-center text-white fade-in"
         style="background:linear-gradient(135deg,var(--primary-dark),var(--plight));">
      <div class="text-3xl font-bold mb-3" style="font-family:'Playfair Display',serif;">
        Prefer to call us directly?
      </div>
      <p class="text-blue-200 mb-6 max-w-xl mx-auto text-sm leading-relaxed">
        Our sales team is available Monday to Saturday, 9 AM – 6 PM to answer your enquiries,
        confirm pricing, and dispatch samples.
      </p>
      <a href="tel:+919876543210"
         class="inline-flex items-center gap-3 text-base font-semibold px-8 py-4 rounded-xl border-2 border-white text-white hover:bg-white hover:text-primary transition-all duration-200">
        <i class="fa-solid fa-phone-volume text-gold-400"></i>
        Call +91 98765 43210
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════════════
     FOOTER
     ══════════════════════════════════════════════════════════════════════════ -->
<footer class="footer">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
      <div>
        <div class="footer-logo-text">Century Printograph</div>
        <span class="footer-tagline">Notebook Manufacturers</span>
        <p>Crafting premium academic notebooks trusted by institutions across Tamil Nadu since 2005.</p>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </div>
      <div>
        <h4>Quick Links</h4>
        <a href="index.html"          class="footer-link">Home</a>
        <a href="about.html"          class="footer-link">About Us</a>
        <a href="products.html"       class="footer-link">Products</a>
        <a href="infrastructure.html" class="footer-link">Infrastructure</a>
        <a href="contact.php"         class="footer-link">Contact</a>
      </div>
      <div>
        <h4>Products</h4>
        <a href="products.html" class="footer-link">Engineering Record Note</a>
        <a href="products.html" class="footer-link">Exam Booklet</a>
        <a href="products.html" class="footer-link">Test &amp; Class Note</a>
        <a href="products.html" class="footer-link">Pharmacy Record Note</a>
        <a href="products.html" class="footer-link">B.Ed 21 Record Note</a>
      </div>
      <div>
        <h4>Contact Info</h4>
        <div class="footer-contact-item"><i class="fa-solid fa-location-dot"></i><span>No. 12, Industrial Estate, Tirunelveli – 627 001, Tamil Nadu</span></div>
        <div class="footer-contact-item"><i class="fa-solid fa-phone"></i><a href="tel:+919876543210">+91 98765 43210</a></div>
        <div class="footer-contact-item"><i class="fa-solid fa-envelope"></i><a href="mailto:info@centuryprintograph.com">info@centuryprintograph.com</a></div>
        <div class="footer-contact-item"><i class="fa-solid fa-clock"></i><span>Mon – Sat: 9:00 AM – 6:00 PM</span></div>
      </div>
    </div>
  </div>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="footer-bottom">
      <span>© 2025 Century Printograph. All rights reserved.</span>
      <span>Designed &amp; Developed by <a href="#">Waybig Technologies</a></span>
    </div>
  </div>
</footer>

<button id="back-to-top" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
<script src="assets/js/main.js"></script>
</body>
</html>
