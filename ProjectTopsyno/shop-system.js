document.addEventListener("DOMContentLoaded", () => {


    /* =====================================
       SEARCH
    ===================================== */

    const openSearch =
        document.getElementById("openSearch");

    const closeSearch =
        document.getElementById("closeSearch");

    const searchOverlay =
        document.getElementById("searchOverlay");


    if (openSearch && searchOverlay) {

        openSearch.addEventListener("click", () => {
            searchOverlay.classList.add("active");
        });

    }


    if (closeSearch && searchOverlay) {

        closeSearch.addEventListener("click", () => {
            searchOverlay.classList.remove("active");
        });

    }


    document.addEventListener("keydown", (event) => {

        if (
            event.key === "Escape"
            && searchOverlay
        ) {
            searchOverlay.classList.remove("active");
        }

    });



    /* =====================================
       ALL CATEGORIES
    ===================================== */

    const allCategoriesButton =
        document.getElementById("allCategoriesButton");

    const allCategoriesMenu =
        document.getElementById("allCategoriesMenu");


    if (
        allCategoriesButton
        && allCategoriesMenu
    ) {

        allCategoriesButton.addEventListener(
            "click",
            () => {
                allCategoriesMenu.classList.toggle("open");
            }
        );

    }



    /* =====================================
       FILTER + SORT DROPDOWNS
    ===================================== */

    const dropdownButtons =
        document.querySelectorAll("[data-dropdown]");


    dropdownButtons.forEach((button) => {

        button.addEventListener("click", (event) => {

            event.stopPropagation();

            const panelId =
                button.dataset.dropdown;

            const panel =
                document.getElementById(panelId);


            document
                .querySelectorAll(".control-panel")
                .forEach((item) => {

                    if (item !== panel) {
                        item.classList.remove("open");
                    }

                });


            if (panel) {
                panel.classList.toggle("open");
            }

        });

    });


    document.addEventListener("click", (event) => {

        if (
            !event.target.closest(".control-dropdown")
        ) {

            document
                .querySelectorAll(".control-panel")
                .forEach((panel) => {
                    panel.classList.remove("open");
                });

        }

    });



    /* =====================================
       PRODUCT GRID
    ===================================== */

    const grids = [
        document.getElementById("productGrid"),
        document.getElementById("collectionProductGrid")
    ].filter(Boolean);


    function getActiveGrid() {

        return grids[0] || null;

    }



    /* =====================================
       FILTER PRODUCTS
    ===================================== */

    function filterProducts() {

        grids.forEach((grid) => {

            const selectedPrice =
                document.querySelector(
                    'input[name="price"]:checked'
                )?.value
                ||
                document.querySelector(
                    'input[name="collectionPrice"]:checked'
                )?.value
                ||
                "all";


            const ratingFilters =
                document.querySelectorAll(
                    ".rating-filter:checked"
                );


            const selectedRatings =
                Array.from(ratingFilters)
                    .map(
                        (input) =>
                            Number(input.value)
                    );


            const products =
                grid.querySelectorAll(
                    ".shop-product-card-v2"
                );


            products.forEach((product) => {

                const price =
                    Number(product.dataset.price);

                const rating =
                    Number(product.dataset.rating);


                let showProduct = true;


                if (
                    selectedPrice === "under-30000"
                    && price >= 30000
                ) {
                    showProduct = false;
                }


                if (
                    selectedPrice === "30000-35000"
                    && (
                        price < 30000
                        || price > 35000
                    )
                ) {
                    showProduct = false;
                }


                if (
                    selectedPrice === "over-35000"
                    && price <= 35000
                ) {
                    showProduct = false;
                }


                if (
                    selectedPrice === "over-30000"
                    && price <= 30000
                ) {
                    showProduct = false;
                }


                if (
                    selectedRatings.length > 0
                    && !selectedRatings.some(
                        (minimumRating) =>
                            rating >= minimumRating
                    )
                ) {
                    showProduct = false;
                }


                product.style.display =
                    showProduct
                        ? ""
                        : "none";

            });

        });

    }


    document
        .getElementById("applyFilters")
        ?.addEventListener(
            "click",
            () => {

                filterProducts();

                document
                    .getElementById("filterPanel")
                    ?.classList.remove("open");

            }
        );


    document
        .getElementById("applyCollectionFilters")
        ?.addEventListener(
            "click",
            () => {

                filterProducts();

                document
                    .getElementById("collectionFilterPanel")
                    ?.classList.remove("open");

            }
        );



    /* =====================================
       SORT PRODUCTS
    ===================================== */

    const sortButtons =
        document.querySelectorAll("[data-sort]");


    sortButtons.forEach((button) => {

        button.addEventListener("click", () => {

            const sortType =
                button.dataset.sort;


            grids.forEach((grid) => {

                const cards =
                    Array.from(
                        grid.querySelectorAll(
                            ".shop-product-card-v2"
                        )
                    );


                cards.sort((a, b) => {

                    if (sortType === "new") {

                        return new Date(
                            b.dataset.date
                        )
                        -
                        new Date(
                            a.dataset.date
                        );

                    }


                    if (sortType === "old") {

                        return new Date(
                            a.dataset.date
                        )
                        -
                        new Date(
                            b.dataset.date
                        );

                    }


                    if (sortType === "sales") {

                        return Number(
                            b.dataset.sales
                        )
                        -
                        Number(
                            a.dataset.sales
                        );

                    }


                    if (sortType === "rating") {

                        return Number(
                            b.dataset.rating
                        )
                        -
                        Number(
                            a.dataset.rating
                        );

                    }


                    if (sortType === "views") {

                        return Number(
                            b.dataset.views
                        )
                        -
                        Number(
                            a.dataset.views
                        );

                    }


                    if (sortType === "high") {

                        return Number(
                            b.dataset.price
                        )
                        -
                        Number(
                            a.dataset.price
                        );

                    }


                    if (sortType === "low") {

                        return Number(
                            a.dataset.price
                        )
                        -
                        Number(
                            b.dataset.price
                        );

                    }


                    if (sortType === "random") {

                        return Math.random() - 0.5;

                    }


                    return 0;

                });


                cards.forEach((card) => {
                    grid.appendChild(card);
                });

            });


            document
                .querySelectorAll(".sort-panel")
                .forEach((panel) => {
                    panel.classList.remove("open");
                });

        });

    });



    /* =====================================
       CART
       Uses localStorage for now
    ===================================== */

    const cartCount =
        document.getElementById("cartCount");

    const cartToast =
        document.getElementById("cartToast");

    const cartToastText =
        document.getElementById("cartToastText");


    function getCart() {

        return JSON.parse(
            localStorage.getItem("capturedCart")
        ) || [];

    }


    function saveCart(cart) {

        localStorage.setItem(
            "capturedCart",
            JSON.stringify(cart)
        );

    }


    function updateCartCount() {

        const cart = getCart();

        const totalQuantity =
            cart.reduce(
                (total, item) =>
                    total + item.quantity,
                0
            );


        if (cartCount) {

            cartCount.textContent =
                totalQuantity;

        }

    }


    function showCartToast(productName) {

        if (
            !cartToast
            || !cartToastText
        ) {
            return;
        }


        cartToastText.textContent =
            `${productName} was added to your cart.`;

        cartToast.classList.add("show");


        setTimeout(() => {

            cartToast.classList.remove("show");

        }, 3000);

    }


    function addProductToCart(button, quantity = 1) {

        const product = {

            id: button.dataset.id,

            name: button.dataset.name,

            price: Number(
                button.dataset.price
            ),

            image: button.dataset.image,

            quantity: quantity

        };


        const cart = getCart();


        const existingProduct =
            cart.find(
                (item) =>
                    item.id === product.id
            );


        if (existingProduct) {

            existingProduct.quantity +=
                product.quantity;

        } else {

            cart.push(product);

        }


        saveCart(cart);

        updateCartCount();

        showCartToast(product.name);

    }



    /* PRODUCT CARD BUTTONS */

    document
        .querySelectorAll(".add-to-cart-button")
        .forEach((button) => {

            button.addEventListener(
                "click",
                () => {

                    addProductToCart(button);

                }
            );

        });



    /* PRODUCT PAGE QUANTITY */

    let productQuantity = 1;


    const quantityDisplay =
        document.getElementById(
            "productQuantity"
        );


    document
        .getElementById("increaseQty")
        ?.addEventListener(
            "click",
            () => {

                productQuantity++;

                if (quantityDisplay) {

                    quantityDisplay.textContent =
                        productQuantity;

                }

            }
        );


    document
        .getElementById("decreaseQty")
        ?.addEventListener(
            "click",
            () => {

                if (productQuantity > 1) {

                    productQuantity--;

                    if (quantityDisplay) {

                        quantityDisplay.textContent =
                            productQuantity;

                    }

                }

            }
        );


    document
        .getElementById("productAddToCart")
        ?.addEventListener(
            "click",
            (event) => {

                addProductToCart(
                    event.currentTarget,
                    productQuantity
                );

            }
        );


    updateCartCount();

});