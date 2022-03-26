class Editor {
    constructor() {
        this.deployEditor();
        this.editButtons = document.getElementsByClassName('edit-object-button');
        this.events();
    }

    events(){

    //    console.log(this.editButtons);

    Array.from(this.editButtons).forEach(function(element) {
        console.log(element);
    });



     //   console.log(b);
    //    for (let btn in b) {

         
            // btn.addEventListener('click', (e) => {
            //             e.preventDefault();
            //             console.log(e.target);
            //         });
        
    }


    deployEditor() {
        console.log('Still!!!!!!!');
    }
}

export default Editor



// const editButtons = document.getElementsByClassName('edit-object-button');

// // console.log(editButtons);

// for (let btn of editButtons) {

//     btn.addEventListener('click', (e) => {
//         e.preventDefault();
//         console.log(e.target);
//     })

// }


