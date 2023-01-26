import ClassicEditorBase from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";
import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials";
import AutoformatPlugin from "@ckeditor/ckeditor5-autoformat/src/autoformat";
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold";
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic";
import BlockQuotePlugin from "@ckeditor/ckeditor5-block-quote/src/blockquote";
import HeadingPlugin from "@ckeditor/ckeditor5-heading/src/heading";
import ImagePlugin from "@ckeditor/ckeditor5-image/src/image";
import ImageCaptionPlugin from "@ckeditor/ckeditor5-image/src/imagecaption";
import ImageStylePlugin from "@ckeditor/ckeditor5-image/src/imagestyle";
import ImageToolbarPlugin from "@ckeditor/ckeditor5-image/src/imagetoolbar";
import ImageUploadPlugin from "@ckeditor/ckeditor5-image/src/imageupload";
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link";
import ListPlugin from "@ckeditor/ckeditor5-list/src/list";
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import CodeBlock from "@ckeditor/ckeditor5-code-block/src/codeblock";
import SourceEditing from "@ckeditor/ckeditor5-source-editing/src/sourceediting";
import SimpleUploadAdapter from "@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter";
import HorizontalLine from "@ckeditor/ckeditor5-horizontal-line/src/horizontalline";
import AutoLink from "@ckeditor/ckeditor5-link/src/autolink";
import ImageResizeEditing from '@ckeditor/ckeditor5-image/src/imageresize/imageresizeediting';
import ImageResizeHandles from '@ckeditor/ckeditor5-image/src/imageresize/imageresizehandles';

export default class ClassicEditor extends ClassicEditorBase {
}

ClassicEditor.builtinPlugins = [
  EssentialsPlugin,
  AutoformatPlugin,
  BoldPlugin,
  ItalicPlugin,
  BlockQuotePlugin,
  HeadingPlugin,
  ImagePlugin,
  ImageCaptionPlugin,
  ImageStylePlugin,
  ImageToolbarPlugin,
  ImageUploadPlugin,
  LinkPlugin,
  ListPlugin,
  ParagraphPlugin,
  CodeBlock,
  SourceEditing,
  HorizontalLine,
  SimpleUploadAdapter,
  AutoLink,
  ImageResizeEditing,
  ImageResizeHandles
];

ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      "heading", "|",
      "bold", "italic", "link", "|",
      "horizontalLine", "bulletedList", "numberedList", "|",
      "uploadImage", "|",
      "blockQuote", "codeBlock", "|",
      "undo", "redo", "|",
      "sourceEditing"
    ]
  },
  image: {
    toolbar: [
      "imageStyle:inline",
      "imageStyle:block",
      "imageStyle:side",
      "|",
      "toggleImageCaption",
      "imageTextAlternative"
    ]
  },
  codeBlock: {
    languages: [
      // Use the "php-code" class for PHP code blocks.
      { language: "php", label: "PHP" },
      { language: "javascript", label: "JavaScript" },
      { language: "diff", label: "Diff" },
      { language: "css", label: "CSS" },
      { language: "html", label: "HTML" },
      { language: "xml", label: "XML" }
    ]
  },
  simpleUpload: {
    uploadUrl: window.location.origin + "/api/images",
    withCredentials: true,
    headers: {
      "X-CSRF-TOKEN": document.querySelector("#image-token").value,
      Authorization: "Bearer <JSON Web Token>"
    }
  }
};
