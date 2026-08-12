
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>What Chapter</title>

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

    display: flex;
    flex-direction: column;
}

header {
    width: 100%;

    padding: 35px 0;
}

.logo {
    width: 90%;
    max-width: 1100px;

    margin: auto;

    font-family: 'Playfair Display', serif;

    font-size: 26px;

    color: #665247;

    letter-spacing: 1px;
}

.hero {
    width: 90%;
    max-width: 800px;

    margin: auto;

    text-align: center;

    padding: 90px 0 80px;
}

.hero h1 {
    font-family: 'Playfair Display', serif;

    font-size: 52px;

    line-height: 1.2;

    font-weight: 500;

    color: #493d35;

    margin-bottom: 25px;
}

.intro {
    max-width: 560px;

    margin: auto;

    color: #8b7d73;

    font-size: 15px;

    line-height: 1.8;

    font-weight: 300;
}

.buttons {
    display: flex;

    justify-content: center;

    gap: 15px;

    margin-top: 40px;
}

.buttons a {
    display: inline-block;

    padding: 13px 30px;

    border-radius: 40px;

    text-decoration: none;

    font-size: 14px;

    transition: 0.3s;
}

.login {
    background: #7a6254;

    color: #fffaf5;
}

.login:hover {
    background: #654f43;

    transform: translateY(-2px);
}

.register {
    background: transparent;

    color: #6b564a;

    border: 1px solid #cbbcaf;
}

.register:hover {
    background: #e9dfd4;

    transform: translateY(-2px);
}

.bottom {
    width: 90%;
    max-width: 700px;

    margin: auto;

    padding: 35px 0 50px;

    text-align: center;

    border-top: 1px solid #ded4ca;
}

.bottom p {
    color: #9a8c82;

    font-size: 13px;

    line-height: 1.8;

    font-weight: 300;
}

@media (max-width: 700px) {

    header {
        padding: 25px 0;
    }

    .logo {
        text-align: center;
    }

    .hero {
        padding: 65px 0 60px;
    }

    .hero h1 {
        font-size: 38px;
    }

    .intro {
        font-size: 14px;
    }

    .buttons {
        flex-direction: column;

        align-items: center;
    }

    .buttons a {
        width: 180px;

        text-align: center;
    }

}

</style>

</head>

<body>

<header>

<div class="logo">
    What Chapter
</div>

</header>

<main class="hero">

<h1>
    What chapter of your life are you in?
</h1>

<p class="intro">
    Every life has its chapters.
    Share the one you're living right now,
    and discover the stories of others.
</p>

<div class="buttons">

<a href="login.php" class="login">
    Log In
</a>

<a href="register.php" class="register">
    Sign Up
</a>

</div>

</main>

<section class="bottom">

<p>
    This is a space to share the experiences, thoughts,
    memories and moments that shape your life.
    Whether you're starting something new, going through
    a difficult time, finding yourself, or simply living
    an ordinary day, you can share it here.
</p>

</section>

</body>

</html>

