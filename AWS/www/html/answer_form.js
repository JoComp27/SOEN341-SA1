// PURPOSE: Toggles the view that allows answer modification

function toggleModifyAnswerForm(id) {
    var modifyAnswerContainer = document.getElementById("modify-answer-" + id);

    if (modifyAnswerContainer.classList.contains("hidden")) {
        modifyAnswerContainer.classList.remove("hidden");

        var modifyAnswerForm = document.getElementById("modify-answer-form-" + id);
        var answerDescription = document.getElementById("answer-description-" + id).innerText;

        modifyAnswerForm.description.value = answerDescription;

    } else {
        modifyAnswerContainer.classList.add("hidden");
    }
}
