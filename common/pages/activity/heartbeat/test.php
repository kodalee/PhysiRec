<div class="mx-2 p-2 mt-3">
    <div>
        <h1 class="h2 mb-0 text-center">Activity</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-blur">
                <div class="card-header text-center">
                    <h5 class="my-1">Heartbeat BPM Test</h4>
                </div>
                <div class="card-body">
                    <div>Welcome to the Heartbeat BPM Tester.</div>
                    <div class="mb-4">When you start the test, click the Heart OR tap the SPACE bar<div>

                    <a class="btn btn-secondary w-100" href="/complex.php/install/chromebook" data-ajax="install/chromebook"><i class="fa fa-laptop"></i> School Chromebook</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

return;
const startButton = document.getElementById("start-test");
const tapper = document.querySelector("#tapper");
const result = document.getElementById("result");

let count = 0;
let intervalId;

startButton.addEventListener("click", startTest);
tapper.addEventListener("click", tap);

function startTest() {
    count = 0;
    tapper.disabled = false;
    setTimeout(stopTest, 10000); // 10 seconds
}

function tap() {
    count++;
    const bpm = count * 6;
    result.innerHTML = `Estimated ~${bpm} bpm`;
}

function stopTest() {
  clearInterval(intervalId);
  tapper.disabled = true;
  const bpm = count * 6;
  result.innerHTML = `Estimated ~${bpm} bpm`;
}

    

</script>