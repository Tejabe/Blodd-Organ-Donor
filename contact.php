<?php
// Start session
session_start();

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form (in a real app, you'd send email/save to DB)
    if (empty($errors)) {
        $_SESSION['form_success'] = true;
        $_SESSION['form_data'] = [
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'message' => htmlspecialchars($message)
        ];
        
        // Redirect to prevent form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOOD&ORGAN-DONAR | CONTACT</title>
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./footer.css">
    <link rel="stylesheet" href="./nav.css">
    <link rel="stylesheet" href="./sidebar.css">
    <link rel="shortcut icon" href="./photos/LOGO.webp" type="image/x-icon">
</head>
<body>
    <!-- nav bar start -->
    <nav class="nav-container">
        <div class="nav-center wrapper">
            <div class="logo-section">
                <a href="./contact.php">
                    <img src="./photos/LOGO.webp" alt="universitylogo" class="logo">
                </a>
            </div>
            <div class="hamburger">
                <img src="./icons/button.png" alt="sidebaropen">
            </div>
            <div class="nav-links-main">
                <div class="nav-links">
                    <li><a href="./home.php" class="nav-link">HOME</a></li>
                    <li><a href="./Donate.php" class="nav-link">DONATE</a></li>
                    <li><a href="./about.php" class="nav-link">ABOUT</a></li>
                    <li><a href="./contact.php" class="nav-link active">CONTACT</a></li>
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
                        <li><a href="./home.php" class="nav-link">HOME</a></li>
                        <li><a href="./Donate.php" class="nav-link">DONATE</a></li>
                        <li><a href="./about.php" class="nav-link">ABOUT</a></li>
                        <li><a href="./contact.php" class="nav-link active">CONTACT</a></li>
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
                    <img src="./photos/back.jpg" alt="about hero">
                </div>
            </div>
            <div class="hero-box paddingbottommobile-thirty paddingtopmobile-thirty">
                <div class="hero-content text-center wrapper psddiingtopmobile-thirty paddingbottommobile-thirty">
                    <h1 class="heading">BLOOD&ORGAN-DONATION</h1>
                    <div class="small-heading">BE A DONOR-SAVE LIFES</div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero section end -->

    <!-- single-featured component start -->
    <div class="single-featured-container light-blue-background">
        <div class="single-featured-center wrapper">
            <div class="section-tittle paddingtopdesktop-hunderd paddingtopmobile-fifty paddingbottomdesktop-hundered paddingbottommobile-fourty">
                <h2 class="tittle text-center paddingbottomdesktop-twenty paddingbottommobile-twenty">contact-us</h2>
                <div class="underline"></div>
            </div>
            <div class="single-featured paddingbottomdesktop-fifty paddingtopdesktop-fifty paddingtopmobile-fifty paddingbottommobile-fourty">
                <div class="image-component single-featured-image paddingbottommobile-fourty">
                    <img src="./photos/ab.jpeg" alt="contactpage">
                </div>
                <div class="single-featured-text-component">
                    <div class="featured-center">
                        <div class="about-info">
                            <?php if (isset($_SESSION['form_success'])): ?>
                                <div class="success-message">
                                    <h3>Thank you for contacting us!</h3>
                                    <p>We have received your message and will get back to you soon.</p>
                                    <p><strong>Name:</strong> <?php echo $_SESSION['form_data']['name']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $_SESSION['form_data']['email']; ?></p>
                                    <a href="./contact.php" class="button-light">Send another message</a>
                                </div>
                                <?php 
                                unset($_SESSION['form_success']);
                                unset($_SESSION['form_data']);
                            else: ?>
                                <form class="contact-us-form full-width-mobile full-width-desktop" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <?php if (!empty($errors)): ?>
                                        <div class="error-message">
                                            <ul>
                                                <?php foreach ($errors as $error): ?>
                                                    <li><?php echo htmlspecialchars($error); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <input type="text" name="name" placeholder="Enter Your Name" class="primary-input" 
                                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required/>
                                    <br>
                                    <input type="email" name="email" placeholder="Enter Your E-mail" class="primary-input" 
                                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required/>
                                    <br>
                                    <textarea name="message" id="message" cols="38" rows="6" placeholder="Enter Your Message" 
                                              class="textarea" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                                    <button type="submit" class="button-light">Submit</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- single-featured component end -->     

    <!-- footer start -->
    <footer class="footer-container">
        <div class="footer-center wrapper">
            <div class="footer-links-main">
                <ul class="footer-links">
                    <li><a href="./home.php" class="footer-link">HOME</a></li>
                    <li><a href="./Donate.php" class="footer-link">DONATE</a></li>
                    <li><a href="./about.php" class="footer-link">ABOUT</a></li>
                    <li><a href="./contact.php" class="footer-link active">CONTACT</a></li>
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
                <p>copy right <span class="copyright-date"><?php echo date('Y'); ?></span>, done by </p>
            </div>
        </div>
    </footer>
    <!-- footer ends -->
    
    <script src="./d.js"></script>
</body>
</html>