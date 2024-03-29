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
        <h1 class="h2 mb-0 text-center">Student</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-link text-decoration-none" data-ajax="teachers/students"><i class="fas fa-chevron-left"></i> Go back</a>
            <div class="card bg-blur">
                <div class="card-header card-profile d-flex">
                    <img src="<?= $student->profile_picture ?>" alt="">
                    <h5 class="my-1"><?= $student->display_name ?></h4>
                    <!-- remove btn -->
                    <button class="btn btn-danger ms-auto btn-sm" data-ajax="teachers/students/remove?id=<?= $student->id ?>"><i class="fas fa-user-minus"></i> Remove as student</button>
                </div>
                <div class="card-body">
                    <div><?= $student->real_name ?></div>
                    <div><?= $student->email ?></div>
                    <div class="mt-2">
                        <h5 class="my-1">Activity <button id="addBtn" class="btn btn-primary btn-sm">Add</button></h5>
                        <?php
                        echo $student->GetHtmlActivityList(true);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>