/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/Editor.js":
/*!*******************************!*\
  !*** ./src/modules/Editor.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
class Editor {
  constructor() {
    this.editButtons = document.getElementsByClassName('edit-object-button');
    this.editOverlay = document.getElementById('edit-overlay');
    this.canselButton = document.getElementById('cansel-editing');
    this.deleteButtons = document.getElementsByClassName('delete-object-button');
    this.modaldel = document.getElementById('modaldel');
    this.events();
    this.overlay = false;
    this.picturePreview();
  }

  picturePreview() {
    const picture = document.getElementById('objectPicture');

    if (picture) {
      let IMG = document.getElementById('objectPictureIMG');

      if (!IMG) {
        IMG = document.getElementById('edit-post-picture');
      }

      picture.addEventListener('change', () => {
        let selectedFile = picture.files[0];
        selectedFile = window.URL.createObjectURL(selectedFile);
        IMG.src = selectedFile;
      });
    }
  }

  events() {
    const start = document.getElementById('start');
    const stop = document.getElementById('stop');

    if (start) {
      start.addEventListener('click', () => {
        const toDelete = `delete-form-${start.dataset.id}`;
        const deleteForm = document.getElementById(toDelete);
        deleteForm.submit();
        this.modaldel.style.display = 'none';
      });

      if (this.deleteButtons) {
        Array.from(this.deleteButtons).forEach(deleteButton => {
          deleteButton.addEventListener('click', e => {
            start.dataset.id = e.target.dataset.id;
            this.modaldel.style.display = 'block';
          });
        });
      }

      stop.addEventListener('click', () => {
        this.modaldel.style.display = 'none';
      }); //     Array.from(this.editButtons).forEach(btn => {
      //         if (btn) {
      //             btn.addEventListener('click', (e) => {
      //                 this.overlay = true;
      //                 let dataset = {
      //                     id: e.target.dataset.id,
      //                     name: e.target.dataset.name,
      //                     type: e.target.dataset.type,
      //                     lat: e.target.dataset.lat,
      //                     lon: e.target.dataset.lon,
      //                     location: e.target.dataset.location,
      //                     power: e.target.dataset.power,
      //                     powerpr: e.target.dataset.powerpr,
      //                     pp: e.target.dataset.pp,
      //                     gen: e.target.dataset.gen,
      //                     truthplace: e.target.dataset.truthplace,
      //                     year: e.target.dataset.year,
      //                     status: e.target.dataset.status,
      //                     function: e.target.dataset.function,
      //                     holder: e.target.dataset.holder,
      //                     source: e.target.dataset.source,
      //                     link: e.target.dataset.link,
      //                     linkshort: e.target.dataset.linkshort,
      //                     picture: e.target.dataset.picture              
      //                 }        
      //                 console.log(dataset);
      //                 this.openOverlay(dataset);
      //             });
      //         }
      //     });
      //     this.canselButton.addEventListener('click', () => {
      //         this.overlay = false;
      //         this.editOverlay.classList.remove('search-overlay--active');
      //     });
    }
  }

  openOverlay(dataset) {
    document.getElementById('edit-post-id').value = dataset.id;
    document.getElementById('edit-post-name').value = dataset.name;
    let formType = "edit-post-type-" + dataset.type;
    document.getElementById(formType).setAttribute('selected', true);
    document.getElementById('edit-post-lat').value = dataset.lat;
    document.getElementById('edit-post-lon').value = dataset.lon;
    document.getElementById('edit-post-location').value = dataset.location;
    document.getElementById('edit-post-power').value = dataset.power;
    document.getElementById('edit-post-powerpr').value = dataset.powerpr;

    if (+dataset.pp) {
      document.getElementById('edit-post-pp').checked = true;
    } else {
      document.getElementById('edit-post-pp').checked = false;
    }

    if (+dataset.gen) {
      document.getElementById('edit-post-gen').checked = true;
    } else {
      document.getElementById('edit-post-gen').checked = false;
    }

    if (+dataset.truthplace) {
      document.getElementById('edit-post-truthplace').checked = true;
    } else {
      document.getElementById('edit-post-truthplace').checked = false;
    }

    document.getElementById('edit-post-year').value = dataset.year;
    let formStatus = "edit-post-status";
    document.getElementById(formStatus).value = dataset.status;

    if (dataset.function) {
      let formFunction = "edit-post-function-" + dataset.function;
      document.getElementById(formFunction).setAttribute('selected', true);
    }

    document.getElementById('edit-post-holder').value = dataset.holder;
    document.getElementById('edit-post-source').value = dataset.source;
    document.getElementById('edit-post-link').value = dataset.link;
    document.getElementById('edit-post-linkshort').value = dataset.linkshort;

    if (dataset.picture) {
      document.getElementById('edit-post-picture').src = dataset.picture;
    }

    this.editOverlay.classList.add('search-overlay--active');
  }

}

/* harmony default export */ __webpack_exports__["default"] = (Editor);

