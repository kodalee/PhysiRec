/**
 * Complex Application
 */
let AppHistory = []
let CurrentLocation = "dashboard"

var lastTouchEnd = 0;
var mainEl = $("main")[0];

function getUrlSegments(delimiter = null) {
    var urlBase = window.location.href.split("complex.php")[1];
    var urlSegments = urlBase.split("/");
    if (urlSegments[0] == '') {
        urlSegments.shift();
    }

    urlSegments = urlSegments.filter(seg => (seg.length != 0))
    console.log(urlSegments.filter(seg => (seg.length != 0)))

    if (delimiter != null) {
        return urlSegments;
    } else {
        return urlSegments.join("-")
    }
}

function modPage(appopts) {
    mainEl.classList[(appopts.show) ? "add" : "remove"]("page-shown");
    
    if ('html' in appopts) {
        mainEl.innerHTML = appopts.html;
    }

    if ('script' in appopts && appopts.script != null) {
        // Enclose the script in a Self-Invoke to prevent globals from being set.
        if (!appopts.script.includes(`"allow globals"`)) {
            console.log(1);
            eval( `(function(){${appopts.script}})();` );
        }
        else {
            console.log(0)
            eval( appopts.script );
        }
    }
 }

 var destNavbtns = {}
 var registeredDests = []
 
 function registerAjaxNav() {
     var _navi = document.querySelectorAll("[data-ajax]")
 
     
     _navi.forEach(navi => {
         if ("ajax" in navi.dataset) {
             var targetPage = navi.dataset["ajax"];
 
             if(!registeredDests.includes(targetPage)) {
                 registeredDests.push(targetPage)
             }
 
             if (navi.hasAttribute("href")) {
                 navi.setAttribute("href", `/complex.php/${targetPage}`)
             }
 
             navi.addEventListener("click", e => {
                 e.preventDefault();
                 getPage(targetPage);
                 console.log(`Requesting target page ${targetPage} from the remote server.`)
             })
 
             if (destNavbtns[targetPage]) {
                 destNavbtns[targetPage].push(navi)
             }
             else {
                 destNavbtns[targetPage] = [navi]
             }
 
 
             navi.removeAttribute("data-ajax")
         }
     })
 }

let REQUEST_FROM_POPSTATE = false;
window.onpopstate = ev => {
    if (ev.state) {
        REQUEST_FROM_POPSTATE = true;
        getPage(ev.state.loc);
    }
};

registerAjaxNav()

/**
 * Ajax method of getting page contents
 * @param {string} name 
 * @returns {void} Nothing
 */
function getPage(name) {
    if (name == "*back") {
        getPage(AppHistory[AppHistory.length-2])
        return;
    }
    if (!REQUEST_FROM_POPSTATE) {
        window.history.pushState({"loc": name}, "", `/complex.php/${name}`);
    }
    REQUEST_FROM_POPSTATE = false

    name = name.split("/")
    firstPart = name[0];
    name = name.join("-")

    desktopNavBtns.forEach(_dbn => {
        _dbn.classList.remove("active")
    })
    mobileNavBtns.forEach(_mbn => {
        _mbn.classList.remove("active")
    })

    if (destNavbtns[firstPart]) {
        destNavbtns[firstPart].forEach(elemnt => {
            if ((elemnt.classList.contains("nav-btn") || elemnt.classList.contains("nav-link")) && !elemnt.classList.contains("active")) {
                elemnt.classList.add("active");
            }
        })
    }

    CurrentLocation = name;    

    modPage({show: false})

    AppHistory.push(name);
    document.body.setAttribute("catagory", "null")

    $.get(`/api.php/app/page/${name}.json`)

    .then(data => {
        modPage({
            show: true,
            html: data.pageHtml,
            script: data.script
        })
        document.body.setAttribute("catagory", name)
        registerAjaxNav()
    })

    .catch(() => {
        modPage({
            show: true,
            html: `<div class="text-center"><h1 style="font-size: 800%;" class="m-5">404.</h1> <p>We don't know what you were looking for but we couldn't find it. Do you need help finding your way home?</p> <div><button data-ajax="dashboard" class="btn btn-primary w-25 mx-2">Yes, lets go!</button></div></div>`
        })
        registerAjaxNav()
    })

}



