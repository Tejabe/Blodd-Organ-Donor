<?php
session_start();

// Handle logout request
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOOD&ORGAN-DONAR</title>
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./sidebar.css">
    <link rel="stylesheet" href="./footer.css">
    <link rel="stylesheet" href="./nav.css">
    <link rel="shortcut icon" href="./photos/LOGO.webp" type="image/x-icon">
</head>
<body>
    <!-- nav bar start -->
    <nav class="nav-container">
        <div class="nav-center wrapper">
            <div class="logo-section">
                <a href="./home.php">
                    <img src="./photos/LOGO.webp" alt="universitylogo" class="logo">
                </a>
            </div>
            <div class="hamburger">
                <img src="./photos/button.png" alt="sidebaropen">
            </div>
            <div class="nav-links-main">
                <div class="nav-links">
                    <li><a href="./home.php" class="nav-link active">home</a></li>
                    <li><a href="./Donate.php" class="nav-link">Donate</a></li>
                    <li><a href="./about.php" class="nav-link">About</a></li>
                    <li><a href="./contact.php" class="nav-link">contact</a></li>
                </div>
            </div>
            <div class="nav-social-links-main">
                <div class="nav-social-links">
                    <li class="nav-social-link">
                        <a href="https://web.whatsapp.com/">
                            <img src="./photos/whatapp.png" alt="whataapp">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.youtube.com/">
                            <img src="./photos/youtube.png" alt="youtube">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.facebook.com/home.php">
                            <img src="./photos/facebook.png" alt="facebook">
                        </a>    
                    </li>
                    <li class="nav-social-link">
                        <a href="https://www.instagram.com/accounts/login/?hl=en">
                            <img src="./photos/insta .png" alt="instagram">
                        </a>    
                    </li>
                    <!-- Your existing social links -->
                    <li class="nav-social-link">
                        <?php if ($isLoggedIn): ?>
                            <!-- <span class="welcome-message">Welcome, <?php echo htmlspecialchars($username); ?></span> -->
                            <!-- Changed logout link to use query parameter -->
                            <a href="?logout=1" class="login-button">Logout</a>
                        <?php else: ?>
                            <a href="./login.php" class="login-button">Login</a>
                        <?php endif; ?>
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
                    <a href="./SRM.php"><img src="./icons/uni.png" alt="university"></a>
                </div>
                <div class="close-button">
                    <img src="./icons/closebar.png" alt="closebutton">
                </div>
            </div>
            <div class="sidebar-content paddingtopmobile-fifty">
                <div class="sidebar-links-main">
                    <ul class="sidebar-links">
                        <li><a href="./SRM.php" class="nav-link active">HOME</a></li>
                        <li><a href="./Donate.php" class="nav-link">DONATE</a></li>
                        <li><a href="./about.php" class="nav-link">ABOUT</a></li>
                        <li><a href="./contact.php" class="nav-link">CONTACT</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- side bar ends -->

    <!-- hero section start -->
    <div class="home-page page-hero-container">
        <div class="page-hero">
            <div class="hero-img-component">
                <div class="img-container">
                    <img src="./photos/back.jpg" alt="university hero">
                </div>
            </div>
            <div class="hero-box paddingbottommobile-thirty paddingtopmobile-thirty">
                <div class="hero-content text-center wrapper paddingbottommobile-thirty paddingtopmobile-thirty">
                    <h1 class="heading" style="text-shadow: 2px 2px 5px black;">BLOOD&ORGAN-DONATION</h1>
                    <?php if ($isLoggedIn): ?>
                        <div class="welcome-container">
                            <p class="welcome-message-large">Welcome back, <?php echo htmlspecialchars($username); ?>!</p>
                            <p class="welcome-subtext">Thank you for being a life saver</p>
                        </div>
                    <?php endif; ?>
                    <div class="quote-container">
                        <?php
                        $quotes = [
                            "Be a hero twice—donate blood today, and your organs for tomorrow.",
                            "A drop of blood, an organ of hope—both can save lives.",
                            "Give blood, give organs, give life",
                            "Live by giving, leave by saving—donate blood and organs",
                            "One donation today, a lifetime saved tomorrow",
                            "The best gift is the gift of life—donate blood, donate organs",
                            "Your body can save more lives than you ever imagined"
                        ];
                        
                        foreach ($quotes as $index => $quote) {
                            $active = $index === 0 ? 'active' : '';
                            echo "<div class='quote $active'>$quote</div>";
                        }
                        ?>
                    </div>
                    <div class="button-container">
                        <a href="./Donate.php" class="home-button button-light">get started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero section end -->

    <!-- CAMPAIGNS START -->
    <div class="featured-courses-container light-blue-background">
        <div class="featured-courses-center wrapper">
            <!-- Section Title -->
            <div class="section-title text-center" style="padding: 25px 25px 25px 25px;">
                <h2 class="title padding-bottom-desktop-20 padding-bottom-mobile-30">Campaign</h2>
                <div class="underline"></div>
            </div>
    
            <!-- Campaigns Section -->
            <section class="section featured-courses padding-top-desktop-50 padding-bottom-desktop-50 padding-top-mobile-40 padding-bottom-mobile-40 three-column-layout">
                <div class="scroll-container">
                    <div class="image-wrapper">
                        <?php
                        $campaignImages = [
                            'cam-1.jpg', 'cam-2.webp', 'cam-3.png', 'cam-4.jpg',
                            'cam-5.jpg', 'cam-6.jpeg', 'cam-7.avif', 'cam-8.jpg',
                            'cam-9.jpg', 'cam-10.avif'
                        ];
                        
                        foreach ($campaignImages as $image) {
                            echo "<img src='./photos/$image' alt='Campaign image' width='400' height='500'>";
                        }
                        ?>
                    </div>
                </div>
            </section>    
            <!-- View All Button -->
            <div class="text-center" style="padding: 25px 25px 25px 25px;">
                <a href="#" class="button-dark">View All</a>
            </div>
        </div>
    </div>
    <!-- CAMPAIGNS END -->

    <!-- Why Donate Section -->
    <div class="our-campases-container light-pink-background">
        <div class="our-campases-center wrapper">
            <div class="section-tittle paddingtopdesktop-hunderd paddingtopmobile-fifty">
                <h2 class="title text-center paddingbottomdesktop-twenty paddingbottommobile-thrity">Why Should you Donate ?🤔</h2>
                <div class="underline"></div>
            </div>
            <section class="our-campases paddingtopdesktop-fifty paddingtopmobile-fifty paddingbottomdesktop-hundered paddingbottommobile-fourty three-coloum-layout">
                <?php
                $donationBenefits = [
                    ['image' => 'b-3.jpeg', 'text' => 'Helps manage weight', 'link' => 'info.php'],
                    ['image' => 'b-4.jpeg', 'text' => 'Improves blood flow', 'link' => 'info.php'],
                    ['image' => 'b-2.jpeg', 'text' => 'Saves lives', 'link' => 'info.php'],
                    ['image' => 'b-1.jpeg', 'text' => 'Heart health', 'link' => 'info.php']
                ];
                
                foreach ($donationBenefits as $benefit) {
                    echo "
                    <article class='each-campus'>
                        <div class='img-container'>
                            <a href='{$benefit['link']}'><img src='./photos/{$benefit['image']}' alt='Donation benefit'></a>
                        </div>
                        <div class='campus-name'>
                            <p>{$benefit['text']}</p>
                        </div>
                    </article>";
                }
                ?>
            </section>
        </div>
    </div>
    <!-- Why Donate Section End -->

    <!-- Contact Promotion Section -->
    <div class="contact-promotion-container light-pink-background paddingbottomdesktop-fifty paddingbottommobile-fourty">
        <div class="contact-promotion text-center wrapper">
            <div class="section-title paddingbottomdesktop-fifty paddingtopdesktop-hunderd paddingtopmobile-thrity paddingbottommobile-thrity">
                <h2 class="title paddingbottomdesktop-twenty paddingbottommobile-thrity" style="color: #ed1b24;">Contact-Us To Donate</h2>
                <div class="underline pad"></div>
            </div>
            <section class="contact-promotion">
                <div class="contact-promo">
                    <img src="./photos/erp.jpg" alt="contact-promotion">
                    <div class="contact-info-container text-center .text-container paddingtopdesktop-hunderd paddingbottomdesktop-fifty paddingtopmobile-fifty">
                        <h3 class="text-heading" style="color: #f8a9ac;">"Don't let your organs go to waste,let them save lifes"</h3>
                        <br>
                        <a href="./contact.php" class="button-dark">CONTACT</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Contact Promotion Section End -->

    <!-- footer start -->
    <footer class="footer-container">
        <div class="footer-center wrapper">
            <div class="footer-links-main">
                <ul class="footer-links">
                    <li><a href="./SRM.php" class="footer-link active">HOME</a></li>
                    <li><a href="./Donate.php" class="footer-link">DONATE</a></li>
                    <li><a href="./about.php" class="footer-link">ABOUT</a></li>
                    <li><a href="./contact.php" class="footer-link">CONTACT</a></li>
                </ul>
            </div>
            <div class="social-links-main">
                <ul class="social-links">
                    <li class="social-link"><a href="https://web.whatsapp.com/"><img src="./photos/whatapp.png" alt="whatapp"></a></li>
                    <li class="social-link"><a href="https://www.youtube.com/"><img src="./photos/youtube.png" alt="youtube"></a></li>
                    <li class="social-link"><a href="https://www.facebook.com/home.php"><img src="./photos/facebook.png" alt="facebook"></a></li>
                    <li class="social-link"><a href="https://www.instagram.com/accounts/login/?hl=en"><img src="./photos/insta .png" alt="instagram"></a></li>
                </ul>
            </div>
            <div class="footer-copy-right">
                <p>copy right <span class="copyright-date">@ <?php echo date('Y'); ?></span>, done by </p>
            </div>
        </div>
    </footer>
    <!-- footer ends -->

    

    <style>
        /* Add these styles to your home.css or in the head section */
        .welcome-message {
            color: white;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .welcome-message-large {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
        }
        
        .welcome-subtext {
            color: #f8a9ac;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
        
        .welcome-container {
            margin: 20px 0;
        }
    </style>

    <script src="./d.js"></script>
    <script>
        let quotes = document.querySelectorAll(".quote");
        let index = 0;

        function showNextQuote() {
            quotes[index].classList.remove("active");
            index = (index + 1) % quotes.length;
            quotes[index].classList.add("active");
        }

        setInterval(showNextQuote, 5000); // Change quote every 5 seconds
    </script>
</body>
</html>