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
                    <h5 class="my-1">Heartbeat BPM Test</h4>
                </div>
                <div class="card-body">
                    <div id="test-intro">
                        <div>Welcome to the Heartbeat BPM Tester.</div>
                        <div>When you start the test, click the Heart OR tap the SPACE bar</div>
                        <div>After the test, you will also enter what you were doing before you started the test.</div>

                        <button class="btn btn-success w-100 mt-1" id="start-test">Begin the test</button>
                    </div>
                    <div id="test-window" class="text-center d-none">
                        <button class="heart w-100 mb-1" id="tapper"><i class="fa fa-heart"></i></button>
                        <div>Tap the heart when you feel a beat.</div>
                        <div class="text-secondary small" id="duration">10 second(s) left</div>
                    </div>
                    <div id="test-results" class="d-none">
                        <div>Your BPM test has finished with an estimated <span id="result"></span></div>
                        <div class="form-group d-flex my-1">
                            <select class="form-control" id="activity">
                                <option value="null">Select what you were doing...</option>
                                <option value="resting">Resting</option>
                                <option value="unrested">Unrested</option>
                            </select>
                        </div>
                        <button class="w-100 btn btn-primary" id="submit-btn">Submit</button>
                        <canvas id="chartContainer" style="width: 100%; display: block; box-sizing: border-box;" ></canvas>
                    </div>
                    <div id="test-failure" class="d-none">
                        <div>Your BPM test has finished with an estimated <span id="failed-result" class="text-danger"></span></div>
                        <div>When conducting your test, we found that your results are inconclusive and may not be used as a sample. You might have a heart condition, please contact a doctor.</div>
                        <div class="mt-1">
                            Remember, this is just a tool to help you keep track of your heart rate. It is not a replacement for a doctor and should not be treated as such, and it may have been possible you did not conduct the test correctly. Please refer to the instructional page or have a teacher or parent help you.
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        const activity = document.querySelector("#activity");
        const submitButton = document.querySelector("#submit-btn");
        const startButton = document.querySelector("#start-test");
        const tapper = document.querySelector("#tapper");
        const result = document.querySelector("#result");
        const duration = document.querySelector("#duration");
        const failedResult = document.querySelector("#failed-result");

        let count = 0, countSingleSecond = 0, timeleft = 10, intervalId;

        startButton.addEventListener("click", startTest);
        tapper.addEventListener("click", tap);

        console.log("dont ignore this!")

        function startTest() {
            document.querySelector("#test-intro").classList.add("d-none");
            document.querySelector("#test-window").classList.remove("d-none");
            count = 0;
            intervalId = setInterval(() => {
                timeleft--;
                duration.innerHTML = `${timeleft} second(s) left`;
                heartbeats.push(countSingleSecond);
                countSingleSecond = 0;
                if (timeleft <= 0) {
                    stopTest();
                }
            }, 1000);
        }

        const ctx = document.getElementById("chartContainer");
        var heartbeats = [];
        var cont = {
            labels: ["1sec", "2sec", "3sec", "4sec", "5sec", "6sec", "7sec", "8sec", "9sec", "10sec"],
            datasets: [
                {
                    label: "Your heart's BPS",
                    data: heartbeats,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: "Average resting BPS",
                    data: [1, 1, 1, 2, 1, 2, 2, 1, 1, 1],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                },
                {
                    label: "Average running BPS",
                    data: [3, 2, 3, 3, 3, 4, 4, 3, 3, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                }
            ]
        };

        function tap() {
            count++; countSingleSecond++;
            const bpm = count * 6;
            result.innerHTML = `${bpm} beats per minute`;
        }

        function stopTest() {
            clearInterval(intervalId);
            const bpm = count * 6;

            let mainChart = new Chart(ctx, {
                type: 'line',
                data: cont,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    animations: {
                        tension: {
                            duration: 500,
                            delay: 1000,
                            easing: 'ease',
                            to: 0,
                            from: 1
                        }
                    }
                }
            });

            duration.innerHTML = `Test concluded`;

            if (bpm > 250 || bpm < 60) {
                failedResult.innerHTML = `${bpm} beats per minute`;
                document.querySelector("#test-failure").classList.remove("d-none");
                return;
            }
            else {
                result.innerHTML = `${bpm} beats per minute`;
                document.querySelector("#test-results").classList.remove("d-none");
                return;
            }
        }

        submitButton.addEventListener("click", () => {
            const bpm = count * 6;

            if (activity.value == "null") {
                new swal({
                    color: "white",
                    background: "#171717",
                    "text": "Please select what your status was when you conducted this test.",
                    "titleText": "Uh oh.",
                    "icon": "error"
                })
                return;
            }

            $.ajax({
                url: "/api/user/heartbeat",
                type: "POST",
                data: {bpm, activity: activity.value},
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