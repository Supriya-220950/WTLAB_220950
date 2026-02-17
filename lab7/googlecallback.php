$code = $_GET['code'];

$response = file_get_contents("https://github.com/login/oauth/access_token?client_id=".$_ENV['GITHUB_CLIENT_ID']."&client_secret=".$_ENV['GITHUB_CLIENT_SECRET']."&code=$code");

parse_str($response,$data);
echo "GitHub Login Successful";
<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope("email");
$client->addScope("profile");

$login_url = $client->createAuthUrl();
?>
<a href="<?= $login_url ?>">Login with Google</a>
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDf4PBO9xb1jkLYmptJFUMgc5nUHdwKheE",
  authDomain: "smartcare-70916.firebaseapp.com",
  projectId: "smartcare-70916",
  storageBucket: "smartcare-70916.firebasestorage.app",
  messagingSenderId: "1009556509169",
  appId: "1:1009556509169:web:3394d3d88523d30824b450"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);