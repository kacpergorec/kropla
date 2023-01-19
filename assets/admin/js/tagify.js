import Tagify from "@yaireo/tagify";
import "@yaireo/tagify/dist/tagify.css";

const ROLES_ELEMENT = document.querySelector('input.tagify-roles');
const TAGS_ELEMENT = document.querySelector('input.tagify-tags');

if (ROLES_ELEMENT){
  new Tagify(ROLES_ELEMENT, {
    // Adds brackets and quotes to match the roles schema ex. ["ROLE_ADMIN", ROLE_]
    originalInputValueFormat: items => `["${items.map(i => i.value.toUpperCase()).join("\",\"")}"]`,
    // Transforms tags to uppercase and checks if there is ROLE_ at the beginning
    transformTag: i => i.value = !i.value.startsWith("ROLE_") ? "ROLE_" + i.value.toUpperCase() : i.value.toUpperCase(),
    pattern: /^ROLE_[A-Z]+$/
  });
}

if (TAGS_ELEMENT){
  new Tagify(TAGS_ELEMENT);
}
