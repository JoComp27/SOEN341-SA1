// PURPOSE: Adds a function to a button which will hide or un-hide a question form if available

function check() {
    var questionFormButtons = document.getElementsByClassName("question-form-button");

    // convert collection to array to add events to all items
    Array.from(questionFormButtons).forEach(function (button) {
        button.addEventListener("click", function () {
            if (document.getElementById("question_field").classList.contains("hidden"))
                document.getElementById("question_field").classList.remove("hidden");
            else
                document.getElementById("question_field").classList.add("hidden");
        });
    })

}

window.addEventListener("load", check, false);
/**
 * Created by Jessica on 2017-04-17.
 */
