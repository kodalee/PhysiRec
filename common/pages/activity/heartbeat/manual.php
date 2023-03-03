<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0 text-center">Activity</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-link text-decoration-none" data-ajax="activity/heartbeat"><i class="fas fa-chevron-left"></i> Back to instructions</a>
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1">Heartbeat BPM</h4>
                </div>
                <div class="card-body">
                    <div id="test-intro">
                        <div>Manually enter a BPM result.</div>
                        <div>Please give your health device 10 seconds to adjust to a proper heartrate before entering a result</div>

                        <div class="form-group d-flex mt-1">
                            <div class="form-input-label">
                                <input class="form-control" type="number" placeholder=" " id="bpm">
                                <label>Enter your BPM</label>
                            </div>
                        </div>

                        <div class="form-group d-flex my-1">
                            <select class="form-control" id="activity">
                                <option value="null">Select what you were doing...</option>
                                <option value="resting">Resting</option>
                                <option value="unrested">Unrested</option>
                            </select>
                        </div>
                        <button class="w-100 btn btn-primary" id="submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        const activity = document.querySelector("#activity");
        const submitButton = document.querySelector("#submit-btn");
        const bpm = document.querySelector("#bpm");
        submitButton.addEventListener("click", () => {
            if (activity.value == "null") {
                new swal({
                    color: "white",
                    background: "#171717",
                    "text": "Please select what your status when you checked your heartrate.",
                    "titleText": "Uh oh.",
                    "icon": "error"
                })
                return;
            }

            $.ajax({
                url: "/api/user/heartbeat",
                type: "POST",
                data: {bpm: bpm.value, activity: activity.value},
                success: function (response) {
                    console.log(response);
                    getPage("activity")
                },
                error: function (error) {
                    console.log(error);
                    new swal({
                        color: "white",
                        background: "#171717",
                        "text": "Failed to log activity, please try again.",
                        "titleText": "Uh oh.",
                        "icon": "error"
                    })
                }
            });
        });
    </script>