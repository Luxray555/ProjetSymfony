// <div id="a" onmouseover="chbg('red')" onmouseout="chbg('white')">This is element a</div>

// select the element input in the div with class 'pp' and assign it the id 'a'
document.querySelector('.pp input').id = 'a';
document.querySelector('.pp label').id = 'b';

document.querySelector('.banner input').id = 'c';
document.querySelector('.banner label').id = 'd';

$("#b").click(function () {
    $("#a").trigger('click');
});

$(document).ready(function() {
    $("#a").change(function(e) {
        var file = e.target.files[0].name;
        if (file.length > 15) {
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