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

    let stars = document.querySelectorAll('.form-stars .star-box');
    for(let i = 0; i < stars.length; i++) {
        stars[i].querySelector('.star-box input[type="radio"]').addEventListener('change', function () {
            for(let j = 0; j < stars.length; j++) {
                stars[j].classList.remove('active');
            }
            for(let j = 0; j < i+1; j++) {
                stars[j].classList.add('active');
            }
        });
    }

});