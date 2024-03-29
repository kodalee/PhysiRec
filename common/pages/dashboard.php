<?php

use Physler\Session\SessionVisitor;
$user = SessionVisitor::GetActive()->GetVisitorUser();

?>
<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h4 mb-0">Welcome back, <?= $user->display_name ?>! 👋</h1>
    </div>
    <div>
        <h4 class="my-0">It's <span class="time text-primary">0:00 PM</span> on a <span
                class="text-primary today">Someday</span></h4>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card bg-blur ">
                <div class="card-header  text-center">
                    <h5 class="my-1">Message of the day</h4>
                </div>
                <div class="card-body" id="motdContainer">

                </div>
            </div>
            <div class="card bg-blur" hidefrom="installed">
                <div class="card-header text-center"><h5 class="my-1">Install PhysiRec</h5></div>
                <div class="card-body">
                    <div class="mb-1">Install PhysiRec on your computer or phone today for a much easier access.</div>
                    <div>
                        <button data-ajax="install" class="btn btn-warning w-100">Get started!</button>
                    </div>
                </div>
            </div>
            <div class="card bg-blur ">
                <div class="card-header  text-center">
                    <h5 class="my-1">Quick Dash</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary w-100 my-1" href="#" data-ajax="activity">Publish my activity</button>
                    <button class="btn btn-danger w-100 my-1" href="#" data-ajax="install">Record my heartbeat</button>
                    <button class="btn btn-success w-100 my-1" href="#" data-ajax="settings">Manage my account</button>
                    <button class="btn btn-secondary w-100 my-1" href="#" data-ajax="logout">Log out of PhysiRec</button>
                </div>
            </div>
            <div class="card bg-blur ">
                <div class="card-header text-center">
                    <h5 class="my-1">My activities today</h4>
                </div>
                <div class="card-body pt-0">
                    %:latest_activity %:activity_last_update_time
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="card bg-blur ">
                <div class="card-header text-center">
                    <h5 class="my-1">Peer activity</h4>
                </div>
                <div class="card-body pt-0">
                    <div>
                        What are your schoolmates doing? Maybe you can take inspiration!
                    </div>
                    <div class="text-warning">This is still being worked on but soon you will be able to view and share activity you've done. Activity shared is completely anonymous to other classmates and you are always given the option to share or hide activity from other students.</div>
                </div>
            </div>
            <div class="card bg-blur ">
                <div class="card-header text-center">
                    <h5 class="my-1">Suggestions</h4>
                </div>
                <div class="card-body pt-0">
                    <div>
                        PhysiRec is a big project for the GECS school in general, meaning you are the first of potentially many people to use this. Therefore, we would love to hear your suggestions on how to improve PhysiRec. If you have any suggestions, please click the button below. 
                    </div>
                </div>
            </div>
            <div class="card bg-blur ">
                <div class="card-header text-center">
                    <h5 class="my-1">About</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-1">
                        PhysiRec is an open-source project (free to use as you please) for students and teachers alike to track physical education of themselves or their students. If you're looking for more technical information, click the button below.
                    </div>
                    <button data-ajax="dev-info" class="btn btn-secondary w-100">Get development info</button>
                </div>
            </div>

            <!-- <div class="card bg-blur ">
                <div class="card-header  text-center">
                    <h5 class="my-1">My Goals</h4>
                </div>
                <div class="card-body goals">
                    <div class="card bg-blur w-100  daily">
                        <div class="card-body">
                            <div><span class="text-success">Daily Goal: </span>%:daily_goal_item</div>
                        </div>
                    </div>
                    <div class="card bg-blur w-100  weekly">
                        <div class="card-body">
                            <div><span class="text-warning">Weekly Goal: </span>%:weekly_goal_item</div>
                        </div>
                    </div>
                    <div class="card bg-blur w-100  monthly">
                        <div class="card-body">
                            <div><span class="text-danger">Monthly Goal: </span>%:monthly_goal_item</div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
    "allow globals";
    var _time = document.querySelector(".time");
    var _day = document.querySelector(".today")

    var _motdContainer = document.querySelector("#motdContainer")

    var dayCodes = [
        "Sunday",       // 0
        "Monday",       // 1
        "Tuesday",      // 2
        "Wednesday",    // 3
        "Thursday",     // 4
        "Friday",       // 5
        "Saturday"      // 6
    ];

    $.get("/api/app/motd/?day="+(new Date().getDay()))
    .then(data => {
        _motdContainer.innerHTML = data.message;
    })
    .catch(() => {
        _motdContainer.innerHTML = "Couldn't get the message of the day but still have a great day."
    })

    function UpdateTime() {
        _time.innerHTML = new Date().toLocaleTimeString("en-US", { hour: '2-digit', minute: '2-digit' });
        _day.innerHTML = dayCodes[new Date().getDay()]
    }

    setTimeout(UpdateTime, 1000);
    UpdateTime()
</script>