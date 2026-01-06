<?php
include("config/db.php");

$stmt = $pdo->prepare("SELECT username, displayname, bio, profile_pic, created_at, pronouns FROM users WHERE username = ?");
$stmt->execute([$profile_username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the profile user's follow count
// Following
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM follows WHERE `followed_user_username` = ?");
$stmt->execute([$profile_username]);
$following = $stmt->fetch(PDO::FETCH_ASSOC);

// Followers
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM follows WHERE `following_user_username` = ?");
$stmt->execute([$profile_username]);
$followers = $stmt->fetch(PDO::FETCH_ASSOC);
?>
?>

<pre>\n
<?php print_r($followers); ?>
</pre>

<form action="/actions/follow_action.php" method="POST">
    <input type="text" name="id">
    <button type="submit">Test</button>
</form>