<?php
/**
 * download-brochure.php
 * Secure delivery controller for Arabinfotec Company Profile Brochure.
 * Only visitors who completed the brochure form with an active session can view/download.
 */

// 1. Session initialization
if (session_status() === PHP_SESSION_NONE) {
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path'     => '/',
        'domain'   => $cookieParams['domain'],
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// 2. Validate session permission & expiration
$hasAccess = !empty($_SESSION['brochure_access']) && $_SESSION['brochure_access'] === true;
$isExpired = isset($_SESSION['brochure_expires']) && time() > $_SESSION['brochure_expires'];

if (!$hasAccess || $isExpired) {
    // Unauthorized access: direct link copy, incognito, or expired session
    http_response_code(403);
    header('Location: index.php?brochure=unauthorized');
    exit('Access denied. Please submit the brochure request form first.');
}

// 3. Locate protected PDF file
$pdfPath = __DIR__ . '/protected/brochures/#1 Arabinfotec Company Profile 2026 - 2027.pdf';

if (!file_exists($pdfPath)) {
    http_response_code(404);
    exit('Brochure file could not be found.');
}

// 4. Clean any existing output buffers
while (ob_get_level() > 0) {
    @ob_end_clean();
}

// 5. Send secure PDF streaming headers
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Arabinfotec-Company-Profile-2026-2027.pdf"');
header('Content-Length: ' . filesize($pdfPath));
header('Cache-Control: private, no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Content-Type-Options: nosniff');
header('X-Robots-Tag: noindex, nofollow');

// 6. Stream file to client
readfile($pdfPath);
exit;
