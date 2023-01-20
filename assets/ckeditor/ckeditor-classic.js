import ClassicEditor from "./ckeditor";

const TEXTAREA_ELEMENT = document.querySelector(".ckeditor-textarea");

if (TEXTAREA_ELEMENT) {
  ClassicEditor
    .create(TEXTAREA_ELEMENT)
    .then(editor => {
      console.log("Editor was initialized", editor);
    })
    .catch(error => {
      console.error(error.stack);
    });
}
