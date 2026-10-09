<?php
$pageTitle = "Custom Cap | TOPSYNO";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shop-system.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        /* =====================================================
           TOPSYNO CUSTOM CAP
           Layout only — configurator functionality comes later
        ===================================================== */

        .custom-page {
            background: var(--bg-color, #eee6dc);
            min-height: 100vh;
            padding-top: 116px;
        }

        /* =====================================================
           INTRO
        ===================================================== */

        .custom-intro {
            max-width: 1400px;
            margin: 0 auto;
            padding: 70px 6vw 45px;
        }

        .custom-label {
            font-family: "Inter", sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            margin-bottom: 18px;
            color: #9c88b5;
        }

        .custom-intro h1 {
            margin: 0;
            max-width: 850px;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(48px, 7vw, 100px);
            line-height: .9;
            letter-spacing: -.06em;
            text-transform: uppercase;
            color: var(--text-color, #171717);
        }

        .custom-intro h1 span {
            color: #9c88b5;
        }

        .custom-intro p {
            max-width: 580px;
            margin: 28px 0 0;
            font-family: "Inter", sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: var(--muted-text, #666);
        }

        /* =====================================================
           BUILDER
        ===================================================== */

        .custom-builder {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 6vw 100px;

            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(400px, .85fr);
            gap: 35px;
            align-items: start;
        }

        /* =====================================================
           LEFT — OPTIONS
        ===================================================== */

        .custom-options {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .custom-step {
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(23,23,23,.08);
            border-radius: 22px;
            padding: 26px;

            box-shadow:
                0 12px 35px rgba(23,23,23,.06);
        }

        .step-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 22px;
        }

        .step-number {
            width: 34px;
            height: 34px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #171717;
            color: #fff;

            font-family: "Inter", sans-serif;
            font-size: 11px;
            font-weight: 700;
        }

        .step-heading h2 {
            margin: 0;
            font-family: "Space Grotesk", sans-serif;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: -.02em;
            color: var(--text-color, #171717);
        }

        .step-description {
            margin: -10px 0 20px 47px;
            font-size: 13px;
            color: #777;
        }

        /* =====================================================
           CAP TYPE CARDS
        ===================================================== */

        .cap-types {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .cap-type {
            position: relative;
            min-height: 145px;

            border: 1px solid rgba(23,23,23,.12);
            border-radius: 16px;
            background: #f7f4ef;

            overflow: hidden;
            cursor: pointer;

            transition:
                transform .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .cap-type:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(23,23,23,.08);
        }

        .cap-type.active {
            border: 2px solid #9c88b5;
            box-shadow: 0 8px 25px rgba(156,136,181,.2);
        }

        .cap-type img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            display: block;
        }

        .cap-type-name {
            display: block;
            padding: 10px 12px;

            font-family: "Inter", sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;

            color: #171717;
        }

        /* =====================================================
           COLORS
        ===================================================== */

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
        }

        .color-option {
            width: 42px;
            height: 42px;
            border-radius: 50%;

            border: 3px solid #fff;
            outline: 1px solid rgba(23,23,23,.15);

            cursor: pointer;

            transition:
                transform .2s ease,
                outline-color .2s ease;
        }

        .color-option:hover {
            transform: scale(1.08);
        }

        .color-option.active {
            outline: 2px solid #9c88b5;
            outline-offset: 3px;
        }

        .color-black {
            background: #171717;
        }

        .color-white {
            background: #f7f7f5;
        }

        .color-brown {
            background: #6f4e37;
        }

        .color-navy {
            background: #18253a;
        }

        .color-forest {
            background: #31483b;
        }

        .color-chocolate {
            background: #4a3026;
        }

        .color-lavender {
            background: #9c88b5;
        }

        .color-mint {
            background: #b8d8c0;
        }

        /* =====================================================
           DESIGN OPTIONS
        ===================================================== */

        .design-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .design-action {
            min-height: 115px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 9px;

            background: #f7f4ef;
            border: 1px dashed rgba(23,23,23,.25);
            border-radius: 16px;

            cursor: pointer;

            transition: .2s ease;
        }

        .design-action:hover {
            border-color: #9c88b5;
            background: #f1eaf6;
        }

        .design-action i {
            font-size: 25px;
        }

        .design-action strong {
            font-family: "Inter", sans-serif;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .design-action span {
            font-size: 11px;
            color: #777;
        }

        /* =====================================================
           PLACEMENT
        ===================================================== */

        .placement-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .placement-option {
            padding: 14px 10px;

            border: 1px solid rgba(23,23,23,.12);
            border-radius: 12px;
            background: #f7f4ef;

            text-align: center;

            font-family: "Inter", sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;

            cursor: pointer;
        }

        .placement-option.active {
            background: #171717;
            color: #fff;
            border-color: #171717;
        }

        /* =====================================================
           DECORATION
        ===================================================== */

        .decoration-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .decoration-option {
            padding: 17px;

            border: 1px solid rgba(23,23,23,.12);
            border-radius: 13px;
            background: #f7f4ef;

            cursor: pointer;
        }

        .decoration-option strong {
            display: block;
            margin-bottom: 4px;

            font-family: "Inter", sans-serif;
            font-size: 12px;
            text-transform: uppercase;
        }

        .decoration-option span {
            font-size: 11px;
            color: #777;
        }

        .decoration-option.active {
            border-color: #9c88b5;
            background: #f1eaf6;
        }

        /* =====================================================
           RIGHT — LIVE PREVIEW
        ===================================================== */

        .custom-preview-wrapper {
            position: sticky;
            top: 135px;
        }

        .custom-preview {
            background: #dcd2c5;
            border-radius: 28px;
            min-height: 620px;

            padding: 35px;

            display: flex;
            flex-direction: column;

            box-shadow:
                0 20px 55px rgba(23,23,23,.1);

            overflow: hidden;
        }

        .preview-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-label {
            font-family: "Inter", sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .preview-status {
            display: flex;
            align-items: center;
            gap: 7px;

            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .preview-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #79a883;
        }

        /* =====================================================
           CAP PREVIEW
        ===================================================== */

        .cap-preview-area {
            flex: 1;
            min-height: 400px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cap-preview-area img {
            width: min(100%, 520px);
            max-height: 390px;
            object-fit: contain;

            filter:
                drop-shadow(0 25px 25px rgba(0,0,0,.18));

            transition: .3s ease;
        }

        .preview-placeholder {
            width: 80%;
            max-width: 450px;
            aspect-ratio: 1.2;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px dashed rgba(23,23,23,.25);
            border-radius: 22px;

            color: #777;
            text-align: center;
        }

        .preview-placeholder div {
            max-width: 220px;
        }

        .preview-placeholder i {
            display: block;
            font-size: 42px;
            margin-bottom: 12px;
        }

        .preview-placeholder strong {
            display: block;
            font-family: "Space Grotesk", sans-serif;
            text-transform: uppercase;
            font-size: 15px;
        }

        .preview-placeholder span {
            display: block;
            margin-top: 6px;
            font-size: 11px;
        }

        /* =====================================================
           SUMMARY
        ===================================================== */

        .preview-summary {
            padding-top: 25px;
            border-top: 1px solid rgba(23,23,23,.12);
        }

        .preview-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .preview-summary-row span {
            font-size: 12px;
            color: #666;
        }

        .preview-summary-row strong {
            font-size: 12px;
        }

        .preview-total {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-top: 17px;
        }

        .preview-total span {
            font-family: "Inter", sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .preview-total strong {
            font-family: "Space Grotesk", sans-serif;
            font-size: 26px;
        }

        .custom-add-cart {
            width: 100%;
            margin-top: 20px;

            border: none;
            border-radius: 13px;

            padding: 17px 20px;

            background: #171717;
            color: #fff;

            font-family: "Inter", sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;

            cursor: pointer;
            transition: .2s ease;
        }

        .custom-add-cart:hover {
            transform: translateY(-2px);
            background: #9c88b5;
        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 950px) {

            .custom-builder {
                grid-template-columns: 1fr;
            }

            .custom-preview-wrapper {
                position: relative;
                top: auto;
                order: -1;
            }

            .custom-preview {
                min-height: 520px;
            }
        }

        @media (max-width: 600px) {

            .custom-page {
                padding-top: 100px;
            }

            .custom-intro {
                padding: 50px 20px 30px;
            }

            .custom-intro h1 {
                font-size: 52px;
            }

            .custom-builder {
                padding: 15px 20px 70px;
            }

            .custom-step {
                padding: 20px;
                border-radius: 18px;
            }

            .cap-types {
                grid-template-columns: repeat(2, 1fr);
            }

            .design-actions {
                grid-template-columns: 1fr;
            }

            .placement-options {
                grid-template-columns: 1fr 1fr;
            }

            .decoration-options {
                grid-template-columns: 1fr;
            }

            .custom-preview {
                min-height: 450px;
                padding: 22px;
                border-radius: 22px;
            }

            .cap-preview-area {
                min-height: 280px;
            }
        }

        /* =====================================================
           DARK MODE
        ===================================================== */

        body.dark-mode .custom-page {
            background: #121212;
        }

        body.dark-mode .custom-intro h1,
        body.dark-mode .step-heading h2 {
            color: #f7f4ef;
        }

        body.dark-mode .custom-step {
            background: #1c1c1c;
            border-color: rgba(255,255,255,.08);
        }

        body.dark-mode .cap-type,
        body.dark-mode .design-action,
        body.dark-mode .placement-option,
        body.dark-mode .decoration-option {
            background: #242424;
            border-color: rgba(255,255,255,.1);
            color: #fff;
        }

        body.dark-mode .cap-type-name {
            color: #fff;
        }

        body.dark-mode .custom-preview {
            background: #202020;
            color: #fff;
        }

        body.dark-mode .preview-summary {
            border-color: rgba(255,255,255,.1);
        }

        body.dark-mode .preview-summary-row span {
            color: #aaa;
        }

        body.dark-mode .custom-add-cart {
            background: #f7f4ef;
            color: #171717;
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>


<main class="custom-page">

    <!-- =====================================================
         INTRO
    ====================================================== -->

    <section class="custom-intro">

        <p class="custom-label">
            TOPSYNO / CUSTOM STUDIO
        </p>

        <h1>
            MAKE IT <span>YOURS.</span>
        </h1>

        <p>
            Choose your cap, pick your colors, add your design
            and create something that feels like you.
        </p>

    </section>


    <!-- =====================================================
         CUSTOMIZER
    ====================================================== -->

    <section class="custom-builder">


        <!-- =================================================
             LEFT — CUSTOMIZATION OPTIONS
        ================================================== -->

        <div class="custom-options">


            <!-- STEP 01 -->
            <div class="custom-step">

                <div class="step-heading">
                    <span class="step-number">01</span>

                    <h2>
                        Choose Your Cap
                    </h2>
                </div>

                <p class="step-description">
                    Start with the silhouette you want.
                </p>


                <div class="cap-types">

                    <button class="cap-type active" type="button">

                        <img
                            src="images/cap-black.png"
                            alt="Classic cap"
                        >

                        <span class="cap-type-name">
                            Classic
                        </span>

                    </button>


                    <button class="cap-type" type="button">

                        <img
                            src="images/cap-trucker.png"
                            alt="Trucker cap"
                        >

                        <span class="cap-type-name">
                            Trucker
                        </span>

                    </button>


                    <button class="cap-type" type="button">

                        <img
                            src="images/cap-snapback.png"
                            alt="Snapback cap"
                        >

                        <span class="cap-type-name">
                            Snapback
                        </span>

                    </button>


                    <button class="cap-type" type="button">

                        <img
                            src="images/cap-dad.png"
                            alt="Dad cap"
                        >

                        <span class="cap-type-name">
                            Dad Cap
                        </span>

                    </button>


                    <button class="cap-type" type="button">

                        <img
                            src="images/cap-bucket.png"
                            alt="Bucket hat"
                        >

                        <span class="cap-type-name">
                            Bucket
                        </span>

                    </button>


                    <button class="cap-type" type="button">

                        <img
                            src="images/cap-beanie.png"
                            alt="Beanie"
                        >

                        <span class="cap-type-name">
                            Beanie
                        </span>

                    </button>

                </div>

            </div>


            <!-- STEP 02 -->
            <div class="custom-step">

                <div class="step-heading">
                    <span class="step-number">02</span>

                    <h2>
                        Choose Your Color
                    </h2>
                </div>


                <div class="color-options">

                    <button
                        class="color-option color-black active"
                        aria-label="Black"
                        type="button">
                    </button>

                    <button
                        class="color-option color-white"
                        aria-label="White"
                        type="button">
                    </button>

                    <button
                        class="color-option color-brown"
                        aria-label="Brown"
                        type="button">
                    </button>

                    <button
                        class="color-option color-navy"
                        aria-label="Navy"
                        type="button">
                    </button>

                    <button
                        class="color-option color-forest"
                        aria-label="Forest"
                        type="button">
                    </button>

                    <button
                        class="color-option color-chocolate"
                        aria-label="Chocolate"
                        type="button">
                    </button>

                    <button
                        class="color-option color-lavender"
                        aria-label="Lavender"
                        type="button">
                    </button>

                    <button
                        class="color-option color-mint"
                        aria-label="Mint"
                        type="button">
                    </button>

                </div>

            </div>


            <!-- STEP 03 -->
            <div class="custom-step">

                <div class="step-heading">
                    <span class="step-number">03</span>

                    <h2>
                        Add Your Design
                    </h2>
                </div>

                <p class="step-description">
                    Upload your logo or create your own lettering.
                </p>


                <div class="design-actions">

                    <button
                        class="design-action"
                        type="button">

                        <i class="bi bi-cloud-arrow-up"></i>

                        <strong>
                            Upload Logo
                        </strong>

                        <span>
                            PNG, JPG or SVG
                        </span>

                    </button>


                    <button
                        class="design-action"
                        type="button">

                        <i class="bi bi-type"></i>

                        <strong>
                            Add Text
                        </strong>

                        <span>
                            Create custom lettering
                        </span>

                    </button>

                </div>

            </div>


            <!-- STEP 04 -->
            <div class="custom-step">

                <div class="step-heading">
                    <span class="step-number">04</span>

                    <h2>
                        Placement
                    </h2>
                </div>


                <div class="placement-options">

                    <button
                        class="placement-option active"
                        type="button">
                        Front
                    </button>

                    <button
                        class="placement-option"
                        type="button">
                        Side
                    </button>

                    <button
                        class="placement-option"
                        type="button">
                        Back
                    </button>

                    <button
                        class="placement-option"
                        type="button">
                        Left Side
                    </button>

                    <button
                        class="placement-option"
                        type="button">
                        Right Side
                    </button>

                    <button
                        class="placement-option"
                        type="button">
                        All Over
                    </button>

                </div>

            </div>


            <!-- STEP 05 -->
            <div class="custom-step">

                <div class="step-heading">
                    <span class="step-number">05</span>

                    <h2>
                        Decoration
                    </h2>
                </div>


                <div class="decoration-options">

                    <button
                        class="decoration-option active"
                        type="button">

                        <strong>
                            Embroidery
                        </strong>

                        <span>
                            Clean stitched finish
                        </span>

                    </button>


                    <button
                        class="decoration-option"
                        type="button">

                        <strong>
                            Embroidered Patch
                        </strong>

                        <span>
                            Raised custom patch
                        </span>

                    </button>


                    <button
                        class="decoration-option"
                        type="button">

                        <strong>
                            3D Patch
                        </strong>

                        <span>
                            Bold raised finish
                        </span>

                    </button>


                    <button
                        class="decoration-option"
                        type="button">

                        <strong>
                            Printed Design
                        </strong>

                        <span>
                            Full-color artwork
                        </span>

                    </button>

                </div>

            </div>

        </div>


        <!-- =================================================
             RIGHT — LIVE PREVIEW
        ================================================== -->

        <aside class="custom-preview-wrapper">

            <div class="custom-preview">

                <div class="preview-top">

                    <span class="preview-label">
                        LIVE PREVIEW
                    </span>

                    <span class="preview-status">

                        <span class="preview-status-dot"></span>

                        Your Design

                    </span>

                </div>


                <div class="cap-preview-area">

                    <!-- Temporary placeholder.
                         Real cap preview comes with JS. -->

                    <div class="preview-placeholder">

                        <div>

                            <i class="bi bi-bag-heart"></i>

                            <strong>
                                Your Cap
                            </strong>

                            <span>
                                Your selected cap will
                                appear here.
                            </span>

                        </div>

                    </div>

                </div>


                <div class="preview-summary">

                    <div class="preview-summary-row">

                        <span>
                            Cap
                        </span>

                        <strong>
                            Classic Cap
                        </strong>

                    </div>


                    <div class="preview-summary-row">

                        <span>
                            Color
                        </span>

                        <strong>
                            Black
                        </strong>

                    </div>


                    <div class="preview-summary-row">

                        <span>
                            Decoration
                        </span>

                        <strong>
                            Embroidery
                        </strong>

                    </div>


                    <div class="preview-total">

                        <span>
                            Estimated Total
                        </span>

                        <strong>
                            ₦25,000
                        </strong>

                    </div>


                    <button
                        class="custom-add-cart"
                        type="button">

                        ADD CUSTOM CAP TO CART
                        <i class="bi bi-arrow-right"></i>

                    </button>

                </div>

            </div>

        </aside>

    </section>

</main>


<?php include 'footer.php'; ?>


<script src="js/app.js"></script>
<script src="script.js"></script>

</body>
</html>