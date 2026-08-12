
<?php

session_start();

require_once "database.php";



if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


$user_id = $_SESSION["user_id"];

$message = "";



$sql = "SELECT
            username,
            email,
            profile_photo,
            bio
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

$stmt->close();



if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $username = trim($_POST["username"]);
    $bio = trim($_POST["bio"]);



    $profile_photo = $user["profile_photo"];


    if (
        isset($_FILES["profile_photo"]) &&
        $_FILES["profile_photo"]["error"] === UPLOAD_ERR_OK
    ) {


        $file = $_FILES["profile_photo"];


        $allowed_types = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];


        if (!in_array($file["type"], $allowed_types)) {

            $message = "Please upload a JPG, PNG or WEBP image.";

        } else {


            $extension = pathinfo(
                $file["name"],
                PATHINFO_EXTENSION
            );


            $new_name =
                "profile_" .
                $user_id .
                "_" .
                time() .
                "." .
                $extension;


            $upload_folder = "uploads/";


            
            if (!is_dir($upload_folder)) {

                mkdir($upload_folder, 0777, true);

            }


            $upload_path =
                $upload_folder .
                $new_name;


            if (move_uploaded_file(
                $file["tmp_name"],
                $upload_path
            )) {

                $profile_photo = $upload_path;

            } else {

                $message = "Could not upload the image.";

            }

        }

    }


    if ($message === "") {


        if ($username === "") {

            $message = "Username cannot be empty.";

        } else {



            $check_sql = "SELECT id
                          FROM users
                          WHERE username = ?
                          AND id != ?";

            $check_stmt =
                $conn->prepare($check_sql);

            $check_stmt->bind_param(
                "si",
                $username,
                $user_id
            );

            $check_stmt->execute();

            $check_result =
                $check_stmt->get_result();


            if ($check_result->num_rows > 0) {

                $message =
                    "This username is already taken.";

            }


            $check_stmt->close();

        }

    }



    if ($message === "") {


        $update_sql = "UPDATE users
                       SET username = ?,
                           bio = ?,
                           profile_photo = ?
                       WHERE id = ?";


        $update_stmt =
            $conn->prepare($update_sql);


        $update_stmt->bind_param(
            "sssi",
            $username,
            $bio,
            $profile_photo,
            $user_id
        );


        if ($update_stmt->execute()) {


            
            $_SESSION["username"] = $username;


            
            header("Location: profile.php");

            exit();


        } else {

            $message =
                "Something went wrong. Please try again.";

        }


        $update_stmt->close();

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
        Edit Profile - What Chapter
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

            padding: 40px 20px;

        }


        .container {

            width: 100%;

            max-width: 500px;

        }


        .logo {

            text-align: center;

            font-family: 'Playfair Display', serif;

            font-size: 25px;

            color: #665247;

            letter-spacing: 1px;

            margin-bottom: 45px;

        }


        .card {

            background: #fbf8f3;

            border: 1px solid #ded4ca;

            border-radius: 18px;

            padding: 40px;

        }


        h1 {

            font-family: 'Playfair Display', serif;

            font-size: 36px;

            font-weight: 500;

            color: #493d35;

            margin-bottom: 10px;

        }


        .subtitle {

            color: #8b7d73;

            font-size: 14px;

            line-height: 1.7;

            margin-bottom: 30px;

        }


        .message {

            padding: 12px 15px;

            margin-bottom: 20px;

            border-radius: 8px;

            background: #eee4da;

            color: #6b564a;

            font-size: 13px;

        }


        .photo-section {

            text-align: center;

            margin-bottom: 30px;

        }


        .current-photo {

            width: 110px;

            height: 110px;

            border-radius: 50%;

            overflow: hidden;

            background: #e9dfd4;

            border: 1px solid #d2c4b8;

            margin: 0 auto 15px;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .current-photo img {

            width: 100%;

            height: 100%;

            object-fit: cover;

        }


        .placeholder {

            font-family: 'Playfair Display', serif;

            font-size: 42px;

            color: #9b8678;

        }


        .file-label {

            display: inline-block;

            padding: 9px 18px;

            border: 1px solid #cbbcaf;

            border-radius: 30px;

            color: #6b564a;

            font-size: 13px;

            cursor: pointer;

            transition: 0.3s;

        }


        .file-label:hover {

            background: #e9dfd4;

        }


        #profile_photo {

            display: none;

        }


        .field {

            margin-bottom: 22px;

        }


        label {

            display: block;

            margin-bottom: 8px;

            color: #6b564a;

            font-size: 13px;

            font-weight: 500;

        }


        input[type="text"],
        textarea {

            width: 100%;

            padding: 14px 16px;

            border: 1px solid #d8cec2;

            border-radius: 10px;

            background: #fffdf9;

            color: #4b4038;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            outline: none;

        }


        input[type="text"]:focus,
        textarea:focus {

            border-color: #9b8678;

        }


        textarea {

            min-height: 130px;

            resize: vertical;

            line-height: 1.7;

        }


        .email {

            color: #9a8c82;

            font-size: 13px;

            margin-top: 7px;

        }


        .buttons {

            display: flex;

            gap: 12px;

            margin-top: 30px;

        }


        .save {

            flex: 1;

            padding: 14px;

            border: none;

            border-radius: 40px;

            background: #7a6254;

            color: #fffaf5;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            cursor: pointer;

            transition: 0.3s;

        }


        .save:hover {

            background: #654f43;

            transform: translateY(-2px);

        }


        .cancel {

            flex: 1;

            padding: 14px;

            border: 1px solid #cbbcaf;

            border-radius: 40px;

            background: transparent;

            color: #6b564a;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            text-align: center;

            text-decoration: none;

        }


        .cancel:hover {

            background: #e9dfd4;

        }


        @media (max-width: 600px) {

            .card {

                padding: 28px 22px;

            }

            h1 {

                font-size: 31px;

            }

            .buttons {

                flex-direction: column;

            }

        }

    </style>

