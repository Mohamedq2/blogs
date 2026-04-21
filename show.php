<?php require_once 'pdoconnection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/blog.css">
    <link rel="stylesheet" href="css/show.css">
    <!-- Start Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- End Font -->
</head>

<body>
    <!-- Start Navbar -->
    <nav class="navbar ">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/chat-messages-front-side-with-white-background.jpg" alt="blog" width="30" height="24">
            </a>
            <a class="flex-sm-fill text-sm-center nav-link" href="#">Home</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="#">Features</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="#">Contact</a>
            <?php
            session_start();
            if (!empty($_SESSION['user'])): ?>
                <a class="flex-sm-fill text-sm-center nav-link user" href="logout.php" title="logout">
                    Welcome<?= " " . $_SESSION['user']['user_name'] ?> <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            <?php endif; ?>
            <a class="flex-sm-fill text-sm-center nav-link active" href="index.php">Blog</a>
        </div>
    </nav>

    <!-- End Navbar -->
    <!-- Start Content -->
    <?php
    $stmt = $pdo->prepare("SELECT * FROM blogs where id = $_GET[id]");
    $stmt->execute();

    $blog = $stmt->fetch();
    ?>
    <div class="container mt-3">
        <p class="title"><strong>Title:</strong><?= " " .  $blog['title'] ?></p>
        <p class="short_desc"><strong>Short Description:</strong><?= " " . $blog['short_description'] ?></p>
        <div class="image ">
            <img src="<?= $blog['image'] ?>" alt="blog image" class="rounded">
        </div>
        <p class="desc mt-4"><strong>Content: </strong><?= " " . $blog['description'] ?></p>
    </div>
    <!-- End Content -->
    <!-- Start Footer -->
    <div class="footer container d-flex justify-content-between">
        <p>&copy; Dosth App, 2026</p>
        <ul class="foot d-flex list-unstyled justify-content-between">
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Press Kit</a></li>
            <li><a href="#">Privacy</a></li>
            <li><a class="active" href="#">About</a></li>
        </ul>
    </div>
    <!-- End Footer -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/all.min.js"></script>
</body>

</html>