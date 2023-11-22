let listBtn = document.querySelectorAll('.dot-btn button');
let listSlide = document.querySelectorAll('.carte-column');
let pos = 0;

let change = (i) => {
    listBtn[pos].classList.remove('active');
    listSlide[pos].classList.remove('active');
    pos = i;
    listBtn[pos].classList.add('active');
    listSlide[pos].classList.add('active');
}

let intervalActivite = setInterval(() => {
    change((pos + 1) % listBtn.length);
}, 10000);

for (let i = 0; i < listBtn.length; i++) {
    listBtn[i].addEventListener('click', () => {
        clearInterval(intervalActivite);
        change(i);
        intervalActivite = setInterval(() => {
            change((pos + 1) % listBtn.length);
        }, 10000);
    });
}