import "../css/main.scss";
import Editor from './modules/Editor';

const isEditorNeeded = document.querySelector('.objects__table');
const isItDatabase = document.querySelector('.orgdata__form');
const isItSunres = document.querySelector('.sunres-option');
const isItWindres = document.querySelector('.windoptions__selector');

if (isEditorNeeded) {
    const editor = new Editor();
}


// For sunres options 

if (isItSunres) {

    const sunOptions = [];

    const sunPeriods = [
        ['year', 'Год'],
        ['warm', 'Полгода (апрель — сентябрь)'],
        ['summer', 'Лето (июнь — август)'],
        ['cold', 'Зима (декабрь — февраль']
    ];

    sunOptions['gor'] = {
        runame: 'Горизонтальная поверхность',
        periods: [0, 1, 2]
    };

    sunOptions['ver'] = {
        runame: 'Вертикальная поверхность',
        periods: [0, 1, 2]
    };

    sunOptions['m15'] = {
        runame: '-15 к широте',
        periods: [0, 1, 2]
    };

    sunOptions['p15'] = {
        runame: '+15 к широте',
        periods: [1, 2, 3]
    };

    sunOptions['lat'] = {
        runame: 'Наклон равен широте',
        periods: [0, 1, 2]
    };

    sunOptions['opt'] = {
        runame: 'Оптимально ориентированная',
        periods: [0]
    };

    sunOptions['move'] = {
        runame: 'Наклон равен широте',
        periods: [0, 1, 2, 3]
    }; 


    surface.addEventListener('change', changePeriods );

    function changePeriods(e) {

        let currentSurface = e.target.value;
        let oldOptions = document.getElementsByClassName('period-option');

        let newPeriods = sunOptions[currentSurface].periods;        
        
        while (oldOptions.length > 0) {
            oldOptions[0].remove();
            oldOptions = document.getElementsByClassName('period-option');
        }
        

        for (let i = 0; i < newPeriods.length; i++ ) {
            const opt = document.createElement('option');
            opt.value = sunPeriods[i][0];
            opt.innerHTML = sunPeriods[i][1];
            opt.classList = 'period-option';
            period.appendChild(opt);
        }
        

    }
}

// For windres options 

if (isItWindres) {

    const windOptions = [];

    windOptions['vp'] = {
        runame: 'Валовый потенциал',
        ruunit: 'МВт·ч/год',
        height: ['30', '50', '100', '120'],
        ruoption: 'м'
    };

    windOptions['lull'] = {
        runame: 'Энергетические затишья',
        ruunit: '%',
        height: ['30', '50', '100', '120'],
        ruoption: 'м'
    };

    
    windOptions['den'] = {
        runame: 'Плотность энергии',
        ruunit: 'Вт/м<sup>2</sup>',
        height: ['30', '50', '100', '120'],
        ruoption: 'м'
    };

    windOptions['ann'] = {
        runame: 'Повторяемость скорости ветра',
        ruunit: '%',
        height: ['0-2', '2-6', '6-10', '10-14', '14-18', '18-25'],
        ruoption: 'м/c'
    };

    windOptions['speed'] = {
        runame: 'Скорость ветра',
        ruunit: 'м/с',
        height: ['10', '30', '50', '100', '120'],
        ruoption: 'м'
    };

    windOptions['pot'] = {
        runame: 'Технический потенциал',
        ruunit: 'МВт·ч/год',
        height: ['30', '50', '100', '120'],
        ruoption: 'м'
    };

    datatype.addEventListener('change', changeHeight );

    function changeHeight(e) {

        let currentDatatype = e.target.value;
        let oldOptions = document.getElementsByClassName('height-option');

        let newHeight = windOptions[currentDatatype].height;        
        
        while (oldOptions.length > 0) {
            oldOptions[0].remove();
            oldOptions = document.getElementsByClassName('height-option');
        }
        

        for (let i = 0; i < newHeight.length; i++ ) {
            const opt = document.createElement('option');
            opt.value = newHeight[i];
            opt.innerHTML = newHeight[i] + ' ' + windOptions[currentDatatype].ruoption;
            opt.classList = 'height-option';
            height.appendChild(opt);
        }
        

    }
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


