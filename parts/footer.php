<?php
// Dynamické určenie základnej cesty
$basePath = file_exists('js/jquery.min.js') ? '' : '../';
?>

<footer class="site-footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="d-flex align-items-center mb-4">
                    <img src="<?= $basePath ?>images/logo.png" class="img-fluid logo-image">

                    <div class="d-flex flex-column">
                        <strong class="logo-text">Gotto</strong>
                        <small class="logo-slogan">Online Job Portal</small>
                    </div>
                </div>

                <p class="mb-2">
                    <i class="custom-icon bi-globe me-1"></i>

                    <a href="#" class="site-footer-link">
                        www.jobbportal.com
                    </a>
                </p>

                <p class="mb-2">
                    <i class="custom-icon bi-telephone me-1"></i>

                    <a href="tel: 305-240-9671" class="site-footer-link">
                        305-240-9671
                    </a>
                </p>

                <p>
                    <i class="custom-icon bi-envelope me-1"></i>

                    <a href="mailto:info@yourgmail.com" class="site-footer-link">
                        info@jobportal.co
                    </a>
                </p>

            </div>

            <div class="col-lg-2 col-md-3 col-6 ms-lg-auto">
                <h6 class="site-footer-title">Company</h6>

                <ul class="footer-menu">
                    <li class="footer-menu-item"><a href="<?= $basePath ?>about.php" class="footer-menu-link">About</a></li>

                    <li class="footer-menu-item"><a href="<?= $basePath ?>job-listings.php" class="footer-menu-link">Jobs</a></li>

                    <li class="footer-menu-item"><a href="<?= $basePath ?>contact.php" class="footer-menu-link">Contact</a></li>

                    <li class="footer-menu-item"><a href="<?= $basePath ?>rating.php" class="footer-menu-link">Rate Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="site-footer-title">Resources</h6>

                <ul class="footer-menu">
                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">Guide</a></li>

                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">How it works</a></li>

                    <li class="footer-menu-item"><a href="#" class="footer-menu-link">Salary Tool</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-8 col-12 mt-3 mt-lg-0">
                <h6 class="site-footer-title">Newsletter</h6>

                <form class="custom-form newsletter-form" action="#" method="post" role="form">
                    <h6 class="site-footer-title">Get notified jobs news</h6>

                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi-person"></i></span>

                        <input type="text" name="newsletter-name" id="newsletter-name" class="form-control" placeholder="yourname@gmail.com" required>

                        <button type="submit" class="form-control">
                            <i class="bi-send"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="site-footer-bottom">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-12 d-flex align-items-center">
                    <p class="copyright-text">Copyright © Gotto Job 2048</p>

                    <ul class="footer-menu d-flex">
                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Privacy Policy</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Terms</a></li>
                    </ul>
                </div>

                <div class="col-lg-5 col-12 mt-2 mt-lg-0">
                    <ul class="social-icon">
                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-twitter"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-facebook"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-linkedin"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-instagram"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-youtube"></a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-12 mt-2 d-flex align-items-center mt-lg-0">
                    <p>Design: <a class="sponsored-link" rel="sponsored" href="https://www.tooplate.com" target="_blank">Tooplate</a></p>
                </div>

                <a class="back-top-icon bi-arrow-up smoothscroll d-flex justify-content-center align-items-center" href="#top"></a>

            </div>
        </div>
    </div>
</footer>

<!-- JAVASCRIPT FILES -->
<script src="<?= $basePath ?>js/jquery.min.js"></script>
<script src="<?= $basePath ?>js/bootstrap.min.js"></script>
<script src="<?= $basePath ?>js/owl.carousel.min.js"></script>
<script src="<?= $basePath ?>js/counter.js"></script>
<script src="<?= $basePath ?>js/custom.js"></script>