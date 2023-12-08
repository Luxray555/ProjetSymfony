
let searchControl = document.querySelector('.form-search .search-control');
let searchIcon = document.querySelector('.form-search .search-icon');
searchControl.addEventListener('focus', function () {
    searchIcon.classList.add('active');
});

searchControl.addEventListener('blur', function () {
    searchIcon.classList.remove('active');
});