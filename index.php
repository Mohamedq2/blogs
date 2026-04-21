<?php require_once 'pdoconnection.php';


if (isset($_POST['type']) && $_POST['type'] == "edit") {


    $imageQuery = '';
    if (!empty($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $uploadDir = 'images/';
        $imagePath = $uploadDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);


        $imageQuery = ', image = "' .   $imagePath . '"';
    }


    $sql = "UPDATE blogs set title = :title, short_description =:short_description, description =:description, dep_id = :dep_id $imageQuery where id =:id";


    $stmt = $pdo->prepare($sql);
    // print_r($_POST);
    $stmt->execute([
        ':title'   => $_POST['title'],
        ':short_description' => $_POST['short_description'],
        ':description' => $_POST['description'],
        ':id'      => $_POST['id'],
        ':dep_id' => $_POST['dep_id']
    ]);
    echo json_encode(['status' => true]);
    return;
}
if (isset($_POST['type']) && $_POST['type'] == "delete") {

    $sql = "DELETE FROM blogs where id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id'      => $_POST['id']
    ]);
    echo json_encode(['status' => true]);
    return;
}
if (isset($_POST['type']) && $_POST['type'] == "add_dep") {
    $stmt = $pdo->prepare("INSERT INTO department (dep_name) VALUES (:dep_name)");
    $stmt->execute([$_POST['dep_name']]);
}

