document.addEventListener('DOMContentLoaded', function () {
    let textarea = document.querySelector(".commentaire-textarea");
    let characterCount = document.querySelector(".character-count");
    let counter = document.querySelector(".counter");
    let maxCharacters = 500;
    let synopsis = document.querySelector('.synopsis');

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

    if (synopsis.clientHeight >= synopsis.querySelector('p').clientHeight) {
        synopsis.querySelector('button').classList.add('disabled');
    }

    addEventListener("resize", (event) => {
        if (synopsis.clientHeight < synopsis.querySelector('p').clientHeight) {
            synopsis.querySelector('button').classList.remove('disabled');
        }else{
            synopsis.querySelector('button').classList.add('disabled');
        }
    });

    synopsis.querySelector('button').addEventListener('click', function () {
        synopsis.classList.add('active');
    });

});