import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

if (document.querySelector(".ckeditor-textarea")) {
  ClassicEditor
    .create( document.querySelector( '.ckeditor-textarea' ) )
    .then( editor => {
      window.editor = editor;
    } )
    .catch( error => {
      console.error( 'There was a problem initializing the editor.', error );
    } );
}