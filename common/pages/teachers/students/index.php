<?php

use Physler\Session\SessionVisitor;

$user = SessionVisitor::GetActive()->GetVisitorUser();

?>

<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0">Students</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header">
                    <h5 class="mt-1 mb-0">Your students</h4>
                        <p class="m-0">View activity, information, and other demographics of your students.</p>
                </div>
                <div class="card-body">
                    <div class="student-body">
                        <?php
                        $students = $user->GetStudents();

                        foreach ($students as $student) {
                        ?>
                            <a class="student-row" data-ajax="teachers/students/view?id=<?= $student->id ?>">
                                <div class="student-avatar">
                                    <img src="<?= $student->profile_picture ?>" alt="">
                                </div>
                                <div class="student-name">
                                    <div><?= $student->real_name ?></div>
                                    <small class="text-muted">melissa@gecs.org</small>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-blur">
                <div class="card-header">
                    <h5 class="my-1">Add managed student</h4>
                    <div>Add a student by entering their school-assigned email address.</div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="form-input-label">
                            <input class="form-control" type="number" placeholder=" " id="muscle-sets">
                            <label>Email Address</label>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="button" id="addBtn">Add</button>
                    <span class="w-100 text-right">When a student is added, data collected from them will be shared with you.</span>
                </div>
            </div>
        </div>
    </div>
</div>