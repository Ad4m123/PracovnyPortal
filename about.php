<?php include_once "parts/head.php" ?>
    
    <body class="about-page" id="top">

    <?php
    $activePage = 'about';
    include_once('parts/nav.php');
    ?>

        <main>

            <header class="site-header">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-12 col-12 text-center">
                            <h1 class="text-white">About Gotto</h1>

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">About</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                </div>
            </header>


            <section class="about-section">
                <div class="container">
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-5 col-12">
                            <div class="about-info-text">
                                <h2 class="mb-0">Introducing Gotto Job</h2>

                                <h4 class="mb-2">Get hired. Get your new job</h4>

                                <p>Thank you for visiting our Gotto Job website. Are you looking for best HTML templates? Please visit Tooplate website to download free templates.</p>

                                <div class="d-flex align-items-center mt-4">
                                    <a href="#services-section" class="custom-btn custom-border-btn btn me-4">Explore Services</a>

                                    <a href="contact.php" class="custom-link smoothscroll">Contact</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12 mt-5 mt-lg-0">
                            <div class="about-image-wrap">
                                <img src="images/horizontal-shot-happy-mixed-race-females.jpg" class="about-image about-image-border-radius img-fluid" alt="">

                                <div class="about-info d-flex">
                                    <h4 class="text-white mb-0 me-2">20</h4>

                                    <p class="text-white mb-0">years of experience</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="services-section section-padding" id="services-section">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">We deliver best services</h2>
                        </div>

                        <div class="services-block-wrap col-lg-4 col-md-6 col-12">
                            <div class="services-block">
                                <div class="services-block-title-wrap">
                                    <i class="services-block-icon bi-window"></i>
                                
                                    <h4 class="services-block-title">Website design</h4>
                                </div>

                                <div class="services-block-body">
                                    <p>Tooplate provides a variety of free Bootstrap 5 website templates for your commercial or business websites.</p>
                                </div>
                            </div>
                        </div>

                        <div class="services-block-wrap col-lg-4 col-md-6 col-12 my-4 my-lg-0 my-md-0">
                            <div class="services-block">
                                <div class="services-block-title-wrap">
                                    <i class="services-block-icon bi-twitch"></i>
                                
                                    <h4 class="services-block-title">Marketing</h4>
                                </div>

                                <div class="services-block-body">
                                    <p>You can download any free template for your website. Please tell your friends about Tooplate.</p>
                                </div>
                            </div>
                        </div>

                        <div class="services-block-wrap col-lg-4 col-md-6 col-12">
                            <div class="services-block">
                                <div class="services-block-title-wrap">
                                    <i class="services-block-icon bi-play-circle-fill"></i>
                                
                                    <h4 class="services-block-title">Video</h4>
                                </div>

                                <div class="services-block-body">
                                    <p>You are not allowed to redistribute the template ZIP file on any other template collection website.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <?php include_once "parts/reviews.php"; ?>

        </main>

        <?php
        $file_path = "parts/footer.php";
        if(!include_once($file_path)) {
            echo"Failed to include $file_path";
        }
        ?>


    </body>
</html>
