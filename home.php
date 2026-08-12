
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Home - What Chapter</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">

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
}

header {
    width: 100%;
    border-bottom: 1px solid #d8cec2;
    background: #f6f1e9;
}

.navbar {
    width: 90%;
    max-width: 1200px;
    height: 85px;

    margin: auto;

    display: flex;
    align-items: center;
    justify-content: space-between;
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

.logout {
    padding: 9px 20px;
    border: 1px solid #cbbcaf;
    border-radius: 30px;
}

.logout:hover {
    background: #e9dfd4;
}

.main {
    width: 90%;
    max-width: 800px;
    margin: auto;

    padding-top: 75px;
    padding-bottom: 80px;
}

.welcome {
    text-align: center;
    margin-bottom: 45px;
}

.welcome h1 {
    font-family: 'Playfair Display', serif;
    font-size: 45px;
    font-weight: 500;
    color: #493d35;

    margin-bottom: 12px;
}

.welcome p {
    color: #8b7d73;
    font-size: 15px;
    font-weight: 300;
}

.share-container {
    text-align: center;
    margin-bottom: 80px;
}

.share-button {
    display: inline-block;

    text-decoration: none;

    background: #7a6254;
    color: #fffaf5;

    padding: 14px 32px;

    border-radius: 40px;

    font-size: 14px;

    transition: 0.3s;
}

.share-button:hover {
    background: #654f43;
    transform: translateY(-2px);
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 27px;
    font-weight: 500;

    color: #493d35;

    margin-bottom: 25px;
}

.post {
    background: #fbf8f3;

    border: 1px solid #ded4ca;

    border-radius: 16px;

    padding: 30px;

    margin-bottom: 22px;

    transition: 0.3s;
}

.post:hover {
    transform: translateY(-3px);

    box-shadow: 0 10px 30px rgba(75, 64, 56, 0.07);
}

.username {
    font-size: 13px;
    color: #8b7d73;

    margin-bottom: 10px;
}

.post h2 {
    font-family: 'Playfair Display', serif;

    font-size: 25px;
    font-weight: 500;

    color: #493d35;

    margin-bottom: 15px;
}

.post-content {
    color: #6f6259;

    font-size: 15px;
    line-height: 1.8;

    font-weight: 300;

    margin-bottom: 22px;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;

    border-top: 1px solid #e4dbd2;

    padding-top: 15px;

    color: #9a8c82;

    font-size: 12px;
}

.comments {
    color: #806f64;
}

@media (max-width: 700px) {

    .navbar {
        height: auto;
        padding: 20px 0;

        flex-direction: column;
        gap: 20px;
    }

    .nav-links {
        gap: 20px;
    }

    .main {
        padding-top: 55px;
    }

    .welcome h1 {
        font-size: 37px;
    }

    .post {
        padding: 24px;
    }

}

</style>

</head>

<body>

<header>

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

<a href="profile.php">
    My Profile
</a>

<a href="logout.php" class="logout">
    Log Out
</a>

</div>

</nav>

</header>

<main class="main">

<section class="welcome">

<h1>
    Welcome back, Nisa.
</h1>

<p>
    What chapter are you living today?
</p>

</section>

<div class="share-container">

<a href="newpost.php" class="share-button">
    + Share your chapter
</a>

</div>

<h2 class="section-title">
    Recent Stories
</h2>

<article class="post">

<p class="username">
    Elif
</p>

<h2>
    Learning to let go
</h2>

<p class="post-content">
    Sometimes growing means leaving behind
    the things you once thought you'd keep.
    I'm learning that letting go doesn't always
    mean losing something.
</p>

<div class="post-footer">

<span class="comments">
    💬 4 comments
</span>

<span>
    2 hours ago
</span>

</div>

</article>

<article class="post">

<p class="username">
    Mert
</p>

<h2>
    A new beginning
</h2>

<p class="post-content">
    I don't know where this chapter will take me,
    but for the first time I'm not afraid of
    not knowing.
</p>

<div class="post-footer">

<span class="comments">
    💬 2 comments
</span>

<span>
    Yesterday
</span>

</div>

</article>

<article class="post">

<p class="username">
    Zeynep
</p>

<h2>
    Twenty one
</h2>

<p class="post-content">
    Everyone keeps asking what I want to do
    with my life. Maybe I'm still figuring out
    who I want to be first.
</p>

<div class="post-footer">

<span class="comments">
    💬 6 comments
</span>

<span>
    2 days ago
</span>

</div>

</article>

</main>

</body>

</html>
```
