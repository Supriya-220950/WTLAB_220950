$code = $_GET['code'];

$response = file_get_contents("https://github.com/login/oauth/access_token?client_id=".$_ENV['GITHUB_CLIENT_ID']."&client_secret=".$_ENV['GITHUB_CLIENT_SECRET']."&code=$code");

parse_str($response,$data);
echo "GitHub Login Successful";
