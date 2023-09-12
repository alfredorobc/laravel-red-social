import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzoneElement = document.querySelector('#dropzone');

if(dropzoneElement){

    const dropzone = new Dropzone(dropzoneElement,{
        dictDefaultMessage: "Sube aquí tu imagen",
        acceptedFiles: ".png,.jpg,.jpeg,.gif",
        addRemoveLinks:true,
        dictRemoveFile:"Borrar Archivo",
        maxFiles:1,
        uploadMultiple:false,

        init: function(){
            if(document.querySelector('[name="imagen"]').value.trim()){
                const imagenPublicada = {};
                imagenPublicada.size = 1234;
                imagenPublicada.name = document.querySelector('[name="imagen"]').value;

                this.options.addedfile.call(this,imagenPublicada);
                this.options.thumbnail.call(this,imagenPublicada,`/uploads/${imagenPublicada.name}`);

                imagenPublicada.previewElement.classList.add('dz-success','dz-complete');
            }
        }
    });

    dropzone.on('success', (file,response) => {
        const {imagen=''} = response;

        document.querySelector('[name="imagen"]').value = imagen;
    });

    dropzone.on('removedfile', (file) => {
        document.querySelector('[name="imagen"]').value = '';
    });

}
