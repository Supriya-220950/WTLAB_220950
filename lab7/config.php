<?php
/**
 * SmartCare Lab4 - Configuration File
 * Database and application settings
 */

// ==================== DATABASE CONFIGURATION ====================
define('DB_HOST', 'localhost');
define('DB_NAME', 'smartcare_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// ==================== APPLICATION SETTINGS ====================
define('APP_NAME', 'SmartCare Healthcare Management System');
define('APP_VERSION', '4.0.0');
define('APP_ENV', 'development'); // development, staging, production

// ==================== FILE UPLOAD SETTINGS ====================
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx']);

// ==================== SESSION SETTINGS ====================
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'smartcare_session');

// ==================== SECURITY SETTINGS ====================
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 6);
define('LOGIN_ATTEMPTS_MAX', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// ==================== EMAIL SETTINGS ====================
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'noreply@smartcare.com');
define('SMTP_PASS', ''); // Would be set in production

// ==================== API SETTINGS ====================
define('API_BASE_URL', 'https://api.smartcare.com/v1/');
define('API_KEY', 'your_api_key_here');

// ==================== LOGGING SETTINGS ====================
define('LOG_DIR', 'logs/');
define('LOG_LEVEL', 'INFO'); // DEBUG, INFO, WARNING, ERROR

// ==================== TIMEZONE SETTINGS ====================
date_default_timezone_set('Asia/Kolkata');

// ==================== ERROR REPORTING ====================
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ==================== UTILITY FUNCTIONS ====================

/**
 * Sanitize user input
 */
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Log messages
 */
function logMessage($message, $level = 'INFO') {
    $logFile = LOG_DIR . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;

    if (!is_dir(LOG_DIR)) {
        mkdir(LOG_DIR, 0777, true);
    }

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

/**
 * Require login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get current user info
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['user_username'],
            'role' => $_SESSION['user_role'],
            'name' => $_SESSION['user_name']
        ];
    }
    return null;
}

/**
 * Check user role
 */
function hasRole($role) {
    return isLoggedIn() && $_SESSION['user_role'] === $role;
}

/**
 * Format file size
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

/**
 * Validate file upload
 */
function validateFileUpload($file) {
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return 'File size exceeds maximum limit';
    }

    // Check file extension
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExt, ALLOWED_EXTENSIONS)) {
        return 'File type not allowed';
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'File upload error';
    }

    return true;
}

// ==================== INITIALIZATION ====================

// Start session with custom settings
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
    session_name(SESSION_NAME);
    session_start();
}

// Initialize application
logMessage('Application initialized - ' . APP_NAME . ' v' . APP_VERSION);

?>