import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

new Tagify(document.querySelector("input.tagify-roles"), {
  // Adds brackets and quotes to match the roles schema ex. ["ROLE_ADMIN", ROLE_]
  originalInputValueFormat: items => `["${items.map(i => i.value.toUpperCase()).join("\",\"")}"]`,
  // Transforms tags to uppercase and checks if there is ROLE_ at the beginning
  transformTag: i => i.value = !i.value.startsWith("ROLE_") ? "ROLE_" + i.value.toUpperCase() : i.value.toUpperCase(),
  pattern: /^ROLE_[A-Z]+$/
});