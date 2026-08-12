
<?php

require_once "database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];


    if ($password !== $password_confirm) {

        $message = "Passwords do not match.";

    } else {


        

        $check_sql = "SELECT id FROM users WHERE email = ?";

        $check_stmt = $conn->prepare($check_sql);

        $check_stmt->bind_param("s", $email);

        $check_stmt->execute();

        $check_result = $check_stmt->get_result();


        if ($check_result->num_rows > 0) {

            $message = "An account with this email already exists.";

        } else {


        

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            

            $sql = "INSERT INTO users
                    (username, email, password)
                    VALUES (?, ?, ?)";


            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $hashed_password
            );


            if ($stmt->execute()) {

            

                header("Location: login.php?registered=1");
                exit();

            } else {

                $message = "Something went wrong. Please try again.";

            }


            $stmt->close();

        }


        $check_stmt->close();

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

<link rel="stylesheet" href="style.css">
    <title>
        Sign Up - What Chapter
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
        Start your story.
    </h1>


    <p class="subtitle">
        Create an account and share your chapter.
    </p>


    <form action="" method="POST">


        <?php if ($message != ""): ?>

            <p class="message">

                <?php echo htmlspecialchars($message); ?>

            </p>

        <?php endif; ?>


        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >


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


        <input
            type="password"
            name="password_confirm"
            placeholder="Confirm password"
            required
        >


        <button type="submit">
            Sign Up
        </button>


    </form>


    <p class="bottom-text">

        Already have an account?

        <a href="login.php">
            Log In
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
```