if (isset($_POST['type']) && $_POST['type'] == "update_dep") {
    $stmt = $pdo->prepare("UPDATE department SET dep_name = :dep_name WHERE dep_id = :dep_id");
    $stmt->execute([$_POST['dep_name'], $_POST['dep_id']]);
}
if (isset($_POST['type']) && $_POST['type'] == "delete_dep") {

    $sql = "DELETE FROM department where dep_id = :dep_id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':dep_id'      => $_POST['dep_id']
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
    <!-- Start Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- End Font -->
</head>

<body>
    <!-- Start Navbar -->

    <nav class="navbar ">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/chat-messages-front-side-with-white-background.jpg" alt="blog" width="30" height="24">
            </a>
            <a class="flex-sm-fill text-sm-center nav-link " href="#">Home</a>
            <a class="flex-sm-fill text-sm-center nav-link " href="#">Features</a>
            <a class="flex-sm-fill text-sm-center nav-link " href="#">Contact</a>
            <?php
            session_start();
            if (!empty($_SESSION['user'])): ?>
                <a class="flex-sm-fill text-sm-center nav-link user" href="logout.php" title="logout">
                    Welcome<?= " " . $_SESSION['user']['user_name'] ?> <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            <?php endif; ?>
            <a class="flex-sm-fill text-sm-center nav-link active" href="add.php">Add</a>
        </div>
    </nav>
    <!-- End Navbar -->
    <!-- Start blog Word -->
    <p class="blogword">Blog</p>
    <!-- End blog Word -->

    <!-- Start content -->
    <div class="content">
        <div class="page d-flex mb-5 container justify-content-between">
            <div class="cards d-flex flex-wrap gap-3">
                <?php
                foreach ($blogs as $blog) {
                ?>
                    <!-- Start Card -->
                    <div class="card col-12 col-md-4" style="width: 18rem;" id="card_block<?= $blog['id'] ?>">
                        <p class="head"><?= $blog['title'] ?></p>
                        <img src="<?= $blog['image'] ?>" class="card-img-top" alt="">
                        <div class="text mt-3">
                            <p class="card-text"><a href="show.php?id=<?= $blog['id'] ?>"><?= $blog['short_description'] ?></a></p>
                            <div class="go d-flex justify-content-between align-items-center">

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#edit_modle_<?= $blog['id'] ?>" role="button">Edit</a></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#delete_modle_<?= $blog['id'] ?>" role="button">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                    <div class="modal fade" id="edit_modle_<?= $blog['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" id="editForm_<?= $blog['id'] ?>" method="post" class="mt-3">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="container">

                                            <div class="mb-3">
                                                <label for="dep_id" class="form-label">Department</label>
                                                <select name="dep_id" class="form-control">
                                                    <?php foreach ($departments as $dep): ?>

                                                        <option value="<?= $dep['dep_id'] ?>"
                                                            <?= ($dep['dep_id'] == $blog['dep_id']) ? 'selected' : '' ?>>

                                                            <?= $dep['dep_name'] ?>

                                                        </option>

                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Block Title" value="<?= $blog['title'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="short_description" class="form-label">Short Description</label>
                                                <textarea class="form-control" name="short_description" id="short_description" rows="3"><?= $blog['short_description'] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" id="description" rows="3"><?= $blog['description'] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" accept="image/*" name="image" class="form-control image" id="image"
                                                    placeholder="Block Title">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="type" value="edit">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" onclick="editPost(<?= $blog['id'] ?>)" class="btn btn-warning text-white">Save changes</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <?php

                    ?>
                    <div class="modal fade" id="delete_modle_<?= $blog['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button type="submit" name="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure, Delete this?
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post" class="mt-3">
                                        <!-- ال id اللي بستخدمه فى الحذف -->
                                        <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                        <input type="hidden" name="type" value="delete">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" onclick="deletePost(<?= $blog['id'] ?>)">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }

                ?>

            </div>
            <div class="search">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                </form>
                <div class="sidebar">
                    <h5 class="mt-5">Categories</h5>
                    <div class="list-group">
                        <!-- اذا ملقتش dep_id -->
                        <a href="http://localhost/blogs/index.php" class="list-group-item list-group-item-action <?= !isset($_GET['dep_id']) ? 'active' : '' ?>">

                            All
                        </a>
                        <?php
                        foreach ($departments as $department): ?>
                            <!-- اذا لقيت dep_id -->
                            <!-- ادي اكتيف للكلاس اللي نفس ال 
                            id -->

                            <div class="d-flex justify-content-between">
                                <a href="http://localhost/blogs/index.php?dep_id=<?= $department['dep_id'] ?>" class="list-group-item list-group-item-action <?= isset($_GET['dep_id']) && $_GET['dep_id'] ==  $department['dep_id'] ? 'active' : '' ?>">

                                    <?= $department['dep_name'] ?>
                                </a>
                                <button onclick="openEditModal(<?= $department['dep_id'] ?>, '<?= $department['dep_name'] ?>')" class="btn btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm" onclick="deleteDepartment(<?= $department['dep_id'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>

                        <button onclick="openAddModal()" class="list-group-item list-group-item-action ">
                            +Add
                            </a>
                    </div>
                    <!-- <h5 class="mt-5">Archives</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">September 2025</a></li>
                        <li><a href="#">August 2025</a></li>
                        <li><a href="#">July 2025</a></li>
                        <li><a href="#">June 2025</a></li>
                        <li><a href="#">May 2025</a></li>
                    </ul> -->
                </div>
                <div class="modal fade" id="depModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 id="modalTitle">Add Department</h5>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" id="dep_id">

                                <input type="text" id="dep_name" class="form-control" placeholder="Department Name">
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary" onclick="saveDepartment()">Save</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pages container">
            <nav aria-label="">
                <ul class="pagination ">
                    <li class="page-item"><a href="#" class="page-link">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#" aria-current="page">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
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
    <!-- ajax for delete & update -->
    <script>
        function deletePost(id) {
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + id + '&type=delete'
                })
                .then(data => {
                    // بيشيل الكارد من الصفحة من غير ما تتحدث
                    document.getElementById('card_block' + id).remove();
                    // بيقفل الـ modal
                    bootstrap.Modal.getInstance(document.getElementById('delete_modle_' + id)).hide();
                });
        }

        function editPost(id) {
            const file = document.body.querySelector('#editForm_' + id + ' .image');
            const savefile = file.files[0];

            if (savefile) {
                // ✅ Create object URL for preview
                const clonedFile = new File(
                    [savefile],
                    savefile.name, {
                        type: savefile.type
                    }
                );

                let imageUrl = URL.createObjectURL(clonedFile);

                document.body.querySelector('#card_block' + id + ' .card-img-top').src = imageUrl;
            }

            // ✅ Get the form
            let form = document.getElementById('editForm_' + id);

            // ✅ Collect form data
            let formData = new FormData(form);


            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(() => {
                    document.body.querySelector('#card_block' + id + ' .head').textContent = formData.get('title');
                    document.body.querySelector('#card_block' + id + ' .card-text a').textContent = formData.get('short_description');




                    // بيقفل الـ modal
                    bootstrap.Modal.getInstance(document.getElementById('edit_modle_' + id)).hide();
                });
        }
        // Update, Delete & Add Department
        function deleteDepartment(dep_id) {

            if (!confirm('Are you sure?')) return;

            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'dep_id=' + dep_id + '&type=delete_dep'
                })
                .then(() => location.reload());
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Add Department';
            document.getElementById('dep_id').value = '';
            document.getElementById('dep_name').value = '';

            new bootstrap.Modal(document.getElementById('depModal')).show();
        }

        function openEditModal(id, name) {
            document.getElementById('modalTitle').innerText = 'Edite Department';
            document.getElementById('dep_id').value = id;
            document.getElementById('dep_name').value = name;

            new bootstrap.Modal(document.getElementById('depModal')).show();
        }

        function saveDepartment() {
            let id = document.getElementById('dep_id').value;
            let name = document.getElementById('dep_name').value;

            let type = id ? 'update_dep' : 'add_dep';
            //  commit 2
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'dep_id=' + id + '&dep_name=' + name + '&type=' + type
                })
                .then(() => location.reload());
        }


        fetch('https://jsonplaceholder.typicode.com/posts/1')
            .then((response) => response.json())
            .then((json) => console.log(json));
    </script>
</body>

</html>




<!-- TODO: Register -->