function check() {
    document.getElementById("ask").addEventListener("click", function(){
        if(document.getElementById("question_field").classList.contains("hidden"))
            document.getElementById("question_field").classList.remove("hidden");
        else
            document.getElementById("question_field").classList.add("hidden");
    });
}
function check2() {
    document.getElementById("copy").classList.remove("hidden");
}
window.addEventListener( "load", check, false);/**
 * Created by Jessica on 2017-04-17.
 */