/***/ }),

/***/ "./css/main.scss":
/*!***********************!*\
  !*** ./css/main.scss ***!
  \***********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_main_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/main.scss */ "./css/main.scss");
/* harmony import */ var _modules_Editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/Editor */ "./src/modules/Editor.js");


const isEditorNeeded = document.querySelector('.objects__table');
const isItDatabase = document.querySelector('.orgdata__form');
const isItSunres = document.querySelector('.sunres-option');
const isItWindres = document.querySelector('.windres-option');

if (isEditorNeeded) {
  const editor = new _modules_Editor__WEBPACK_IMPORTED_MODULE_1__["default"]();
} // For sunres options 


if (isItSunres) {
  const sunOptions = [];
  const sunPeriods = [['year', 'Год'], ['warm', 'Полгода'], ['summer', 'Лето'], ['cold', 'Зима']];
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
  surface.addEventListener('change', changePeriods);

  function changePeriods(e) {
    let currentSurface = e.target.value;
    let oldOptions = document.getElementsByClassName('period-option');
    let newPeriods = sunOptions[currentSurface].periods;

    while (oldOptions.length > 0) {
      oldOptions[0].remove();
      oldOptions = document.getElementsByClassName('period-option');
    }

    for (let i = 0; i < newPeriods.length; i++) {
      const opt = document.createElement('option');
      opt.value = sunPeriods[i][0];
      opt.innerHTML = sunPeriods[i][1];
      opt.classList = 'period-option';
      period.appendChild(opt);
    }
  }
} // For windres options 


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
  datatype.addEventListener('change', changeHeight);

  function changeHeight(e) {
    let currentDatatype = e.target.value;
    let oldOptions = document.getElementsByClassName('height-option');
    let newHeight = windOptions[currentDatatype].height;

    while (oldOptions.length > 0) {
      oldOptions[0].remove();
      oldOptions = document.getElementsByClassName('height-option');
    }

    for (let i = 0; i < newHeight.length; i++) {
      const opt = document.createElement('option');
      opt.value = newHeight[i];
      opt.innerHTML = newHeight[i] + ' ' + windOptions[currentDatatype].ruoption;
      opt.classList = 'height-option';
      height.appendChild(opt);
    }
  }
} // For org database


if (isItDatabase) {
  const orgtypes = document.getElementsByClassName('orgdata__type-item');
  const selectAllButton = document.getElementById('selectAll');
  let alreadySelected = true;

  for (let i = 0; i < orgtypes.length; i++) {
    if (!orgtypes[i].checked) {
      alreadySelected = false;
    }

    ;
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
      selectAllButton.classList.remove('selected');

      for (let i = 0; i < orgtypes.length; i++) {
        orgtypes[i].checked = false;
      }
    } else {
      selectAllButton.innerText = 'Убрать все';
      selectAllButton.classList.add('selected');

      for (let i = 0; i < orgtypes.length; i++) {
        orgtypes[i].checked = true;
      }
    }
  });
}
}();
/******/ })()
;
//# sourceMappingURL=index.js.map