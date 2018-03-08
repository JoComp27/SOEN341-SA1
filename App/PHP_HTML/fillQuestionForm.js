// PURPOSE: Adds a function to the answers page where a question being modified will have its values autofilled

function fillForm() {
    //get form
    var questionForm = document.getElementById('question-form');

    // get question values
    var title = document.getElementById('question-title').innerText;
    var description = document.getElementById('question-description').innerText;

    // set form values
    questionForm.title.value = title;
    questionForm.details.value = description;
}

window.addEventListener("load", fillForm, false);
