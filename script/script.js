// timer for resend email verification code
var seconds=59;
var timer;
function myFunction() {
if(seconds < 60) { // I want it to say 1:00, not 60
    document.getElementById("timer").innerHTML = seconds;
}
if (seconds >0 ) { // so it doesn't go to -1
    seconds--;
} else {
    clearInterval(timer);
    document.getElementById("resend").innerHTML="<label> Click <a href='?i=resend'>Here</a> to resend verification code.</label>"; 
}
}

if(!timer) {
    timer = window.setInterval(function() { 
    myFunction();
    }, 1000); // every second
}

document.getElementById("resend").innerHTML="<label> Wait for <span id='timer'></span> seconds to resend.</label>";
document.getElementById("timer").innerHTML="60"; 
