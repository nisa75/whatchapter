
<?php

session_start();

require_once "database.php";

$message = "";


/* Kayıt başarılı mesajı */

if (isset($_GET["registered"])) {
    $message = "Your account has been created. You can now log in.";
}


/* LOGIN FORMU GÖNDERİLDİ */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];


    /*
       USERS TABLOSUNDA BU EMAIL VAR MI?
    */

    $sql = "SELECT id, username, email, password
            FROM users
            WHERE email = ?";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        die("Database error: " . $conn->error);

    }


    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();


    /*
       EMAIL BULUNDU MU?
    */

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();


        /*
           ŞİFRE DOĞRU MU?
        */

        if (password_verify($password, $user["password"])) {


            /*
               KULLANICI BİLGİLERİNİ SESSION'A KAYDET
            */

            $_SESSION["user_id"] = $user["id"];

            $_SESSION["username"] = $user["username"];

            $_SESSION["email"] = $user["email"];


            /*
               HOME SAYFASINA GÖNDER
            */

            header("Location: home.php");

            exit();


        } else {

            $message = "cnm sifre yanlis bb";

        }


    } else {

        $message = "account yok askim";

    }


    $stmt->close();

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
<link rel="stylesheet" href="style.css">

    <title>
        Log In - What Chapter
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

            display: flex;

            justify-content: center;

            align-items: center;
        }


        .container {
            width: 90%;

            max-width: 430px;

            text-align: center;
        }


        .logo {
            font-family: 'Playfair Display', serif;

            font-size: 25px;

            color: #665247;

            letter-spacing: 1px;

            margin-bottom: 45px;
        }


        h1 {
            font-family: 'Playfair Display', serif;

            font-size: 42px;

            font-weight: 500;

            color: #493d35;

            margin-bottom: 12px;
        }


        .subtitle {
            font-size: 14px;

            color: #8b7d73;

            margin-bottom: 35px;
        }


        form {
            display: flex;

            flex-direction: column;

            gap: 16px;
        }


        input {
            width: 100%;

            padding: 15px 18px;

            border: 1px solid #d8cec2;

            border-radius: 10px;

            background: #fbf8f3;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            color: #4b4038;

            outline: none;
        }


        input:focus {
            border-color: #9b8678;
        }


        button {
            margin-top: 10px;

            padding: 15px;

            border: none;

            border-radius: 40px;

            background: #7a6254;

            color: #fffaf5;

            font-family: 'DM Sans', sans-serif;

            font-size: 15px;

            cursor: pointer;

            transition: 0.3s;
        }


        button:hover {
            background: #654f43;

            transform: translateY(-2px);
        }


        .message {
            margin-bottom: 5px;

            font-size: 13px;

            color: #9a5f50;
        }


        .success {
            color: #7a6254;
        }


        .bottom-text {
            margin-top: 30px;

            font-size: 13px;

            color: #8b7d73;
        }


        .bottom-text a {
            color: #6b564a;

            text-decoration: none;

            font-weight: 500;
        }


        .back {
            display: inline-block;

            margin-top: 25px;

            color: #8b7d73;

            text-decoration: none;

            font-size: 13px;
        }

    </style>

</head>


<body>


<div class="container">


    <div class="logo">
        What Chapter
    </div>


    <h1>
        Welcome back.
    </h1>


    <p class="subtitle">
        Continue your story.
    </p>


    <form
        action=""
        method="POST"
    >


        <?php if ($message != ""): ?>

            <p
                class="message
                <?php echo isset($_GET["registered"]) ? "success" : ""; ?>"
            >

                <?php echo htmlspecialchars($message); ?>

            </p>

        <?php endif; ?>


        <input
            type="email"
            name="email"
            placeholder="Email address"
            required
        >


        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >


        <button type="submit">
            Log In
        </button>


    </form>


    <p class="bottom-text">

        Don't have an account?

        <a href="register.php">
            Sign Up
        </a>

    </p>


    <a
        href="index.php"
        class="back"
    >
        ← Back to home
    </a>


</div>


</body>

</html>
