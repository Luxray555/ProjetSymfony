// pp file selection
document.querySelector('.pp input').id = 'a';
document.querySelector('.pp .fichier-selection label').id = 'b';

// document.querySelector('.submit').id = 'submit';


//pp delete button
/* if (document.querySelector('.pp .vich-image div')) {
document.querySelector('.pp .vich-image div').id = 'delete-pp';
    document.querySelector('.pp .vich-image label').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>';
}
//remplacer le label par un svg
if (document.querySelector('.banner .vich-image div')) {
    document.querySelector('.banner .vich-image div').id = 'delete-banner';
    document.querySelector('.banner .vich-image label').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>';
} */

/* document.querySelector('#user_settings_avatar_ppImageFile_delete').onclick = function () {
    alert(document.querySelector('#user_settings_avatar_ppImageFile_delete').value);
} */

// banner file selection
document.querySelector('.banner input').id = 'c';
document.querySelector('.banner .fichier-selection label').id = 'd';

//lorsque l'on clique sur delete-pp on active le bouton submit
/* $("#delete-pp").click(function () {
    $("#delete-pp").trigger('click');
    $("#submit").trigger('click');
    location.reload();

}); */

/* $("#delete-banner").click(function () {
    document.querySelector('#user_settings_avatar_ppImageFile_delete').value = '0';
    $("#submit").trigger('click');

}); */

$("#b").click(function () {
    $("#a").trigger('click');
});

$(document).ready(function() {
    $("#a").change(function(e) {
        var file = e.target.files[0].name;
        if (file.length > 15) {
            // si le nom du fichier est trop long, on le coupe et on ajoute '...' et l'extension
            file = file.substring(0, 15) + '...' + file.substring(file.lastIndexOf('.'));
        }
        $("#pp-text-file").text(file);
    });
});

$("#d").click(function () {
    $("#c").trigger('click');
});

$(document).ready(function() {
    $("#c").change(function(e) {
        var file = e.target.files[0].name;
        // si le nom du fichier est trop long, on le coupe et on ajoute '...' et l'extension
        if (file.length > 15) {
            file = file.substring(0, 15) + '...' + file.substring(file.lastIndexOf('.'));
        }
        $("#banner-text-file").text(file);
    });
});