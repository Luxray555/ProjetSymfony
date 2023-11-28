let choiceBox = document.querySelectorAll('.form-search .choice-list');

document.addEventListener('DOMContentLoaded', function () {
    let list = {};
    for (let i = 0; i < choiceBox.length; i++) {
        list[i] = [];
    }
    for (let i = 0; i < choiceBox.length; i++) {
        let choice = choiceBox[i].querySelector('.choice');
        let line = choiceBox[i].querySelectorAll('.line');
        for (let j = 0; j < line.length; j++) {
            let checkbox = line[j].querySelector('input[type="checkbox"]');
            let label = line[j].querySelector('label');
            checkbox.addEventListener('change', function () {
                if (checkbox.checked) {
                    let newElement = document.createElement('span');
                    newElement.textContent = label.textContent;
                    list[i].push(newElement);
                    if(choice.querySelector('span.all')){
                        choice.querySelector('span.all').remove();
                    }
                    if(choice.children.length < 2){
                        choice.appendChild(list[i][choice.children.length]);
                    }else{
                        if(!choice.querySelector('span.plus')){
                            let plus = document.createElement('span');
                            plus.textContent = '+1';
                            plus.classList.add('plus');
                            choice.appendChild(plus);
                        }else{
                            choice.querySelector('span.plus').textContent = '+' + (list[i].length - 2);
                        }
                    }
                } else {
                    let elementsToRemove = choice.querySelectorAll('span');
                    list[i].forEach((element, index) => {
                        if (element.textContent === label.textContent) {
                            list[i].splice(index, 1);
                        }
                    });
                    elementsToRemove.forEach(element => {
                        if (element.textContent === label.textContent) {
                            element.remove();
                            if(list[i].length > 1) {
                                choice.insertBefore(list[i][choice.children.length - 1], choice.querySelector('span.plus'));
                            }
                        }
                    });
                    console.log();
                    if(list[i].length < 1){
                        let newElement = document.createElement('span');
                        newElement.textContent = 'Tout';
                        newElement.classList.add('all');
                        choice.appendChild(newElement);
                    }else if(list[i].length > 2){
                        choice.querySelector('span.plus').textContent = '+' + (list[i].length - 2);
                    }else{
                        if(choice.querySelector('span.plus')){
                            console.log('ok');
                            choice.querySelector('span.plus').remove();
                        }
                    }
                }
            });
        }
    }

    for (let i = 0; i < choiceBox.length; i++) {
        let choice = choiceBox[i].querySelector('.choice');
        let line = choiceBox[i].querySelectorAll('.line');
        for (let j = 0; j < line.length; j++) {
            let checkbox = line[j].querySelector('input[type="checkbox"]');
            let label = line[j].querySelector('label');
            let isChecked = app.request.get(0).at(i) !== null && app.request.get(0).at(i).includes(label.textContent);
            checkbox.checked = isChecked;
            if(isChecked){
                let newElement = document.createElement('span');
                newElement.textContent = label.textContent;
                list[i].push(newElement);
                if(choice.querySelector('span.all')){
                    choice.querySelector('span.all').remove();
                }
                if(choice.children.length < 2){
                    choice.appendChild(list[i][choice.children.length]);
                }else{
                    if(!choice.querySelector('span.plus')){
                        let plus = document.createElement('span');
                        plus.textContent = '+1';
                        plus.classList.add('plus');
                        choice.appendChild(plus);
                    }else{
                        choice.querySelector('span.plus').textContent = '+' + (list[i].length - 2);
                    }
                }
            }
        }
    }


});