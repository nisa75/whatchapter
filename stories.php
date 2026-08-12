
<?php

session_start();

require_once "database.php";



if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// Kullanıcıların paylaşımlarını getir
$sql = "SELECT
            posts.id,
            posts.title,
            posts.content,
            posts.created_at,
            users.username
        FROM posts

        INNER JOIN users
        ON posts.user_id = users.id

        ORDER BY posts.created_at DESC";


$result = $conn->query($sql);

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
        Stories - What Chapter
    </title>


    <!-- Google Fonts -->

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


        /* =========================
           NAVBAR
        ========================= */

        header {

            border-bottom: 1px solid #d8cec2;

            background: #f6f1e9;

        }


        .navbar {

            width: 90%;

            max-width: 1200px;

            height: 80px;

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

        }


        .nav-links {

            display: flex;

            align-items: center;

            gap: 32px;

        }


        .nav-links a {

            color: #6f6259;

            text-decoration: none;

            font-size: 14px;

            transition: 0.3s;

        }


        .nav-links a:hover {

            color: #493d35;

        }


        .nav-links .active {

            color: #493d35;

            font-weight: 500;

        }


        .logout {

            padding: 9px 20px;

            border: 1px solid #cbbcaf;

            border-radius: 30px;

        }


        .logout:hover {

            background: #e9dfd4;

        }



        /* =========================
           MAIN
        ========================= */

        .main {

            width: 90%;

            max-width: 850px;

            margin: auto;

            padding-top: 75px;

            padding-bottom: 100px;

        }



        /* =========================
           PAGE TITLE
        ========================= */

        .page-header {

            text-align: center;

            margin-bottom: 60px;

        }


        .page-header h1 {

            font-family: 'Playfair Display', serif;

            font-size: 50px;

            font-weight: 500;

            color: #493d35;

            margin-bottom: 15px;

        }


        .page-header p {

            max-width: 560px;

            margin: auto;

            color: #8b7d73;

            font-size: 14px;

            line-height: 1.8;

            font-weight: 300;

        }



        /* =========================
           STORY CARD
        ========================= */

        .story {

            display: block;

            text-decoration: none;

            color: inherit;

            background: #fbf8f3;

            border: 1px solid #ded4ca;

            border-radius: 16px;

            padding: 30px;

            margin-bottom: 22px;

            transition: 0.3s;

        }


        .story:hover {

            transform: translateY(-3px);

            box-shadow:
                0 12px 30px
                rgba(75, 64, 56, 0.07);

        }


        .author {

            font-size: 13px;

            color: #8b7d73;

            margin-bottom: 10px;

        }


        .story h2 {

            font-family: 'Playfair Display', serif;

            font-size: 27px;

            font-weight: 500;

            color: #493d35;

            margin-bottom: 14px;

        }


        .story-text {

            color: #6f6259;

            font-size: 15px;

            line-height: 1.8;

            font-weight: 300;

            margin-bottom: 22px;

        }


        .story-footer {

            display: flex;

            align-items: center;

            justify-content: space-between;

            border-top: 1px solid #e4dbd2;

            padding-top: 15px;

            color: #9a8c82;

            font-size: 12px;

        }


        .comments-link {

            color: #6f6259;

            font-weight: 500;

        }



        /* =========================
           EMPTY STORIES
        ========================= */

        .empty {

            text-align: center;

            padding: 80px 30px;

            background: #fbf8f3;

            border: 1px solid #ded4ca;

            border-radius: 16px;

        }


        .empty-title {

            font-family: 'Playfair Display', serif;

            font-size: 30px;

            color: #493d35;

            margin-bottom: 12px;

        }


        .empty-text {

            max-width: 450px;

            margin: auto;

            color: #8b7d73;

            font-size: 14px;

            line-height: 1.8;

        }



        /* =========================
           MOBILE
        ========================= */

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


            .main {

                padding-top: 50px;

            }


            .page-header h1 {

                font-size: 42px;

            }


            .story {

                padding: 24px;

            }


            .story-footer {

                gap: 15px;

                align-items: flex-start;

                flex-direction: column;

            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<header>

    <nav class="navbar">


        <div class="logo">

            What Chapter

        </div>


        <div class="nav-links">


            <a href="home.php">

                Home

            </a>


            <a
                href="stories.php"
                class="active"
            >

                Stories

            </a>


            <a href="profile.php">

                My Profile

            </a>


            <a
                href="logout.php"
                class="logout"
            >

                Log Out

            </a>


        </div>


    </nav>

</header>



<!-- =========================
     MAIN CONTENT
========================= -->

<main class="main">


    <section class="page-header">


        <h1>

            Stories

        </h1>


        <p>

            Every person is living a different chapter.
            Read the stories people choose to share.

        </p>


    </section>



    <?php if ($result && $result->num_rows > 0): ?>


        <!-- =========================
             REAL STORIES
        ========================= -->

        <?php while ($post = $result->fetch_assoc()): ?>


            <a
                href="post.php?id=<?php echo $post["id"]; ?>"
                class="story"
            >


                <p class="author">

                    <?php

                    echo htmlspecialchars(
                        $post["username"]
                    );

                    ?>

                </p>


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


                    <span>

                        <?php

                        echo date(
                            "d M Y",
                            strtotime(
                                $post["created_at"]
                            )
                        );

                        ?>

                    </span>


                    <span class="comments-link">

                        Read story & comments →

                    </span>


                </div>


            </a>


        <?php endwhile; ?>


    <?php else: ?>


        <!-- =========================
             NO STORIES YET
        ========================= -->

        <div class="empty">


            <h2 class="empty-title">

                No stories yet.

            </h2>


            <p class="empty-text">

                This space is waiting for someone's
                chapter to begin. Once people start
                sharing their stories, they will appear here.

            </p>


        </div>


    <?php endif; ?>


</main>


</body>

</html>
