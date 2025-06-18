<?php include_once "parts/head.php" ?>
    
    <body id="top">

    <?php
    $activePage = 'contact';
    $pageTitle = 'Contact us';
    $breadcrumbs = [
        ['title' => 'Home', 'link' => 'index.php', 'active' => false],
        ['title' => 'Contact', 'link' => '', 'active' => true]
    ];
    include_once('parts/nav.php');
    ?>

        <main>

            <?php include_once "parts/header.php"; ?>


            <section class="contact-section section-padding">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-6 col-12 mb-lg-5 mb-3">
                            <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4722.136219194832!2d10.772202738834757!3d59.917660271855105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46416fa8eba7e84d%3A0xf4e943975503fa30!2sUrtehagen%20(herb%20garden)!5e1!3m2!1sen!2sth!4v1680951932259!5m2!1sen!2sth" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="col-lg-5 col-12 mb-3 mx-auto">
                            <div class="contact-info-wrap">
                                <div class="contact-info d-flex align-items-center mb-3">
                                    <i class="custom-icon bi-building"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Office</span>

                                        Akershusstranda 20, 0150 Oslo, Norway
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-globe"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Website</span>

                                        <a href="#" class="site-footer-link">
                                            www.jobportal.co
                                        </a>
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-telephone"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Phone</span>

                                        <a href="tel: 305-240-9671" class="site-footer-link">
                                            305-240-9671
                                        </a>
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-envelope"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Email</span>

                                        <a href="mailto:info@yourgmail.com" class="site-footer-link">
                                            info@jobportal.co
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php
        $file_path = "parts/footer.php";
        if(!include_once($file_path)) {
            echo"Failed to include $file_path";
        }
        ?>


    </body>
</html>