</head>


<body>


<div class="container">


    <div class="logo">

        What Chapter

    </div>


    <div class="card">


        <h1>

            Edit your profile.

        </h1>


        <p class="subtitle">

            Update the little things that tell people
            who you are.

        </p>



        <?php if ($message !== ""): ?>


            <div class="message">

                <?php

                echo htmlspecialchars($message);

                ?>

            </div>


        <?php endif; ?>



        <form
            action=""
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- PROFILE PHOTO -->

            <div class="photo-section">


                <div class="current-photo">


                    <?php if (!empty($user["profile_photo"])): ?>


                        <img
                            src="<?php echo htmlspecialchars($user["profile_photo"]); ?>"
                            alt="Profile photo"
                        >


                    <?php else: ?>


                        <span class="placeholder">

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


                <label
                    for="profile_photo"
                    class="file-label"
                >

                    Change photo

                </label>


                <input
                    type="file"
                    id="profile_photo"
                    name="profile_photo"
                    accept="image/jpeg,image/png,image/webp"
                >


            </div>



            <!-- USERNAME -->

            <div class="field">


                <label for="username">

                    Username

                </label>


                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo htmlspecialchars($user["username"]); ?>"
                    maxlength="50"
                    required
                >


            </div>



            <!-- EMAIL -->

            <div class="field">


                <label>

                    Email

                </label>


                <p class="email">

                    <?php

                    echo htmlspecialchars(
                        $user["email"]
                    );

                    ?>

                </p>


            </div>



            <!-- BIO -->

            <div class="field">


                <label for="bio">

                    Bio

                </label>


                <textarea
                    id="bio"
                    name="bio"
                    maxlength="500"
                    placeholder="Tell people a little about yourself..."
                ><?php

                echo htmlspecialchars(
                    $user["bio"] ?? ""
                );

                ?></textarea>


            </div>



            <!-- BUTTONS -->

            <div class="buttons">


                <a
                    href="profile.php"
                    class="cancel"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    class="save"
                >

                    Save changes

                </button>


            </div>


        </form>


    </div>

</div>


</body>

</html>

