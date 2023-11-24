let listActiviteBtn = document.querySelectorAll('.activite .dot-btn button');
let listActiviteSlide = document.querySelectorAll('.carte-column');
let posActivite = 0;

const change = (i, listBtn, pos, listSlide) => {
    listBtn.forEach(btn => btn.classList.remove('active'));
    listSlide.forEach(slide => slide.classList.remove('active'));

    pos = i;

    listBtn[pos].classList.add('active');
    listSlide[pos].classList.add('active');
}

let intervalActivite = setInterval(() => {
    change((posActivite + 1) % listActiviteSlide.length, listActiviteBtn, posActivite, listActiviteSlide);
}, 10000);

for (let i = 0; i < listActiviteBtn.length; i++) {
    listActiviteBtn[i].addEventListener('click', () => {
        clearInterval(intervalActivite);
        change(i, listActiviteBtn, posActivite, listActiviteSlide);
        intervalActivite = setInterval(() => {
            change((posActivite + 1) % listActiviteSlide.length, listActiviteBtn, posActivite, listActiviteSlide);
        }, 10000);
    });
}

let listNewBtn = document.querySelectorAll('.anime-new .dot-btn button');
let listNewSlide = document.querySelectorAll('.anime-new .new');
let posNew = 0;

let intervalNew = setInterval(() => {
    change((posNew + 1) % listNewSlide.length, listNewBtn, posNew, listNewSlide);
}, 10000);

for (let i = 0; i < listNewBtn.length; i++) {
    listNewBtn[i].addEventListener('click', () => {
        clearInterval(intervalNew);
        change(i, listNewBtn, posNew, listNewSlide);
        intervalNew = setInterval(() => {
            change((posNew + 1) % listNewSlide.length, listNewBtn, posNew, listNewSlide);
        }, 10000);
    });
}
