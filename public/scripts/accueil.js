function initializeSlider(buttonsSelector, slidesSelector) {
    const buttons = document.querySelectorAll(buttonsSelector);
    const slides = document.querySelectorAll(slidesSelector);
    let position = 0;
    let interval;

    function changeSlide(i) {
        buttons[position].classList.remove('active');
        slides[position].classList.remove('active');

        position = i;

        buttons[position].classList.add('active');
        slides[position].classList.add('active');
    }

    function startInterval() {
        interval = setInterval(() => {
            changeSlide((position + 1) % slides.length);
        }, 10000);
    }

    startInterval();

    buttons.forEach((button, i) => {
        button.addEventListener('click', () => {
            clearInterval(interval);
            changeSlide(i);
            startInterval();
        });
    });
}

initializeSlider('.activite .dot-btn button', '.carte-column');
initializeSlider('.anime-new .dot-btn button', '.anime-new .new');

