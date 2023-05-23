<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0">Activity</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1">Record my activity</h4>
                </div>
                <div class="card-body">
                    <p class="text-center h6 mb-3">What did you do today?</p>
                    <div class="activity top-sel mb-1">
                        <button data-name="movement">
                            <ico><i class="fad fa-person-running"></i></ico><br>Movement
                        </button>
                        <button data-name="muscles">
                            <ico><i class="fad fa-dumbbell"></i></ico><br>Muscles
                        </button>
                        <button data-name="other">
                            <ico><i class="fad fa-comment-dots"></i></ico><br>Other
                        </button>
                    </div>
                    <div class="movement-form mt-1 d-none">
                        <div class="form-group d-flex">
                            <select class="form-control mt-1" id="movement-type">
                                <option value="null">Type</option>
                                <option value="walked">Normal Walk</option>
                                <option value="briskly walked">Brisk Walking</option>
                                <option value="jogged">Jogging</option>
                                <option value="ran">Running</option>
                                <option value="sprinted">Sprinting</option>
                            </select>
                        </div>
                        <div class="form-group d-flex my-1">
                            <div class="form-input-label ms-1">
                                <input class="form-control" type="number" placeholder=" " id="movement-distance">
                                <label>How far? (miles)</label>
                            </div>
                        </div>
                    </div>
                    <div class="muscles-form my-1 d-none">
                        <div class="form-group d-flex">
                            <div class="form-input-label me-1">
                                <input class="form-control" type="number" placeholder=" " id="muscle-sets">
                                <label>How many sets?</label>
                            </div>
                            <div class="form-input-label ms-1">
                                <input class="form-control" type="number" placeholder=" " id="muscle-weight">
                                <label>How much lb?</label>
                            </div>
                        </div>
                        <div class="form-group d-flex mt-1">
                            <div class="form-input-label">
                                <input class="form-control" type="text" placeholder=" " id="muscle-machine">
                                <label>What station was this?</label>
                            </div>
                        </div>
                    </div>
                    <div class="main-form my-1">
                        <div class="form-group d-flex">
                            <div class="form-input-label">
                                <input class="form-control" type="text" placeholder=" " id="activity-explain" readonly>
                                <label>Explain your activity.</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex flex-column">
                        <select class="form-control my-1" id="activity-duration">
                            <option value="null">How long?</option>
                            <option value="1500">less than 45 minutes</option>
                            <option value="2700">45 minutes or more</option>
                            <option value="7200">around 2 hours</option>
                            <option value="10800">around 3 hours</option>
                            <option value="14400">around 4 hours</option>
                            <option value="18000">even more hours</option>
                        </select>
                        <div class="form-input-label">
                            <input class="form-control my-1" id="activity-time" type="datetime-local">
                            <label>When was this?</label>
                        </div>
                    </div>
                    <div>
                        <button class="btn-secondary btn w-100 mt-1 ms-auto" id="btn-activity-record">Log</button>
                    </div>
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
        <div class="col-md-6 ">
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1">My heartbeat</h4>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <button class="btn-danger btn w-100" data-ajax="activity/heartbeat" interactive>Log my current heart
                            beat</button>
                    </div>
                    <div class="bpm-history mt-1">
                        %:heartbeat_log

                    </div>
                </div>
            </div>
            <div class="card bg-blur ">
                <div class="card-header text-center">
                    <h5 class="my-1">Activity demographics</h4>
                </div>
                <div class="card-body pt-0">
                    <div>
                        Get information on how you compare to your classmates.
                    </div>
                    <div class="text-warning">We are still working on this feature but soon you will be able to view how you compare to your classmates in terms of activity.</div>
                </div>
            </div>

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
        </div>
    </div>
</div>

