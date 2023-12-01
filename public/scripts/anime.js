document.addEventListener('DOMContentLoaded', function () {
    var textarea = document.querySelector(".commentaire-textarea");
    var characterCount = document.querySelector(".character-count");
    var counter = document.querySelector(".counter");
    var maxCharacters = 500;

    textarea.addEventListener('input', function () {
        var currentLength = textarea.value.length;
        characterCount.textContent = currentLength;

        if (currentLength >= maxCharacters) {
            textarea.value = textarea.value.substring(0, maxCharacters); // Tronquer le texte à la limite
            textarea.blur();
            counter.classList.add('exceeded-limit');
        } else {
            counter.classList.remove('exceeded-limit');
        }
    });

});