<?php

use Physler\User\User;

if (!isset($_GET["id"])) {
    header("Location: /teachers/students");
    exit;
}
$student = User::GetById($_GET["id"]);
if ($student == false) {
    header("Location: /teachers/students");
    exit;
}
?>
<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0 text-center">Remove a Student</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-link text-decoration-none" data-ajax="teachers/students/view?id=<?= $student->id ?>"><i class="fas fa-chevron-left"></i> Go back</a>
            <div class="card bg-blur">
                <div class="card-header card-profile d-flex">
                    <div class="me-1">Remove </div>
                    <img src="<?= $student->profile_picture ?>" alt="">
                    <h5 class="my-1"><?= $student->display_name ?></h4>
                </div>
                <div class="card-body">
                    <div>Are you sure you want to remove <?= $student->display_name ?> as your student?</div>
                </div>
            </div>
        </div>
    </div>
</div>