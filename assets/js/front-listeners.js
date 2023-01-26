const body = document.querySelector("body");

// const breakpoints = {
//   xl: 1536,
//   lg: 1280,
//   md: 1024,
//   sm: 768,
//   xs: 640
// };

// const breakpoints = {
//   desktop: 1280,
//   mobile: 1024,
// };


function addClassOnScroll() {
  let scrollPos = window.scrollY;
  if (scrollPos > 200) {
    body.classList.add("scrolled");
  } else {
    body.classList.remove("scrolled");
  }
}

// function addBodyClass() {
//   let windowWidth = window.innerWidth;
//   let classesToRemove = Object.keys(breakpoints);
//   Object.entries(breakpoints).forEach(([className, width]) => {
//     if (windowWidth < width) {
//       body.classList.remove(...classesToRemove);
//       body.classList.add(className);
//       return;
//     }
//   });
// }

// window.addEventListener("load", addBodyClass);
// window.addEventListener("resize", addBodyClass);
window.addEventListener("scroll", addClassOnScroll);