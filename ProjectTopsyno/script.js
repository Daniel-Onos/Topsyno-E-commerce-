/* ========================================
   WHAT'S HOT PRODUCT TABS
======================================== */

const productTabs = document.querySelectorAll(".product-tab");
const productPanels = document.querySelectorAll(".product-panel");

productTabs.forEach((tab) => {

    tab.addEventListener("click", () => {

        const target = tab.dataset.target;

        productTabs.forEach((currentTab) => {
            currentTab.classList.remove("active");
        });

        productPanels.forEach((panel) => {
            panel.classList.remove("active");
        });

        tab.classList.add("active");

        document.getElementById(target).classList.add("active");

    });

});


/* =========================================
   OLD CODE — COMMENTED OUT
========================================= */

/*
const wishlistButtons = document.querySelectorAll(".wishlist-button");

wishlistButtons.forEach((button) => {

    button.addEventListener("click", () => {

        button.classList.toggle("active");

        const icon = button.querySelector("i");

        if (button.classList.contains("active")) {

            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill");

        } else {

            icon.classList.remove("bi-heart-fill");
            icon.classList.add("bi-heart");

        }

    });

});
*/


/* =========================================
   NEW CODE — FIXED VERSION
========================================= */

const wishlistButtons = document.querySelectorAll(".wishlist-button");

wishlistButtons.forEach((button) => {

    button.addEventListener("click", () => {

        button.classList.toggle("active");

        const icon = button.querySelector("i");

        if (button.classList.contains("active")) {

            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill");

        } else {

            icon.classList.remove("bi-heart-fill");
            icon.classList.add("bi-heart");

        }

    });

});


/* ========================================
   NEWSLETTER FORM
======================================== */

const newsletterForm = document.getElementById("newsletterForm");

if (newsletterForm) {

    newsletterForm.addEventListener("submit", (event) => {

        event.preventDefault();

        const emailInput =
            document.getElementById("newsletterEmail");

        alert(
            "Thanks for joining Topsyno! We'll keep you in the loop."
        );

        emailInput.value = "";

    });

}

/* ========================================
   SEARCH OVERLAY
======================================== */

const openSearch = document.getElementById("openSearch");
const closeSearch = document.getElementById("closeSearch");
const searchOverlay = document.getElementById("searchOverlay");
const searchInput = document.getElementById("searchInput");

if (openSearch && searchOverlay) {

    openSearch.addEventListener("click", () => {

        searchOverlay.classList.add("active");

        setTimeout(() => {
            searchInput.focus();
        }, 100);

    });

}

if (closeSearch && searchOverlay) {

    closeSearch.addEventListener("click", () => {
        searchOverlay.classList.remove("active");
    });

}


/* ========================================
   CLOSE SEARCH WITH ESCAPE
======================================== */

document.addEventListener("keydown", (event) => {

    if (event.key === "Escape" && searchOverlay) {
        searchOverlay.classList.remove("active");
    }

});


/* =========================================
   OLD CODE — COMMENTED OUT
========================================= */

/*
const wishlistButtons =
    document.querySelectorAll(".wishlist-button");

wishlistButtons.forEach((button) => {

    button.addEventListener("click", () => {

        const icon = button.querySelector("i");

        button.classList.toggle("active");

        if (button.classList.contains("active")) {

            icon.classList.remove("bi-heart");
            icon.classList.add("bi-heart-fill");

        } else {

            icon.classList.remove("bi-heart-fill");
            icon.classList.add("bi-heart");

        }

    });

});
*/


/* ========================================
   COLOUR FILTER VISUAL STATE
======================================== */

const colourFilters =
    document.querySelectorAll(".colour-filter");

colourFilters.forEach((colour) => {

    colour.addEventListener("click", () => {

        colourFilters.forEach((item) => {
            item.classList.remove("active");
        });

        colour.classList.add("active");

    });

});


/* ========================================
   CLEAR FILTERS
======================================== */

const clearFilters =
    document.getElementById("clearFilters");

if (clearFilters) {

    clearFilters.addEventListener("click", () => {

        document
            .querySelectorAll(".filter-checkbox")
            .forEach((checkbox) => {
                checkbox.checked = false;
            });

        colourFilters.forEach((colour) => {
            colour.classList.remove("active");
        });

    });

}


/* ========================================
   SIMPLE PRODUCT SORT
======================================== */

const sortProducts =
    document.getElementById("sortProducts");

if (sortProducts) {

    sortProducts.addEventListener("change", () => {

        console.log(
            "Selected sorting:",
            sortProducts.value
        );

        /*
        Later, when your PHP/database is connected,
        this is where the real product sorting will happen.
        */

    });

}