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
                    <p class="text-center h6 mb-4">What did you do today?</p>
                    <div class="activity top-sel">
                        <button>
                            <ico>🏃</ico><br>Movement
                        </button>
                        <button>
                            <ico>🏋️</ico><br>Lifting
                        </button>
                        <button>
                            <ico>❓</ico><br>Other
                        </button>
                    </div>
                    <div class="movement-form">
                        <div class="form-group d-flex">
                            <div class="form-input-label">
                                <input class="form-control" type="text" placeholder=" " id="actm-explain">
                                <label>Explain what you did in movement.</label>
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-input-label">
                                <input class="form-control" type="text" placeholder=" " id="actm-duration">
                                <label>For how long?</label>
                            </div>
                        </div>
                    </div>
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
                    <div class="bpm-history">
                        place date with bpm and scenario (188 bpm after running a mile on june 1st 2025)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var activityButtons = document.querySelectorAll(".activity.top-sel button");
        activityButtons.forEach(button => {
            button.addEventListener("click", ev => {
                activityButtons.forEach(_button => {
                    _button.classList.remove("active")
                })
                button.classList.add("active")
            })
        })

        let formattedDuration = new FormattedDuration(config = {
            hoursUnitString: " hrs ",
            minutesUnitString: " mins ",
            secondsUnitString: " secs "
        });

        let durationPickerMaker = new DurationPickerMaker(formattedDuration);
        durationPickerMaker.SetPickerElement(document.getElementById("actm-duration"), window, document);


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