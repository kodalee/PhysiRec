<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0 text-center">Activity</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-link text-decoration-none" data-ajax="activity"><i class="fas fa-chevron-left"></i> Back to activity</a>
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1">Heartbeat BPM Test</h4>
                </div>
                <div class="card-body">
                    <div>Welcome to the Heartbeat BPM Tester.</div>
                    <div class="mb-3">This test works by calculating your heart's BPM (beats per minute) through your pulse. You can find your pulse at your wrist, your neck or you can use a smart health device like an Apple Watch.</div>
                    <div class="mb-5">
                        <div class="mb-1">
                            Wrist Pulse: Place two fingers (your index and middle finger) between the bone and the tendon over your radial artery which is located on the thumb side of your wrist. Once you feel a beating/tapping sensation, you are ready to begin the test. Click/Tap everytime you feel the pulse until the test concludes.
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Pulse_%28Wrist%29.png/440px-Pulse_%28Wrist%29.png" style="width: 250px;margin: 0 auto;display: block;box-shadow: 0 0 20px 0px white;border-radius: 20px;">
                        <div class="text-center small">An illustration depicting a person checking their pulse via wrist.</div>
                    </div>
                    <div class="mb-5">
                        <div class="mb-1">
                            Neck Pulse: Place two fingers (your index and middle finger) just under your jaw and beside your windpipe. Press your skin lightly to feel your pulse. Once you feel a beating/tapping sensation, you are ready to begin the test. Click/Tap everytime you feel the pulse until the test concludes.
                        </div>
                        <img style="width: 250px;margin: 0 auto;display: block;box-shadow: 0 0 20px 0px white;border-radius: 20px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Pulse_%28Neck%29.png/247px-Pulse_%28Neck%29.png">
                        <div class="text-center small">An illustration depicting a person checking their pulse via neck</div>
                    </div>
                    <div class="mb-5">
                        <div class="mb-1">
                            Manual entry by using Apple Watch. If you have an Apple Watch or something simular, you can go into Manual Entry instead of having to do the BPM tap test.
                        </div>
                        <img style="width: 250px;margin: 0 auto;display: block;" src="https://support.apple.com/library/content/dam/edam/applecare/images/en_US/applewatch/watchos-8-series8-heart-rate.png">
                        <div class="text-center small"><a href="https://support.apple.com/en-us/HT204666" target="_blank">Apple Watch | &copy; 2023 Apple Inc</a></div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-success w-100 me-1" data-ajax="activity/heartbeat/test">Start BPM Test</button>
                        <button class="btn btn-danger w-100 ms-1" data-ajax="activity/heartbeat/manual">Manual Entry</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>