import "../css/main.scss";
import Editor from './modules/Editor';

const isEditorNeeded = document.querySelector('.objects__table');
const isItDatabase = document.querySelector('.orgdata__form');

if (isEditorNeeded) {
    const editor = new Editor();
}


// For org database

if (isItDatabase) {
    const orgtypes = document.getElementsByClassName('orgdata__type-item');
    const selectAllButton = document.getElementById('selectAll');

    let alreadySelected = true;

    for (let i = 0; i<orgtypes.length; i++) {
        if (!orgtypes[i].checked) {
            alreadySelected = false;
        };    
    }

    if (alreadySelected) {
        selectAllButton.innerText = 'Убрать все';
        selectAllButton.classList.add('selected');
    } 


    selectAllButton.addEventListener('click', () => {
        let isSelected = selectAllButton.classList.contains('selected');
        console.log(isSelected);

        if (isSelected) {
            selectAllButton.innerText = 'Выбрать все';
            selectAllButton.classList.remove('selected')
            for (let i = 0; i<orgtypes.length; i++) {
                orgtypes[i].checked = false;    
            }


        } else {
            selectAllButton.innerText = 'Убрать все';
            selectAllButton.classList.add('selected');
            for (let i = 0; i<orgtypes.length; i++) {
                orgtypes[i].checked = true;    
            }
        }
         
    })
}


