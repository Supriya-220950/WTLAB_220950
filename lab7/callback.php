<?php 
// ===== DEBUG (temporary) ===== 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 
// ====== LOAD .ENV ====== 
$envPath = __DIR__ . '/.env';  // from OAuth2.0/ go up to Itsmypage/ 
if (file_exists($envPath)) { 
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
foreach ($lines as $line) { 
if (str_starts_with(trim($line), '#')) continue; 
if (!str_contains($line, '=')) continue; 
[$name, $value] = explode('=', $line, 2); 
putenv(trim($name) . '=' . trim($value)); 
} 
} 
$CLIENT_ID = getenv('GOOGLE_CLIENT_ID'); 
$CLIENT_SECRET = getenv('GOOGLE_CLIENT_SECRET'); 
$REDIRECT_URI = getenv('GOOGLE_REDIRECT_URI'); 
if (!$CLIENT_ID || !$CLIENT_SECRET || !$REDIRECT_URI) { 
die("
❌
 Missing OAuth environment variables in .env file"); 
} 
// ================== OAUTH FLOW ================== 
if (!isset($_GET['code'])) { 
// Step 1: Redirect user to Google for login 
$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . 
http_build_query([ 
'client_id' => $CLIENT_ID, 
'redirect_uri' => $REDIRECT_URI, 
'response_type' => 'code', 
'scope' => 'openid email profile', 
'prompt' => 'select_account' 
]); 
header("Location: " . $auth_url); 
exit; 
} 
// Step 2: Google redirected back with code 
$code = $_GET['code']; 
// Step 3: Exchange code for access token 
$token_url = "https://oauth2.googleapis.com/token"; 
$post_fields = [ 
'code' => $code, 
'client_id' => $CLIENT_ID, 
'client_secret' => $CLIENT_SECRET, 
'redirect_uri' => $REDIRECT_URI, 
'grant_type' => 'authorization_code' 
]; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $token_url); 
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$response = curl_exec($ch); 
curl_close($ch); 
$token_data = json_decode($response, true); 
if (!isset($token_data['access_token'])) { 
echo "<pre>"; 
print_r($token_data); 
die("
❌
 Failed to get access token"); 
} 
$access_token = $token_data['access_token']; 
// Step 4: Get user info 
$userinfo_url = "https://www.googleapis.com/oauth2/v2/userinfo"; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $userinfo_url); 
curl_setopt($ch, CURLOPT_HTTPHEADER, [ 
"Authorization: Bearer " . $access_token 
]); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$userinfo = curl_exec($ch); 
curl_close($ch); 
$user = json_decode($userinfo, true); 
// Step 5: Show result 
echo "<h2>Login Successful 
✅
</h2>"; 
echo "<p><strong>Name:</strong> " . htmlspecialchars($user['name'] ?? '') . 
"</p>"; 
echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email'] ?? '') . 
"</p>"; 
if (!empty($user['picture'])) { 
echo "<img src='" . htmlspecialchars($user['picture']) . "' width='120'>"; 
} 
echo "<br><br><a href='index.html'>Go back to Home</a>"; 