$(function() {
    var docBody = $("body")[0]
    docBody.classList.remove("not-shown");

    setTimeout(() => {
        docBody.classList.add("ambient-lighting")
    }, 500)


    segments = getUrlSegments("/")
    if (segments > 0) {
        getPage(segments.join("/"))
    }
    else {
        getPage("dashboard")
    }
    registerAjaxNav()
})

let preloadSounds = {};

const audioCtx = window.AudioContext || window.webkitAudioContext;
function unlockAudioContext(audioCtx) {
    if (audioCtx.state !== 'suspended') return;
    const b = document.body;
    const events = ['touchstart','touchend', 'mousedown','keydown'];
    events.forEach(e => b.addEventListener(e, unlock, false));
    function unlock() { audioCtx.resume().then(clean); }
    function clean() { events.forEach(e => b.removeEventListener(e, unlock)); }
}
unlockAudioContext(audioCtx)
  
function PlaySound(path) {
    // var AudioContext = window.AudioContext || window.webkitAudioContext;
    // var context = new AudioContext();

    // var curBuffer = void 0;
    // curBuffer = preloadSounds[path];

    // var source = context.createBufferSource();
    // source.buffer = curBuffer;
    // source.connect(context.destination);
    // source.start();

    var track = audioCtx.createMediaElementSource(preloadSounds[path]);
    track.connect(audioCtx.destination);
    preloadSounds[path].play();
}


// Handle phone scroll up refresh
var pStart = { x: 0, y: 0 };
var pStop = { x: 0, y: 0 };

function swipeStart(e) {
    if (typeof e["targetTouches"] !== "undefined") {
        var touch = e.targetTouches[0];
        pStart.x = touch.screenX;
        pStart.y = touch.screenY;
    } else {
        pStart.x = e.screenX;
        pStart.y = e.screenY;
    }
}

function swipeEnd(e) {
    if (typeof e["changedTouches"] !== "undefined") {
        var touch = e.changedTouches[0];
        pStop.x = touch.screenX;
        pStop.y = touch.screenY;
    } else {
        pStop.x = e.screenX;
        pStop.y = e.screenY;
    }

    swipeCheck();
}

function swipeCheck() {
    var changeY = pStart.y - pStop.y;
    var changeX = pStart.x - pStop.x;
    if (isPullDown(changeY, changeX)) {
        getPage( CurrentLocation )
        PlaySound("ui/refresh");
    }
}

function isPullDown(dY, dX) {
    // methods of checking slope, length, direction of line created by swipe action
    return (dY < 0 && ((Math.abs(dX) <= 100 && Math.abs(dY) >= 300) || (Math.abs(dX) / Math.abs(dY) <= 0.3 && dY >= 60)));
}

document.addEventListener("touchstart", function (e) {
    swipeStart(e);
}, false);

document.addEventListener('touchend', function (e) {
  var now = (new Date()).getTime();
  if (now - lastTouchEnd <= 300) {
    e.preventDefault();
  }
  lastTouchEnd = now;
  swipeEnd(e);
}, false);


document.addEventListener('touchmove', function (event) {
    if (event.scale !== 1) { event.preventDefault(); }
}, false);


document.querySelectorAll("btn,a").forEach(_btn => {
    _btn.addEventListener("click", () => {
        PlaySound("ui/tap")
    })
})

var desktopNavBtns = document.querySelectorAll("#sidebarMenu .nav-link");
desktopNavBtns.forEach(dbn => {
    dbn.addEventListener("click", () => {
        desktopNavBtns.forEach(_dbn => {
            _dbn.classList.remove("active")
        })
        dbn.classList.add("active")
    })
})

var mobileNavBtns = document.querySelectorAll(".nav-btn");
mobileNavBtns.forEach(mbn => {
    mbn.addEventListener("click", () => {
        mobileNavBtns.forEach(_mbn => {
            _mbn.classList.remove("active")
        })
        mbn.classList.add("active")
    })
});

$.get("/api.php/gauth/firsttime").then(res => {
    if (res.firsttime == null) {
        getPage("firstlogin")
    }
})

document.addEventListener("DOMContentLoaded", () => {
    if (!'back' in history) {
        history["back"] = (function(){history.go(-1)});
    }    
})