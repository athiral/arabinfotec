<?php
/**
 * send-inquiry.php
 * Clean, secure, production-ready AJAX handler
 */

ob_start();

/* =========================================================
   HEADERS
========================================================= */
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

ini_set('display_errors', 0);
error_reporting(0);

/* =========================================================
   AUTOLOADER & IMPORTS
========================================================= */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* =========================================================
   HELPERS
========================================================= */
function respond(bool $success, string $message, int $code = 200): void {
    if (!headers_sent()) {
        http_response_code($code);
        if (ob_get_length()) {
            ob_clean();
        }
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
    }
    exit;
}

function clean(string $v = ''): string {
    return trim($v);
}

function h(string $v = ''): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* =========================================================
   METHOD + ORIGIN CHECK
========================================================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.', 405);
}

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = [
    'https://arabinfotec.com',
    'https://www.arabinfotec.com'
];

$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true) ||
           preg_match('/^https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?$/i', $origin);

if ($origin && !in_array($origin, $allowedOrigins, true) && !$isLocal) {
    respond(false, 'Forbidden origin.', 403);
}

/* =========================================================
   CONFIG (MOVE TO ENV IN REAL DEPLOYMENT)
========================================================= */
define('RECAPTCHA_SECRET', '6Ld0nUAsAAAAACSKi9MO6nAy2NovHzlg8l04TSyP');

define('SMTP_HOST', 'ded6951.inmotionhosting.com');
define('SMTP_USER', 'mailer@arabinfotec.com');
define('SMTP_PASS', '2uumwpFKXA8Y');
define('SMTP_PORT', 587);
// Production admin email:
// define('ADMIN_EMAIL', 'hello@arabinfotec.com');
// Testing admin email (safe for local tests):
define('ADMIN_EMAIL', 'athira@virtualsystechnologies.com');

define('CC_EMAILS', [
    // 'info@arabinfotechllc.com',
    // 'sreechand@arabinfotechllc.com',
    // 'sreechand@vstbiz.com',
    // 'sangeeta@vstbiz.com',
    // 'praveen@vstbiz.com',
    'athira@virtualsystechnologies.com'
]);

define('WEBHOOK_URL', 'https://affiliate.arabinfotechllc.com/index.php/webhooks/crm');
define('WEBHOOK_SECRET', '9zPouKYgGFQyeMvEJsiqtTie');

/* =========================================================
   HONEYPOT
========================================================= */
if (!empty($_POST['hp_name'] ?? '')) {
    respond(true, 'Thanks!');
}

/* =========================================================
   HUMAN TIMING CHECK
========================================================= */
$formLoadedAt = (int) ($_POST['form_loaded_at'] ?? 0);
if ($formLoadedAt && (time() * 1000 - $formLoadedAt) < 3000) {
    respond(false, 'Submission too fast.', 429);
}

/* =========================================================
   READ INPUT
========================================================= */
$business = clean($_POST['company'] ?? '');
$name     = clean($_POST['name'] ?? '');
$phone    = preg_replace('/[^0-9+]/', '', clean($_POST['phone'] ?? ''));
$email    = clean($_POST['email'] ?? '');
$service  = clean($_POST['service'] ?? '');
$notes    = clean($_POST['message'] ?? '');

$ad_source    = clean($_POST['ad_source'] ?? '');
$sourcetag    = clean($_POST['sourcetag'] ?? '');
$utm_campaign = clean($_POST['utm_campaign'] ?? '');

$recaptcha_token = $_POST['recaptcha_token'] ?? '';

/* =========================================================
   VALIDATION
========================================================= */
if (!$name || !$phone || !$email || !$service) {
    respond(false, 'Please fill all required fields.', 400);
}

if (!$business) {
    $business = 'Not provided';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Invalid email address.', 400);
}

if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
    respond(false, 'Invalid phone number.', 400);
}

/* =========================================================
   reCAPTCHA v3 (cURL)
========================================================= */
$captchaVerified = false;

if ($recaptcha_token) {
    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'secret'   => RECAPTCHA_SECRET,
            'response' => $recaptcha_token
        ]),
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    $captchaResponse = curl_exec($ch);
    curl_close($ch);

    if ($captchaResponse) {
        $captcha = json_decode($captchaResponse, true);
        if (
            !empty($captcha['success']) &&
            ($captcha['score'] ?? 0) >= 0.3 &&
            ($captcha['action'] ?? '') === 'submit'
        ) {
            $captchaVerified = true;
        }
    }
}

// Enforce strict reCAPTCHA on production
if (!$captchaVerified) {
    if (!$isLocal) {
        if (!$recaptcha_token) {
            respond(false, 'Captcha token missing.', 400);
        }
        respond(false, 'Captcha verification failed.', 400);
    }
}

/* =========================================================
   RATE LIMITING (IP + PHONE)
========================================================= */
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

$ipFile    = sys_get_temp_dir() . '/lead_ip_' . md5($ip);
$phoneFile = sys_get_temp_dir() . '/lead_phone_' . md5($phone);

if (
    (file_exists($ipFile) && time() - filemtime($ipFile) < 10) ||
    (file_exists($phoneFile) && time() - filemtime($phoneFile) < 60)
) {
    respond(false, 'Duplicate submission detected.', 429);
}

