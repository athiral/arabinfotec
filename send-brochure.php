<?php
/**
 * send-brochure.php
 * Handles brochure download requests:
 * - Validates input
 * - Sends email notification ONLY to athira@virtualsystechnologies.com
 * - No CRM connection
 * - Returns brochure download URL
 */
while (ob_get_level() > 0) {
    @ob_end_clean();
}
ob_start();

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(0);

// Autoload PHPMailer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function jsonResponse(bool $success, string $message, string $brochureUrl = '', int $code = 200): void {
    $data = [
        'success' => $success,
        'message' => $message
    ];
    if ($brochureUrl !== '') {
        $data['brochure_url'] = $brochureUrl;
    }
    $payload = json_encode($data);

    if (!headers_sent()) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('Content-Length: ' . strlen($payload));
        header('Connection: close');
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    echo $payload;

    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
    exit;
}

function cleanInput(string $v = ''): string {
    return trim($v);
}

function sanitizeHtml(string $v = ''): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// 1. Check Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method.', '', 405);
}

// 2. Origin Check
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = [
    'https://arabinfotec.com',
    'https://www.arabinfotec.com'
];

$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true) ||
           preg_match('/^https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?$/i', $origin);

if ($origin && !in_array($origin, $allowedOrigins, true) && !$isLocal) {
    jsonResponse(false, 'Forbidden origin.', '', 403);
}

// Brochure filename & URL
$brochureFileName   = '#1 Arabinfotec Company Profile 2026 - 2027.pdf';
$defaultBrochureUrl = '%231%20Arabinfotec%20Company%20Profile%202026%20-%202027.pdf';
$brochureEncodedUrl = !empty($_POST['brochure_url']) ? cleanInput($_POST['brochure_url']) : $defaultBrochureUrl;

// 3. Honeypot Check
if (!empty($_POST['hp_name'] ?? '')) {
    jsonResponse(true, 'Thank you! Redirecting to brochure...', $brochureEncodedUrl);
}

// 4. Timing Check (bot deterrent)
$formLoadedAt = (int) ($_POST['form_loaded_at'] ?? 0);
if ($formLoadedAt && (time() * 1000 - $formLoadedAt) < 1000) {
    jsonResponse(false, 'Submission too fast. Please try again.', '', 429);
}

// 5. Read Input
$name    = cleanInput($_POST['name'] ?? '');
$email   = cleanInput($_POST['email'] ?? '');
$phone   = preg_replace('/[^0-9+]/', '', cleanInput($_POST['phone'] ?? ''));
$company = cleanInput($_POST['company'] ?? '');
$message = cleanInput($_POST['message'] ?? '');

