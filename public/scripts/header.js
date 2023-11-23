let hamburger = document.querySelector('.nav .hamburger');
let icon = hamburger.querySelector('.ham-icon')
let right = document.querySelector('.nav .right')

let elementDropdown = document.querySelectorAll('.nav-element-drop');
hamburger.addEventListener('click',() =>{
    const isActive = right.classList.contains('active');
    right.classList.toggle('active', !isActive);
    icon.classList.replace(isActive ? 'fa-xmark' : 'fa-bars', isActive ? 'fa-bars' : 'fa-xmark');
})

for(let i = 0; i < elementDropdown.length; i++){
    elementDropdown[i].addEventListener('click',()=>{
        elementDropdown[i].classList.toggle('active');
        elementDropdown[i].querySelector('.dropdown-a').classList.toggle('active');
    })
}