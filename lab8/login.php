$url = "https://github.com/login/oauth/authorize?client_id=".$_ENV['GITHUB_CLIENT_ID'];
echo "<a href='$url'>Login with GitHub</a>";