<script>
    (function() {
        const e_tern = (variable, empty_replacement) => {
            switch (typeof variable) {
                case "string":
                    return (variable.length > 0) ? ((variable != "null") ? variable : empty_replacement) : empty_replacement;
                case "number":
                    return (variable != null) ? variable : null;
                default:
                    throw new Error(`Failure to evaluate variable as a string or number! Instead got "${typeof variable}"`)
            }

        }


        var activityButtons = document.querySelectorAll(".activity.top-sel button");
        var activitySelected = null;
        activityButtons.forEach(button => {
            button.addEventListener("click", ev => {
                activityButtons.forEach(_button => {
                    _button.classList.remove("active")
                })
                button.classList.add("active")
                activitySelected = button.dataset["name"]
                console.log(activitySelected)

                switch (activitySelected) {
                    case "muscles":
                        muscles.form.classList.remove("d-none")
                        movement.form.classList.add("d-none")
                        main.explain.readOnly = true
                        break;
                    case "movement":
                        muscles.form.classList.add("d-none")
                        movement.form.classList.remove("d-none")
                        main.explain.readOnly = true
                        break;
                    default:
                        muscles.form.classList.add("d-none")
                        movement.form.classList.add("d-none")
                        main.explain.readOnly = false
                        break;
                }
            })
        })

        const muscles = {
            sets: document.querySelector("#muscle-sets"),
            weight: document.querySelector("#muscle-weight"),
            machine: document.querySelector("#muscle-machine"),
            form: document.querySelector(".muscles-form")
        }

        const movement = {
            type: document.querySelector("#movement-type"),
            distance: document.querySelector("#movement-distance"),
            form: document.querySelector(".movement-form")
        }

        const main = {
            explain: document.querySelector("#activity-explain"),
            duration: document.querySelector("#activity-duration"),
            time: document.querySelector("#activity-time")
        }

        document.querySelector("#btn-activity-record").addEventListener("click", ev => {
            var validForm = true;
            if (activitySelected == null) {
                validForm = false;
                new swal({
                    color: "white",
                    background: "#171717",
                    "text": "Please select an activity type.",
                    "titleText": "Uh oh.",
                    "icon": "error"
                })
                return;
            }

            Object.keys(muscles).forEach(n => {
                if (activitySelected != "muscles" || n == "form") {
                    return
                };
                if (muscles[n].value == null || muscles[n].value == "null" || muscles[n].value == "") {
                    validForm = false;
                }
            })

            Object.keys(movement).forEach(n => {
                if (activitySelected != "movement" || n == "form") {
                    return
                };
                if (movement[n].value == null || movement[n].value == "null" || movement[n].value == "") {
                    validForm = false;
                }
            })

            if (main.explain.value == null || main.explain.value == "null" || main.explain.value == "") {
                validForm = false;
            }

            if (main.duration.value == null || main.duration.value == "null" || main.duration.value == "") {
                validForm = false;
            }

            if (main.time.value == null || main.time.value == "null" || main.time.value == "") {
                validForm = false;
            }

            if (!validForm) {
                new swal({
                    color: "white",
                    background: "#171717",
                    "text": "Please check for empty fields.",
                    "titleText": "Uh oh.",
                    "icon": "error"
                })
                return;
            }

            var info = {
                activity: activitySelected,
                explanation: main.explain.value,
                duration: main.duration.value,
                time: new Date(main.time.value).getTime() / 1000
            }


            $.ajax({
                url: "/api/user/activities/",
                type: "POST",
                data: info,
                success: function(data) {
                    console.log(data)
                    new swal({
                        color: "white",
                        background: "#171717",
                        "text": "Successfully logged your activity.",
                        "titleText": "Logged",
                        "icon": "success",
                        confirmButtonText: "Dismiss",
                        confirmButtonColor: "#252525",
                        showCancelButton: false,
                        cancelButtonText: "Share activity",
                        cancelButtonColor: "#00aa00",
                    }).then(() => {
                        getPage("activity")
                    })
                }
            })

            console.log(info)
        })

        main.time.addEventListener("input", () => {
            c_time_interfered = true;
        })

        c_time_interfered = false;
        main.time.min = Date.now() - 1209600000;
        setInterval(() => {
            if (!c_time_interfered) {
                main.time.valueAsNumber = new Date(Date.now());
            }
        }, 1000)

        Object.keys(muscles).forEach(n => {
            muscles[n].addEventListener("input", () => {
                main.explain.value = `I did ${e_tern(muscles.sets.value, "_")} set(s) of ${e_tern(muscles.weight.value, "_")}lb on ${e_tern(muscles.machine.value, "at an undisclosed station.")}`;
            })
        })

        Object.keys(movement).forEach(n => {
            movement[n].addEventListener("input", () => {
                main.explain.value = `I ${e_tern(movement.type.value, "_______")} for ${e_tern(movement.distance.value, "__")} mile(s).`;
            })
        })

        // let formattedDuration = new FormattedDuration(config = {
        //     hoursUnitString: " hrs ",
        //     minutesUnitString: " mins ",
        //     secondsUnitString: " secs "
        // });

        // let durationPickerMaker = new DurationPickerMaker(formattedDuration);
        // durationPickerMaker.SetPickerElement(document.getElementById("activity-duration"), window, document);


        /*
                let pickerElement = document.getElementById("duration_picker_field");
                let receiverLabel = document.getElementById("output_label");
                class LabelWrapperReceiver {
                    constructor(labelElement) {
                        this.labelElement = labelElement;
                    }
                    setSecondsValue(value) {
                        this.labelElement.textContent = value;
                    }
                }
                let labelWrapperReceier = new LabelWrapperReceiver(receiverLabel);
                let formattedDuration = new FormattedDuration(config = {
                    // options here
                });
                let durationPickerMaker = new DurationPickerMaker(formattedDuration);
                durationPickerMaker.AddSecondChangeObserver(labelWrapperReceier);
                durationPickerMaker.SetPickerElement(pickerElement, window, document);

        */
    })()
</script>