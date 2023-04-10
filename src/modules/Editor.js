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
    };

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

            })

        }



    };

    events(){   

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
                    deleteButton.addEventListener('click', (e) => {
                        start.dataset.id = e.target.dataset.id;
               
                        this.modaldel.style.display = 'block';
                    })
                });
            }
    
            stop.addEventListener('click', () => {
                this.modaldel.style.display = 'none';
            });

        }

 

    };
    
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

        if(+dataset.pp) {
            document.getElementById('edit-post-pp').checked = true;
            
        } else {
            document.getElementById('edit-post-pp').checked = false;
        }

        if(+dataset.gen) {
            document.getElementById('edit-post-gen').checked = true;
        } else {
            document.getElementById('edit-post-gen').checked = false;
        }

        if(+dataset.truthplace) {
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
    };     
  
}

export default Editor



