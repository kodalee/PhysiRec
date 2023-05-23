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
            <div class="profile-picture">
                <img src="<?= $student->profile_picture ?>" alt="">
            </div>
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1"><?= $student->real_name ?></h4>
                    <div><?= $student->email ?></div>
                    <div><?= $student->display_name ?></div>
                    
        </div>
    </div>
</div>