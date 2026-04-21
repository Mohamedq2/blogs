<?php require_once 'pdoconnection.php' ?>
<?php

$message = '';
$message1 = '';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt_users = $pdo->prepare("select count(*) as users_count from users where email = '$email'");
    $stmt_users->execute();
    $users = $stmt_users->fetch();
    if ($users['users_count'] > 0) {
        $message = 'That email is already registed';
    } else {
        if (strlen($_POST['phone']) !== 11 || !is_numeric($_POST['phone'])) {
            $message1 = '* This number is wrong.';
        } else {
            $user_name = $_POST['username'];
            $phone_number = $_POST['phone'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $password = $_POST['password'];
            $stmt_users = $pdo->prepare("INSERT INTO users (user_name, phone_number, email, password, gender) 
                VALUES (:user_name, :phone_number, :email, :password, :gender)");

            $stmt_users->execute([
                ':user_name'      => $user_name,
                ':phone_number' => $phone_number,
                ':email'       => $email,
                ':password'       => $password,
                ':gender'      => $gender

            ]);
            header("Location: login.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
    <!-- Start Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- End Font -->
</head>

<body class="d-flex justify-content-between align-items-center ">
    <div class="register m-auto rounded p-4  ">
        <div class="image d-flex justify-content-center" style="height: fit-content;">
            <img src="images/chat-messages-front-side-with-white-background.jpg" width="30px" height="24px" class="" alt="" srcset="">
        </div>
        <!-- Start Form -->
        <form action="#" method="post" class="mt-3" enctype="multipart/form-data" ">
            <div class=" mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="User Name">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" name="phone" class="form-control" id="phone" placeholder="+20 Phone Number">
        <?php if (!empty($message1)): ?>
            <p class="danger"><?= $message1 ?></p>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            name="email"
            id="email"
            aria-describedby="emailHelpId"
            placeholder="abc@mail.com" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
            <button class="btn" type="button" onclick="togglePassword()">
                <i class="fa-regular fa-eye" id="eyeIcon"></i>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Gender</label>
        <select class="form-control" name="gender">
            <option value="">select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div class="mb-3 text-center">
        <?php if (!empty($message)): ?>
            <p class="alert alert-danger"><?= $message ?></p>
        <?php endif; ?>
        <button type="submit" class="btn btn-warning text-white">Sign Up</button>
        <a href="login.php" rel="noopener noreferrer" class="m-auto" style="display: block;">Login</a>
    </div>
    </form>
    <!-- End Form -->
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>