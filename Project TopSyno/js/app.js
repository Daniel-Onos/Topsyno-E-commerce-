/* =========================
   HERO CAROUSEL
========================= */

const slides = document.querySelectorAll(".hero-slide");
const indicators = document.querySelectorAll(".indicator");

const nextButton = document.getElementById("nextSlide");
const previousButton = document.getElementById("previousSlide");

let currentSlide = 0;
let autoPlay;


/* Show slide */

function showSlide(index) {

    slides.forEach((slide) => {
        slide.classList.remove("active");
    });

    indicators.forEach((indicator) => {
        indicator.classList.remove("active");
    });


    slides[index].classList.add("active");

    indicators[index].classList.add("active");

    currentSlide = index;
}


/* Next */

function nextSlide() {

    let nextIndex = currentSlide + 1;

    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }

    showSlide(nextIndex);
}


/* Previous */

function previousSlide() {

    let previousIndex = currentSlide - 1;

    if (previousIndex < 0) {
        previousIndex = slides.length - 1;
    }

    showSlide(previousIndex);
}


/* Buttons */

nextButton.addEventListener("click", () => {

    nextSlide();

    restartAutoPlay();

});


previousButton.addEventListener("click", () => {

    previousSlide();

    restartAutoPlay();

});


/* Indicators */

indicators.forEach((indicator, index) => {

    indicator.addEventListener("click", () => {

        showSlide(index);

        restartAutoPlay();

    });

});


/* =========================
   AUTO PLAY
========================= */

function startAutoPlay() {

    autoPlay = setInterval(() => {

        nextSlide();

    }, 5000);

}


function restartAutoPlay() {

    clearInterval(autoPlay);

    startAutoPlay();

}


startAutoPlay();


/* =========================
   DARK / LIGHT MODE
========================= */

const themeToggle =
    document.getElementById("themeToggle");


themeToggle.addEventListener("click", () => {

    document.body.classList.toggle("dark-mode");


    if (
        document.body.classList.contains("dark-mode")
    ) {

        themeToggle.textContent = "☀";

    } else {

        themeToggle.textContent = "◐";

    }

});
