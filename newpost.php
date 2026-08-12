
<?php

session_start();

require_once "database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {

        $message = "Please fill in all fields.";

    } else {

        $user_id = $_SESSION["user_id"];

        $stmt = $conn->prepare("
            INSERT INTO posts (user_id, title, content)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "iss",
            $user_id,
            $title,
            $content
        );

        if ($stmt->execute()) {

            header("Location: stories.php");
            exit;

        } else {

            $message = "Something went wrong. Please try again.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Share Your Chapter - What Chapter
</title>

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
    min-height: 100vh;

    background: #f6f1e9;

    color: #4b4038;

    font-family: 'DM Sans', sans-serif;
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

.logout {
    padding: 9px 20px;

    border: 1px solid #cbbcaf;

    border-radius: 30px;
}

.logout:hover {
    background: #e9dfd4;
}

.back {
    display: block;

    width: 90%;
    max-width: 650px;

    margin: 45px auto 0;

    color: #8b7d73;

    text-decoration: none;

    font-size: 13px;
}

.back:hover {
    color: #493d35;
}

.page-title {
    width: 90%;
    max-width: 650px;

    margin: 35px auto 12px;

    font-family: 'Playfair Display', serif;

    font-size: 42px;

    font-weight: 500;

    color: #493d35;
}

.subtitle {
    width: 90%;
    max-width: 650px;

    margin: 0 auto 35px;

    color: #8b7d73;

    font-size: 14px;

    line-height: 1.8;
}

.message {
    width: 90%;
    max-width: 650px;

    margin: 0 auto 20px;

    padding: 12px 15px;

    border-radius: 10px;

    background: #eee3d8;

    color: #7a6254;

    font-size: 13px;
}

form {
    width: 90%;
    max-width: 650px;

    margin: 0 auto 80px;

    background: #fbf8f3;

    border: 1px solid #ded4ca;

    border-radius: 18px;

    padding: 35px;
}

.field {
    margin-bottom: 25px;
}

.field label {
    display: block;

    margin-bottom: 9px;

    color: #5f5149;

    font-size: 13px;

    font-weight: 500;
}

.field input,
.field textarea {
    width: 100%;

    padding: 14px 16px;

    border: 1px solid #d8cec2;

    border-radius: 10px;

    background: #fffdf9;

    color: #4b4038;

    font-family: 'DM Sans', sans-serif;

    font-size: 14px;

    outline: none;

    transition: 0.3s;
}

.field input {
    height: 50px;
}

.field textarea {
    min-height: 250px;

    resize: vertical;

    line-height: 1.7;
}

.field input:focus,
.field textarea:focus {
    border-color: #9b8678;

    background: #ffffff;
}

.field input::placeholder,
.field textarea::placeholder {
    color: #aaa098;
}

.buttons {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 12px;

    margin-top: 10px;
}

.cancel {
    padding: 12px 22px;

    border: 1px solid #cbbcaf;

    border-radius: 30px;

    color: #6f6259;

    text-decoration: none;

    font-size: 13px;

    transition: 0.3s;
}

.cancel:hover {
    background: #e9dfd4;
}

.publish {
    padding: 13px 25px;

    border: none;

    border-radius: 30px;

    background: #7a6254;

    color: #fffaf5;

    font-family: 'DM Sans', sans-serif;

    font-size: 13px;

    cursor: pointer;

    transition: 0.3s;
}

.publish:hover {
    background: #654f43;

    transform: translateY(-2px);
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

    .back {
        margin-top: 35px;
    }

    .page-title {
        font-size: 35px;

        margin-top: 30px;
    }

    form {
        padding: 25px 20px;
    }

    .buttons {
        flex-direction: column-reverse;

        align-items: stretch;
    }

    .cancel,
    .publish {
        text-align: center;

        width: 100%;
    }

}

</style>

</head>

<body>

<nav class="navbar">

<div class="logo">
    What Chapter
</div>

<div class="nav-links">

<a href="home.php">
    Home
</a>

<a href="stories.php">
    Stories
</a>

<a href="profile.php">
    My Profile
</a>

<a href="logout.php" class="logout">
    Log Out
</a>

</div>

</nav>

<a
    href="home.php"
    class="back"
>
    ← Back to home
</a>

<h1 class="page-title">
    Share your chapter.
</h1>

<p class="subtitle">
    Write about where you are in life,
    what you're going through,
    or simply something you've been thinking about.
</p>

<?php if ($message != ""): ?>

<p class="message">
    <?php echo htmlspecialchars($message); ?>
</p>

<?php endif; ?>

<form
    action=""
    method="POST"
>

<div class="field">

<label for="title">
    Title
</label>

<input
    type="text"
    id="title"
    name="title"
    placeholder="Give your chapter a title..."
    maxlength="200"
    required
>

</div>

<div class="field">

<label for="content">
    Your story
</label>

<textarea
    id="content"
    name="content"
    placeholder="Write whatever feels right..."
    required
></textarea>

</div>

<div class="buttons">

<a
    href="home.php"
    class="cancel"
>
    Cancel
</a>

<button
    type="submit"
    class="publish"
>
    Publish chapter
</button>

</div>

</form>

</body>

</html>