// 6. Validation
if (!$name || !$email) {
    jsonResponse(false, 'Please fill in all required fields (Name, Email).', '', 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Please provide a valid email address.', '', 400);
}

if ($phone && !preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
    jsonResponse(false, 'Please provide a valid phone number.', '', 400);
}

if (!$phone) {
    $phone = 'Not provided';
}

if (!$company) {
    $company = 'Not provided';
}

// Rate Limiting (IP + Phone)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ipFile    = sys_get_temp_dir() . '/brochure_ip_' . md5($ip);
$phoneFile = sys_get_temp_dir() . '/brochure_phone_' . md5($phone);

if (
    (file_exists($ipFile) && time() - filemtime($ipFile) < 10) ||
    (file_exists($phoneFile) && time() - filemtime($phoneFile) < 30)
) {
    jsonResponse(true, 'Thank you! Redirecting to brochure...', $brochureEncodedUrl);
}

@touch($ipFile);
@touch($phoneFile);

// 7. Email Dispatch (PHPMailer)
define('PRIMARY_RECIPIENT', 'hello@arabinfotec.com');

// CC recipients: athira@virtualsystechnologies.com
define('CC_EMAILS', [
    'athira@virtualsystechnologies.com'
    // Optional affiliate recipients:
    // 'info@arabinfotechllc.com',
    // 'sreechand@arabinfotechllc.com',
    // 'sreechand@vstbiz.com',
    // 'sangeeta@vstbiz.com',
    // 'praveen@vstbiz.com'
]);

define('SMTP_HOST', 'ded6951.inmotionhosting.com');
define('SMTP_USER', 'mailer@arabinfotec.com');
define('SMTP_PASS', '2uumwpFKXA8Y');
define('SMTP_PORT', 587);

$mailSent = false;

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

        $mail->setFrom(SMTP_USER, 'Arabinfotec Brochure');
        $mail->addAddress(PRIMARY_RECIPIENT);
        $mail->addReplyTo($email, $name);

        // CC to Athira and all affiliate recipients
        foreach (CC_EMAILS as $cc) {
            if ($cc !== PRIMARY_RECIPIENT && filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                $mail->addCC($cc);
            }
        }

        $mail->isHTML(true);
        $mail->Subject = 'Arabinfotec company brochure downloaded';

        $currentTime = date('d M Y, h:i A') . ' (UAE Time)';

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
    <div style="padding:22px 24px;background:linear-gradient(135deg,#261a38 0%,#3d255a 100%);color:#ffffff">
      <h2 style="margin:0;font-size:20px;font-weight:700;color:#ffffff">
        Arabinfotec company brochure downloaded
      </h2>
      <p style="margin:6px 0 0;font-size:13px;color:#d7b4dc">
        A website visitor has submitted their details and downloaded the company profile.
      </p>
    </div>

    <!-- Lead Details -->
    <div style="padding:24px">
      <table width="100%" cellpadding="8" cellspacing="0"
             style="border-collapse:collapse;font-size:14px">
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="width:36%;color:#475569;font-weight:600">Full Name</td>
          <td style="color:#0f172a;font-weight:600">' . sanitizeHtml($name) . '</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="color:#475569;font-weight:600">Work Email</td>
          <td style="color:#0f172a"><a href="mailto:' . sanitizeHtml($email) . '" style="color:#7c3aed;text-decoration:none">' . sanitizeHtml($email) . '</a></td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="color:#475569;font-weight:600">Phone / WhatsApp</td>
          <td style="color:#0f172a">' . sanitizeHtml($phone) . '</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="color:#475569;font-weight:600">Company Name</td>
          <td style="color:#0f172a">' . sanitizeHtml($company) . '</td>
        </tr>
        ' . ($message ? '<tr style="border-bottom:1px solid #f1f5f9"><td style="color:#475569;font-weight:600;vertical-align:top">Requirements / Notes</td><td style="color:#0f172a;white-space:pre-wrap">' . sanitizeHtml($message) . '</td></tr>' : '') . '
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="color:#475569;font-weight:600">Downloaded File</td>
          <td style="color:#0f172a;font-weight:500">' . sanitizeHtml($brochureFileName) . '</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="color:#475569;font-weight:600">Submission Time</td>
          <td style="color:#64748b">' . $currentTime . '</td>
        </tr>
        <tr>
          <td style="color:#475569;font-weight:600">IP Address</td>
          <td style="color:#64748b">' . sanitizeHtml($ip) . '</td>
        </tr>
      </table>
    </div>

    <!-- Footer -->
    <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;font-size:12px;color:#94a3b8">
      Sent from Arabinfotec Website &bull; Brochure Download System
    </div>
  </div>
</div>';

        $mail->AltBody = "Arabinfotec company brochure downloaded\n\n" .
                         "Full Name: {$name}\n" .
                         "Email: {$email}\n" .
                         "Phone: {$phone}\n" .
                         "Company: {$company}\n" .
                         ($message ? "Notes: {$message}\n" : '') .
                         "Downloaded File: {$brochureFileName}\n" .
                         "Time: {$currentTime}\n" .
                         "IP: {$ip}\n";

        $mail->send();
        $mailSent = true;
    }
} catch (Exception $e) {
    error_log('Brochure notification mail error: ' . $e->getMessage());
}

// 8. Return success response with brochure URL
jsonResponse(true, 'Thank you! Redirecting to brochure...', $brochureEncodedUrl);
