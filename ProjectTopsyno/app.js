/* ========================================
   HERO CAROUSEL
======================================== */

// const slides = document.querySelectorAll(".hero-slide");
// const indicators = document.querySelectorAll(".indicator");
// const nextButton = document.getElementById("nextSlide");
// const previousButton = document.getElementById("previousSlide");

// let currentSlide = 0;
// let autoPlay = null;

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

    if (!slides.length || !indicators.length) {
        return;
    }

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

    if (!slides.length) {
        return;
    }

    let nextIndex = currentSlide + 1;

    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }

    showSlide(nextIndex);
}


/* Previous */

function previousSlide() {

    if (!slides.length) {
        return;
    }

    let previousIndex = currentSlide - 1;

    if (previousIndex < 0) {
        previousIndex = slides.length - 1;
    }

    showSlide(previousIndex);
}


/* Buttons */

if (nextButton) {

    nextButton.addEventListener("click", () => {
        nextSlide();
        restartAutoPlay();
    });

}


if (previousButton) {

    previousButton.addEventListener("click", () => {
        previousSlide();
        restartAutoPlay();
    });

}


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

    if (!slides.length) {
        return;
    }

    autoPlay = setInterval(() => {
        nextSlide();
    }, 5000);

}


function restartAutoPlay() {

    if (!slides.length) {
        return;
    }

    clearInterval(autoPlay);
    startAutoPlay();

}


startAutoPlay();


/* ========================================
   SHOW SLIDE
======================================== */

function showSlide(index) {

    if (!slides.length) return;

    slides.forEach((slide) => {
        slide.classList.remove("active");
    });

    indicators.forEach((indicator) => {
        indicator.classList.remove("active");
    });

    slides[index].classList.add("active");

    if (indicators[index]) {
        indicators[index].classList.add("active");
    }

    currentSlide = index;
}


/* ========================================
   NEXT SLIDE
======================================== */

function nextSlide() {

    if (!slides.length) return;

    let nextIndex = currentSlide + 1;

    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }

    showSlide(nextIndex);
}


/* ========================================
   PREVIOUS SLIDE
======================================== */

function previousSlide() {

    if (!slides.length) return;

    let previousIndex = currentSlide - 1;

    if (previousIndex < 0) {
        previousIndex = slides.length - 1;
    }

    showSlide(previousIndex);
}


/* ========================================
   CAROUSEL BUTTONS
======================================== */

if (nextButton) {

    nextButton.addEventListener("click", () => {
        nextSlide();
        restartAutoPlay();
    });

}

if (previousButton) {

    previousButton.addEventListener("click", () => {
        previousSlide();
        restartAutoPlay();
    });

}


/* ========================================
   CAROUSEL INDICATORS
======================================== */

indicators.forEach((indicator, index) => {

    indicator.addEventListener("click", () => {

        showSlide(index);
        restartAutoPlay();

    });

});


/* ========================================
   AUTO PLAY
======================================== */

function startAutoPlay() {

    if (slides.length <= 1) return;

    autoPlay = setInterval(() => {

        nextSlide();

    }, 5000);

}


function restartAutoPlay() {

    clearInterval(autoPlay);

    startAutoPlay();

}


/* ========================================
   START CAROUSEL
======================================== */

if (slides.length > 0) {

    showSlide(0);

    startAutoPlay();

}


/* ========================================
   DARK / LIGHT MODE
   Implemented to run after DOM ready, using localStorage key `topsyno-theme`.
======================================== */

(function () {
    const THEME_KEY = "topsyno-theme";

    function applyTheme(mode) {
        if (mode === "dark") {
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }
    }

    function updateToggleUI(toggleEl) {
        if (!toggleEl) return;
        const isDark = document.body.classList.contains("dark-mode");
        // Use clear unicode symbols so users can see current mode
        toggleEl.textContent = isDark ? "☾" : "☀";
        toggleEl.setAttribute("aria-pressed", isDark ? "true" : "false");
    }

    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("themeToggle");

        // Restore saved theme, default to light when nothing saved
        const saved = localStorage.getItem(THEME_KEY);
        applyTheme(saved === "dark" ? "dark" : "light");

        // Initialize toggle UI
        updateToggleUI(toggle);

        if (!toggle) return;

        // Single listener, no duplicates
        toggle.addEventListener("click", () => {
            const isNowDark = document.body.classList.toggle("dark-mode");
            localStorage.setItem(THEME_KEY, isNowDark ? "dark" : "light");
            updateToggleUI(toggle);
        });
    });

})();