touch($ipFile);
touch($phoneFile);

/* =========================================================
   FAST ASYNC FLUSH RESPONSE TO CLIENT (INSTANT REDIRECT)
========================================================= */
ignore_user_abort(true);
set_time_limit(60);

$responsePayload = json_encode([
    'success' => true,
    'message' => 'Thanks — we will contact you shortly.'
]);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Content-Length: ' . strlen($responsePayload));
http_response_code(200);

ob_clean();
echo $responsePayload;

while (ob_get_level() > 0) {
    ob_end_flush();
}
flush();

if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request();
}

/* =========================================================
   SEND TO CRM WEBHOOK (RUNS IN BACKGROUND)
========================================================= */
$remarks = trim(
    ($service ? "Service: $service\n" : '') .
    ($notes ? "Notes:\n$notes\n" : '')
);

$payload = [
    'name'             => $name,
    'email'            => $email,
    'mobile'           => $phone,
    'company'          => $business,
    'remarks'          => $remarks,
    'status'           => 1,
    'contact_source'   => 28,
    'contact_priority' => 2,
    'created_at'       => date('Y-m-d H:i:s'),
    'ad_source'        => $ad_source,
    'sourcetag'        => $sourcetag,
    'utm_campaign'     => $utm_campaign
];

$payloadJson = json_encode($payload);
$signature = hash_hmac('sha256', $payloadJson, WEBHOOK_SECRET);

$ch = curl_init(WEBHOOK_URL);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $payloadJson,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'X-Webhook-Signature: ' . $signature,
        'Content-Length: ' . strlen($payloadJson),
        'Origin: https://arabinfotec.com'
    ],
    CURLOPT_REFERER => 'https://arabinfotec.com/',
    CURLOPT_TIMEOUT => 5,
    CURLOPT_SSL_VERIFYPEER => false
]);
curl_exec($ch);
curl_close($ch);

/* =========================================================
   SEND EMAIL (PHPMailer via Composer)
========================================================= */
try {
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom(SMTP_USER, 'Arabinfotec');
        $mail->addAddress(ADMIN_EMAIL);
        $mail->addReplyTo($email, $name);

        foreach (CC_EMAILS as $cc) {
            if (filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                $mail->addCC($cc);
            }
        }

        $mail->isHTML(true);
        $mail->Subject = "Arabinfotec New Enquiry | {$business}";
        $mail->Body = '
<div style="font-family:Arial,Helvetica,sans-serif;background:#f4f6fb;padding:24px;color:#0f172a">
  <div style="
    max-width:620px;
    margin:0 auto;
    background:#ffffff;
    border-radius:8px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    overflow:hidden
  ">

    <!-- Header -->
    <div style="padding:20px 24px;border-bottom:1px solid #e5e7eb">
      <h2 style="margin:0;font-size:20px;font-weight:700;color:#0f172a">
        New  Enquiry
      </h2>
      <p style="margin:6px 0 0;font-size:13px;color:#64748b">
          You’ve received a enquiry from the arabinfotec website.
      </p>
    </div>

    <!-- Lead Details -->
    <div style="padding:20px 24px">
      <table width="100%" cellpadding="6" cellspacing="0"
             style="border-collapse:collapse;font-size:14px">
        <tr>
          <td style="width:35%;color:#475569;font-weight:600">Company Name</td>
          <td style="color:#0f172a">' . h($business) . '</td>
        </tr>
        <tr>
          <td style="color:#475569;font-weight:600">Contact Person</td>
          <td>' . h($name) . '</td>
        </tr>
        <tr>
          <td style="color:#475569;font-weight:600">Phone / WhatsApp</td>
          <td>' . h($phone) . '</td>
        </tr>
        <tr>
          <td style="color:#475569;font-weight:600">Email</td>
          <td>' . h($email) . '</td>
        </tr>

        <tr>
          <td style="color:#475569;font-weight:600">Service Interest</td>
          <td>' . h($service) . '</td>
        </tr>

      </table>

      <!-- Divider -->
      <hr style="margin:18px 0;border:none;border-top:1px solid #e5e7eb">

      <!-- Remarks -->
      <div style="margin-top:12px">
        <div style="font-size:14px;font-weight:600;color:#475569;margin-bottom:6px">
          Notes
        </div>
        <div style="
          background:#f8fafc;
          border:1px solid #e5e7eb;
          border-left:4px solid #2563eb;
          padding:12px;
          border-radius:4px;
          font-size:14px;
          color:#0f172a;
          line-height:1.6
        ">
          ' . nl2br(h($notes ?: '—')) . '
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div style="
      padding:14px 24px;
      background:#f8fafc;
      border-top:1px solid #e5e7eb;
      font-size:12px;
      color:#64748b
    ">
      This email was generated automatically from the website enquiry form.<br>
      <strong>arabinfotec.com</strong>
    </div>

  </div>
</div>';

        $mail->send();
    }
} catch (Throwable $e) {
    error_log('Mail error: ' . $e->getMessage());
}

/* =========================================================
   FINAL RESPONSE
========================================================= */
exit;
