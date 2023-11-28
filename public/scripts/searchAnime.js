let filterBtn = document.querySelector('.form-search .filter-btn');
let filter = document.querySelector('.form-search .filter');

let choiceBox = document.querySelectorAll('.form-search .choice-list');

filterBtn.addEventListener('click', function () {
    filter.classList.toggle('active');
    filterBtn.classList.toggle('active');
});
document.addEventListener('click', function () {
    for (let i = 0; i < choiceBox.length; i++) {
        if (choiceBox[i].querySelector('.choice').contains(event.target)) {
            choiceBox[i].classList.add('active');
        } else if (choiceBox[i].querySelector('.choice-box').contains(event.target)) {
        } else {
            choiceBox[i].classList.remove('active');
        }
    }
});








