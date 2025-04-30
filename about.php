<?php
// Start session for potential future functionality
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOOD&ORGAN-DONATION | ABOUT US</title>
    <link rel="stylesheet" href="./footer.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./nav.css">
    <link rel="stylesheet" href="./sidebar.css">
    <link rel="shortcut icon" href="./photos/LOGO.webp" type="image/x-icon">
</head>
<body>
    <!-- nav bar start -->
    <nav class="nav-container">
        <div class="nav-center wrapper">
            <div class="logo-section">
                <a href="./home.php">
                    <img src="./photos/LOGO.webp" alt="Blood and Organ Donation Logo" class="logo">
                </a>
            </div>
            <div class="hamburger">
                <img src="./icons/button.png" alt="Open sidebar menu">
            </div>
            <div class="nav-links-main">
                <div class="nav-links">
                    <li><a href="./home.php" class="nav-link">HOME</a></li>
                    <li><a href="./Donate.php" class="nav-link">DONATE</a></li>
                    <li><a href="./about.php" class="nav-link active">ABOUT</a></li>
                    <li><a href="./contact.php" class="nav-link">CONTACT</a></li>
                </div>
            </div>
            <div class="nav-social-links-main">
                <div class="nav-social-links">
                    <li class="nav-social-link">
                        <a href="https://web.whatsapp.com/" aria-label="WhatsApp">
                            <img src="./photos/whatapp.png" alt="WhatsApp icon">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.youtube.com/" aria-label="YouTube">
                            <img src="./photos/youtube.png" alt="YouTube icon">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.facebook.com/home.php" aria-label="Facebook">
                            <img src="./photos/facebook.png" alt="Facebook icon">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.instagram.com/accounts/login/?hl=en" aria-label="Instagram">
                            <img src="./photos/insta .png" alt="Instagram icon">
                        </a>    
                    </li>
                </div>
            </div>
        </div>
    </nav>
    <!-- nav bar ends -->

    <!-- side bar begins-->
    <aside class="sidebar-container">
        <div class="sidebar-center wrapper">
            <div class="side-header">
                <div class="logo-section">
                    <a href="./home.php"><img src="./icons/uni.png" alt="Organization logo"></a>
                </div>
                <div class="close-button">
                    <img src="./icons/closebar.png" alt="Close sidebar">
                </div>
            </div>
            <div class="sidebar-content paddingtopmobile-fifty">
                <div class="sidebar-links-main">
                    <ul class="sidebar-links">
                        <li><a href="./home.php" class="nav-link">HOME</a></li>
                        <li><a href="./Donate.php" class="nav-link">DONATE</a></li>
                        <li><a href="./about.php" class="nav-link active">ABOUT</a></li>
                        <li><a href="./contact.php" class="nav-link">CONTACT</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- side bar ends -->

    <!-- hero section start -->
    <div class="page-hero-container">
        <div class="page-hero">
            <div class="hero-img-component">
                <div class="img-container">
                    <img src="./photos/rrr.jpg" alt="Blood donation hero image">
                </div>
            </div>
            <div class="hero-box paddingbottommobile-thirty paddingtopmobile-thirty">
                <div class="hero-content text-center wrapper psddiingtopmobile-thirty paddingbottommobile-thirty">
                    <h1 class="heading">BLOOD&ORGAN-DONATION</h1>
                    <div class="small-heading">Donate - Be a hero for others</div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero section end -->

    <!-- about us container start -->
    <div class="single-featured-container light-blue-background reverse-content">
        <div class="single-featured-center wrapper">
            <div class="section-tittle text-center paddingtopdesktop-hunderd paddingbottomdesktop-fifty paddingtopmobile-fifty paddingbottommobile-fourty">
                <h2 class="tittle paddingbottomdesktop-twenty paddingbottommobile-twenty">About Us</h2>
                <div class="underline"></div>
            </div>
            <div class="single-featured">
                <div class="image-component single-featured-image paddingbottommobile-fourty">
                    <img src="./photos/back.jpg" alt="About our organization">
                </div>
                <div class="single-featured-text-component">
                    <div class="featured-center">
                        <div class="about-info">
                            <?php
                            // About content stored in variables for easy management
                            $bloodDonationContent = "Blood donation and organ donation are life-saving acts of generosity that help millions of people worldwide. Blood donation involves voluntarily giving blood, which is used in transfusions for accident victims, surgical patients, individuals with anemia, and those undergoing cancer treatment. There are different types of blood donation, including whole blood, platelet, plasma, and double red cell donation.";
                            
                            $organDonationContent = "Organ donation, on the other hand, involves donating an organ or tissue to a person in need of a transplant. It can be done while alive, such as donating a kidney or part of the liver, or after death, where multiple organs like the heart, lungs, pancreas, and intestines can be transplanted. Tissues such as corneas, skin, and bones can also be donated to help improve lives.";
                            
                            $donorBenefits = "Besides saving lives, blood donation also benefits the donor by promoting new blood cell production and reducing the risk of certain health conditions. Organ donation is crucial as it provides a second chance at life for patients suffering from organ failure.";
                            
                            $eligibility = [
                                "Anyone can register as a donor",
                                "Living donors must meet medical criteria",
                                "Deceased donors must be declared brain dead by doctors"
                            ];
                            ?>
                            
                            <p><?php echo $bloodDonationContent; ?></p>
                            <p><?php echo $organDonationContent; ?></p>
                            <p><?php echo $donorBenefits; ?></p>
                            
                            <h2 style="color: red;">Who Can Donate?</h2>
                            <ul style="color: red;">
                                <?php foreach ($eligibility as $item): ?>
                                    <li><?php echo $item; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about us container end -->

    <!-- registration promotion section start -->
    <div class="contact-promotion-container light-pink-background paddingbottomdesktop-fifty paddingbottommobile-fourty">
        <div class="contact-promotion text-center wrapper">
            <div class="section-title paddingbottomdesktop-fifty paddingtopdesktop-hunderd paddingtopmobile-thrity paddingbottommobile-thrity">
                <h2 class="title paddingbottomdesktop-twenty paddingbottommobile-thrity">Register to Donate</h2>
                <div class="underline pad"></div>
            </div>
            <section class="contact-promotion">
                <div class="contact-promo">
                    <img src="./photos/ab.jpeg" alt="Registration promotion">
                    <div class="contact-info-container text-center .text-container paddingtopdesktop-hunderd paddingbottomdesktop-fifty paddingtopmobile-fifty">
                        <h3 class="text-heading">Join our community of life-savers across India</h3>
                        <br>
                        <a href="./contact.php" class="button-dark">CONTACT US</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- registration promotion section end -->

    <!-- footer start -->
    <footer class="footer-container">
        <div class="footer-center wrapper">
            <div class="footer-links-main">
                <ul class="footer-links">
                    <li><a href="./home.php" class="footer-link">HOME</a></li>
                    <li><a href="./Donate.php" class="footer-link">DONATE</a></li>
                    <li><a href="./about.php" class="footer-link active">ABOUT</a></li>
                    <li><a href="./contact.php" class="footer-link">CONTACT</a></li>
                </ul>
            </div>
            <div class="social-links-main">
                <ul class="social-links">
                    <li class="social-link"><a href="https://web.whatsapp.com/" aria-label="WhatsApp"><img src="./photos/whatapp.png" alt="WhatsApp"></a></li>
                    <li class="social-link"><a href="https://www.youtube.com/" aria-label="YouTube"><img src="./photos/youtube.png" alt="YouTube"></a></li>
                    <li class="social-link"><a href="https://www.facebook.com/home.php" aria-label="Facebook"><img src="./photos/facebook.png" alt="Facebook"></a></li>
                    <li class="social-link"><a href="https://www.instagram.com/accounts/login/?hl=en" aria-label="Instagram"><img src="./photos/insta .png" alt="Instagram"></a></li>
                </ul>
            </div>
            <div class="footer-copy-right">
                <p>Copyright &copy; <span class="copyright-date"><?php echo date('Y'); ?></span>, All rights reserved</p>
            </div>
        </div>
    </footer>
    <!-- footer ends -->
    
    <script src="./d.js"></script>
</body>
</html>