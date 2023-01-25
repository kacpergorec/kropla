import ClassicEditor from "./ckeditor";

const TEXTAREA_ELEMENT = document.querySelector(".ckeditor-textarea");

if (TEXTAREA_ELEMENT) {
  ClassicEditor
    .create(TEXTAREA_ELEMENT)
    .then(editor => {


    })
    .catch(error => {
      console.error(error.stack);
    });
}

