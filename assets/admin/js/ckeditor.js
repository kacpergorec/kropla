import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const TEXTAREA_ELEMENT = document.querySelector(".ckeditor-textarea");

if (TEXTAREA_ELEMENT) {
  ClassicEditor
    .create(TEXTAREA_ELEMENT)
    .then(editor => {
      window.editor = editor;
    })
    .catch(error => {
      console.error("There was a problem initializing the editor.", error);
    });
}