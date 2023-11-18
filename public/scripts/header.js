let hamburger = document.querySelector('.nav .hamburger');
let icon = hamburger.querySelector('.ham-icon')
let right = document.querySelector('.nav .right')
hamburger.addEventListener('click',() =>{
    console.log(hamburger);
    if(right.classList.contains('active')){
        right.classList.remove('active');
        icon.classList.replace('fa-xmark','fa-bars');
    }else{
        icon.classList.replace('fa-bars','fa-xmark');
        right.classList.add('active');
    }
})