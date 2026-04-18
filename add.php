<?php require_once 'pdoconnection.php' ?>
<?php

if (isset($_POST['submit'])) {

    // 1. خد البيانات من الفورم
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $description = $_POST['description'];
    $dep_id = $_POST['dep_id'];
    $image = $_FILES['image']['name'];

    $uploadDir = 'images/';
    $imagePath = $uploadDir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);


    $sql = "INSERT INTO blogs (title, short_description, description, image, dep_id) 
                VALUES (:title, :short_description, :description, :image, :dep_id)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':title'      => $title,
        ':short_description' => $short_description,
        ':description'       => $description,
        ':dep_id'       => $dep_id,
        ':image'      => $imagePath

    ]);
    
}
?>
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
    <link rel="stylesheet" href="css/add.css">
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
            <a class="flex-sm-fill text-sm-center nav-link" href="#">More</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="index.php">Blog</a>
        </div>
    </nav>
    <!-- End Navbar -->
    <!-- Start Form -->
    <form action="#" method="post" class="mt-3" enctype="multipart/form-data" ">
        <div class="container">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Block Title">
            </div>
                <div class="mb-3">
                <label for="title" class="form-label">Category</label>
                <select class="form-control" name="dep_id">
                    <option value="">select department</option>
                    <?php 
                    foreach($departments as $department): ?>
                    <option value="<?= $department['dep_id'] ?>"><?= $department['dep_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea class="form-control" name="short_description" id="short_description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" accept="image/*" name="image" class="form-control" id="image"
                    placeholder="Block Title">
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" class="form-control" id="submit">
            </div>
        </div>
    </form>
    <!-- End Form -->
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