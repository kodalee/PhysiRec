<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h4 mb-0">Welcome back, %:name! 👋</h1>
    </div>
    <div>
        <h4 class="my-0">It's <span class="time text-primary">0:00 PM</span> on a <span
                class="text-primary today">Someday</span></h4>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header  text-center">
                    <h5 class="my-1">Message of the day</h4>
                </div>
                <div class="card-body" id="motdContainer">

                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header  text-center">
                    <h5 class="my-1">My latest activity</h4>
                </div>
                <div class="card-body">
                    It looks like you have done the following: %:latest_activity %:activity_last_update_time
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header  text-center">
                    <h5 class="my-1">Quick Dash</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary w-100" href="#" data-ajax="activity">Record my activity</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card bg-blur">
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
                </div>
            </div>
        </div>
    </div>
</div>