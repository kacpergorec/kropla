import Tagify from "@yaireo/tagify";
import "@yaireo/tagify/dist/tagify.css";

const ROLES_ELEMENT = document.querySelector("input.tagify-roles");
const TAGS_ELEMENT = document.querySelector("input.tagify-tags");

if (ROLES_ELEMENT) {
  new Tagify(ROLES_ELEMENT, {
    // Adds brackets and quotes to match the roles schema in db
    originalInputValueFormat: items => `["${items.map(i => i.value.toUpperCase()).join("\",\"")}"]`,
    // Transforms tags to uppercase and checks if there is ROLE_ at the beginning
    transformTag: t => t.value = !t.value.startsWith("ROLE_") ? "ROLE_" + t.value.toUpperCase() : t.value.toUpperCase(),
    pattern: /^ROLE_[A-Z]+$/
  });
}

if (TAGS_ELEMENT) {
  new Tagify(TAGS_ELEMENT, {
    // Same as above but lowercase
    originalInputValueFormat: items => `["${items.map(i => i.value.toLowerCase()).join("\",\"")}"]`,
    transformTag: (tag) => {
      tag.color = randomHSL();
      tag.style = "--tag-bg:" + tag.color;
      tag.value = slugify(tag.value.toLowerCase());
    }

  });
}


//------------------------- HELPER METHODS -----------------------------


/**
 * Quick slugger method for tags
 */
function slugify(str) {
  return str.toLowerCase().trim()
    .replace(/[^\w\s-]/g, "")
    .replace(/[\s_-]+/g, "-")
    .replace(/^-+|-+$/g, "");
}


/**
 * Random light pastel colors
 */
function randomHSL() {
  return `hsla(${~~(360 * Math.random())},70%,70%,0.4)`;
}