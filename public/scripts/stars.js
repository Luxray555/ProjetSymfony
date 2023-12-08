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
    stars[i].addEventListener('mouseover', function () {
        for(let j = 0; j < i+1; j++) {
            stars[j].classList.add('on');
        }
    });
    stars[i].addEventListener('mouseout', function () {
        for(let j = 0; j < stars.length; j++) {
            stars[j].classList.remove('on');
        }
    });
}