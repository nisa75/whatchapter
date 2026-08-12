<?php
session_start();

require_once "database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT id, username, email, profile_photo, bio
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: logout.php");
    exit;
}

$post_stmt = $conn->prepare("
    SELECT id, title, content
    FROM posts
    WHERE user_id = ?
    ORDER BY id DESC
");

$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();

$posts = $post_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>My Profile - What Chapter</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap"
    rel="stylesheet"
>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f6f1e9;
    color: #4b4038;
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
}

.navbar {
    width: 90%;
    max-width: 1200px;
    height: 85px;

    margin: auto;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #d8cec2;
}

.logo {
    font-family: 'Playfair Display', serif;
    font-size: 25px;
    color: #665247;
    letter-spacing: 1px;
    text-decoration: none;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 35px;
}

.nav-links a {
    text-decoration: none;
    color: #6f6259;
    font-size: 14px;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #493d35;
}

.nav-links .active {
    color: #493d35;
}

.logout {
    padding: 9px 20px;
    border: 1px solid #cbbcaf;
    border-radius: 30px;
}

.logout:hover {
    background: #e9dfd4;
}

.profile {
    width: 90%;
    max-width: 800px;

    margin: 70px auto 55px;

    text-align: center;

    background: #fbf8f3;

    border: 1px solid #ded4ca;

    border-radius: 18px;

    padding: 40px 30px;

    box-shadow: 0 10px 30px rgba(75, 64, 56, 0.05);
}

.profile-photo {
    width: 120px;
    height: 120px;

    margin: 0 auto 20px;

    border-radius: 50%;

    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e9dfd4;

    border: 3px solid #d8cec2;
}

.profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-placeholder {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    color: #7a6254;
}

.profile .username {
    font-family: 'Playfair Display', serif;

    font-size: 34px;

    font-weight: 500;

    color: #493d35;

    margin-bottom: 12px;
}

.bio {
    max-width: 550px;

    margin: 0 auto 25px;

    color: #7f7168;

    font-size: 14px;

    line-height: 1.8;
}

.no-bio {
    font-style: italic;
    color: #a3968d;
}

.edit-button {
    display: inline-block;

    padding: 11px 24px;

    border-radius: 30px;

    background: #7a6254;

    color: #fffaf5;

    text-decoration: none;

    font-size: 13px;

    transition: 0.3s;
}

.edit-button:hover {
    background: #654f43;
    transform: translateY(-2px);
}

.stories-section {
    width: 90%;
    max-width: 800px;

    margin: 0 auto 80px;
}

.stories-title {
    font-family: 'Playfair Display', serif;

    font-size: 29px;

    font-weight: 500;

    color: #493d35;

    margin-bottom: 25px;
}

.story {
    display: block;

    text-decoration: none;

    background: #fbf8f3;

    border: 1px solid #ded4ca;

    border-radius: 16px;

    padding: 28px 30px;

    margin-bottom: 20px;

    transition: 0.3s;
}

.story:hover {
    transform: translateY(-3px);

    box-shadow: 0 10px 30px rgba(75, 64, 56, 0.07);
}

.story h2 {
    font-family: 'Playfair Display', serif;

    font-size: 24px;

    font-weight: 500;

    color: #493d35;

    margin-bottom: 13px;
}

.story-text {
    color: #6f6259;

    font-size: 14px;

    line-height: 1.8;

    margin-bottom: 20px;
}

.story-footer {
    border-top: 1px solid #e4dbd2;

    padding-top: 14px;
}

.read {
    color: #806f64;

    font-size: 12px;
}

.empty {
    text-align: center;

    padding: 45px 25px;

    background: #fbf8f3;

    border: 1px solid #ded4ca;

    border-radius: 16px;
}

.empty h3 {
    font-family: 'Playfair Display', serif;

    font-size: 23px;

    font-weight: 500;

    color: #493d35;

    margin-bottom: 10px;
}

.empty p {
    color: #8b7d73;

    font-size: 13px;
}

@media (max-width: 700px) {

    .navbar {
        height: auto;

        padding: 20px 0;

        flex-direction: column;

        gap: 20px;
    }

    .nav-links {
        gap: 18px;

        flex-wrap: wrap;

        justify-content: center;
    }

    .profile {
        margin-top: 50px;

        padding: 30px 20px;
    }

    .profile .username {
        font-size: 29px;
    }

    .stories-section {
        margin-top: 40px;
    }

    .story {
        padding: 24px;
    }

}

</style>

</head>

<body>

<nav class="navbar">

<a href="home.php" class="logo">
    What Chapter
</a>

<div class="nav-links">

<a href="home.php">
    Home
</a>

<a href="stories.php">
    Stories
</a>

<a href="profile.php" class="active">
    My Profile
</a>

<a href="logout.php" class="logout">
    Log Out
</a>

</div>

</nav>

<main>

<section class="profile">

<div class="profile-photo">

<?php if (!empty($user["profile_photo"])): ?>

<img
    src="<?php echo htmlspecialchars($user["profile_photo"]); ?>"
    alt="Profile photo"
>

<?php else: ?>

<span class="profile-placeholder">

<?php

echo htmlspecialchars(
    strtoupper(
        substr(
            $user["username"],
            0,
            1
        )
    )
);

?>

</span>

<?php endif; ?>

</div>

<h1 class="username">

<?php

echo htmlspecialchars(
    $user["username"]
);

?>

</h1>

<?php if (!empty($user["bio"])): ?>

<p class="bio">

<?php

echo nl2br(
    htmlspecialchars(
        $user["bio"]
    )
);

?>

</p>

<?php else: ?>

<p class="bio no-bio">
    No bio yet.
</p>

<?php endif; ?>

<a
    href="editprofile.php"
    class="edit-button"
>
    Edit Profile
</a>

</section>

<section class="stories-section">

<h2 class="stories-title">
    My Stories
</h2>

<?php if ($posts->num_rows > 0): ?>

<?php while ($post = $posts->fetch_assoc()): ?>

<a
    href="post.php?id=<?php echo $post["id"]; ?>"
    class="story"
>

<h2>

<?php

echo htmlspecialchars(
    $post["title"]
);

?>

</h2>

<p class="story-text">

<?php

$short_content = mb_strimwidth(
    $post["content"],
    0,
    280,
    "..."
);

echo nl2br(
    htmlspecialchars(
        $short_content
    )
);

?>

</p>

<div class="story-footer">

<span class="read">
    Read story →
</span>

</div>

</a>

<?php endwhile; ?>

<?php else: ?>

<div class="empty">

<h3>
    No stories yet.
</h3>

<p>
    Your stories will appear here when you share them.
</p>

</div>

<?php endif; ?>

</section>

</main>

</body>

</html>

