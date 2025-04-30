<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'tej';
$username = 'root';
$password = '';

// Create database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create blood table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS blood (
        id INT AUTO_INCREMENT PRIMARY KEY,
        donation_type ENUM('blood', 'organ') NOT NULL,
        blood_group VARCHAR(3),
        organ_type VARCHAR(50) NULL,
        gender ENUM('Male', 'Female', 'Other') NOT NULL,
        contact VARCHAR(20) NOT NULL,
        email VARCHAR(100),
        hospital VARCHAR(100) NOT NULL,
        registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donationType'])) {
    try {
        $_SESSION['donor_data'] = $_POST;
        
        $stmt = $pdo->prepare("INSERT INTO blood (
            donation_type, blood_group, organ_type, gender, 
            contact, email, hospital
        ) VALUES (
            :donationType, :bloodGroup, :organType, :gender,
            :contact, :email, :hospital
        )");
        
        $stmt->bindParam(':donationType', $_POST['donationType']);
        $stmt->bindValue(':bloodGroup', $_POST['donationType'] == 'blood' ? $_POST['bloodGroup'] : null);
        $stmt->bindValue(':organType', $_POST['donationType'] == 'organ' ? $_POST['organType'] : null);
        $stmt->bindParam(':gender', $_POST['gender']);
        $stmt->bindParam(':contact', $_POST['contact']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':hospital', $_POST['hospital']);
        
        $stmt->execute();
        
        $_SESSION['success_message'] = "Thank you for registering as a donor!";
        header("Location: Donate.php?action=donate");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: Donate.php?action=donate");
        exit();
    }
}

// Fetch all donor records
$searchResults = [];
try {
    $stmt = $pdo->query("SELECT * FROM blood ORDER BY registration_date DESC");
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Error fetching donor records: " . $e->getMessage();
}

// Helper functions
function getBloodGroupColor($bloodGroup) {
    $colors = [
        'A+' => '#cc0000', 'A-' => '#990000',
        'B+' => '#ff6600', 'B-' => '#cc5500',
        'O+' => '#ff9999', 'O-' => '#cc3333',
        'AB+' => '#ff9966', 'AB-' => '#ff6666'
    ];
    return $colors[$bloodGroup] ?? '#cccccc';
}

function getCompatibleBloodGroups($bloodGroup) {
    $compatibility = [
        'A+' => ['A+', 'AB+'],
        'A-' => ['A+', 'A-', 'AB+', 'AB-'],
        'B+' => ['B+', 'AB+'],
        'B-' => ['B+', 'B-', 'AB+', 'AB-'],
        'O+' => ['O+', 'A+', 'B+', 'AB+'],
        'O-' => ['All Blood Types'],
        'AB+' => ['AB+'],
        'AB-' => ['AB+', 'AB-']
    ];
    return $compatibility[$bloodGroup] ?? ['Unknown'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood & Organ Donation System</title>
    <link rel="stylesheet" href="./nav.css">
    <link rel="stylesheet" href="./footer.css">
    <!-- <link rel="shortcut icon" href="./photos/LOGO.webp" type="image/x-icon"> -->
    <style>
        /* Main Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Navigation */
        .nav-container {
            background-color: #ed1b24;
            color: white;
            padding: 15px 0;
        }
        
        .nav-center {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            height: 50px;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 20px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        
        .nav-links a:hover {
            text-decoration: underline;
        }
        
        /* Form Styles */
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        button {
            background-color: #ed1b24;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #c5161e;
        }
        
        /* Donor Cards */
        .donor-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 4px solid #ed1b24;
        }
        
        .donor-card h4 {
            color: #ed1b24;
            margin-top: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .blood-type-badge, .organ-type-badge {
            padding: 3px 10px;
            border-radius: 15px;
            color: white;
            font-size: 0.9em;
            font-weight: bold;
        }
        
        .organ-type-badge {
            background-color: #4CAF50;
        }
        
        .donor-details {
            margin-top: 10px;
        }
        
        .donor-details p {
            margin: 5px 0;
            line-height: 1.4;
        }
        
        .donor-results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        /* Blood Info Section */
        .blood-info {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .blood-types {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .blood-type {
            padding: 15px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        /* Error/Success Messages */
        .error-message {
            color: #d32f2f;
            background-color: #fde0e0;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .success-message {
            color: #388e3c;
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            text-align: left;
            padding: 0 20px;
        }
        
        .footer-section h3 {
            border-bottom: 2px solid #ed1b24;
            padding-bottom: 10px;
            display: inline-block;
        }
        
        .footer-bottom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #555;
        }
        
        @media (max-width: 768px) {
            .donor-results {
                grid-template-columns: 1fr;
            }
            
            .blood-types {
                grid-template-columns: 1fr 1fr;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="nav-container">
        <div class="nav-center wrapper">
            <div class="logo-section">
                <a href="./home.html">
                    <img src="./photos/LOGO.webp" alt="universitylogo" class="logo">
                </a>
            </div>
            <div class="hamburger">
                <img src="./photos/button.png" alt="sidebaropen">
            </div>
            <div class="nav-links-main">
                <div class="nav-links">
                    <li><a href="./home.php" class="nav-link" style="color: black;">home</a></li>
                    <li><a href="./Donate.php" class="nav-link active" style="color: black;">Donate</a></li>
                    <li><a href="./about.php" class="nav-link" style="color: black;">About</a></li>
                    <li><a href="./contact.php" class="nav-link" style="color: black;">contact</a></li>
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


    <!-- Main Content -->
    <div class="container">
        <h2>What would you like to do?</h2>
        
        <!-- Display messages -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <?php unset($_SESSION['error_message']) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <?php unset($_SESSION['success_message']) ?>
            </div>
        <?php endif; ?>
        
        <!-- Toggle between Donate and Search -->
        <div class="form-container">
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="donateOption" name="actionType" value="donate" 
                        <?= (!isset($_GET['action']) || $_GET['action'] == 'donate') ? 'checked' : '' ?> 
                        onchange="toggleForms()">
                    <label for="donateOption">Register as Donor</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="searchOption" name="actionType" value="search" 
                    <?= (isset($_GET['action']) && $_GET['action'] == 'search') ? 'checked' : '' ?> 
                        onchange="toggleForms()">
                    <label for="searchOption">Search for Donors</label>
                </div>
            </div>
        </div>
        
        <!-- Donor Registration Form -->
        <div id="donorForm" style="display: <?= (!isset($_GET['action']) || $_GET['action'] == 'donate') ? 'block' : 'none' ?>;">
            <div class="form-container">
                <h2>Donor Registration</h2>
                <form method="POST" action="Donate.php?action=donate">
                    <div class="form-group">
                        <label>I want to donate:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="donateBlood" name="donationType" value="blood" 
                                    <?= (!isset($_SESSION['donor_data']['donationType']) || $_SESSION['donor_data']['donationType'] == 'blood') ? 'checked' : '' ?> 
                                    onchange="toggleDonationFields()">
                                <label for="donateBlood">Blood</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="donateOrgan" name="donationType" value="organ" 
                                    <?= (isset($_SESSION['donor_data']['donationType']) && $_SESSION['donor_data']['donationType'] == 'organ') ? 'checked' : '' ?> 
                                    onchange="toggleDonationFields()">
                                <label for="donateOrgan">Organ</label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="bloodGroupField" class="form-group" style="display: <?= (!isset($_SESSION['donor_data']['donationType']) || $_SESSION['donor_data']['donationType'] == 'blood') ? 'block' : 'none' ?>;">
                        <label for="bloodGroup">Blood Group</label>
                        <select id="bloodGroup" name="bloodGroup" <?= (!isset($_SESSION['donor_data']['donationType']) || $_SESSION['donor_data']['donationType'] == 'blood') ? 'required' : '' ?>>
                            <option value="">Select Blood Group</option>
                            <?php 
                            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                            foreach ($bloodGroups as $group): ?>
                                <option value="<?= $group ?>" <?= (isset($_SESSION['donor_data']['bloodGroup']) && $_SESSION['donor_data']['bloodGroup'] == $group) ? 'selected' : '' ?>>
                                    <?= $group ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    
                    <div id="organTypeField" class="form-group" style="display: <?= (isset($_SESSION['donor_data']['donationType']) && $_SESSION['donor_data']['donationType'] == 'organ') ? 'block' : 'none' ?>;">
                        <label for="organType">Organ Type</label>
                        <select id="organType" name="organType">
                            <option value="">Select Organ</option>
                            <option value="Kidney" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Kidney') ? 'selected' : '' ?>>Kidney</option>
                            <option value="Liver" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Liver') ? 'selected' : '' ?>>Liver</option>
                            <option value="Heart" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Heart') ? 'selected' : '' ?>>Heart</option>
                            <option value="Lungs" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Lungs') ? 'selected' : '' ?>>Lungs</option>
                            <option value="Pancreas" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Pancreas') ? 'selected' : '' ?>>Pancreas</option>
                            <option value="Eyes" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Eyes') ? 'selected' : '' ?>>Eyes</option>
                            <option value="Bone Marrow" <?= (isset($_SESSION['donor_data']['organType']) && $_SESSION['donor_data']['organType'] == 'Bone Marrow') ? 'selected' : '' ?>>Bone Marrow</option>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?= (isset($_SESSION['donor_data']['gender']) && $_SESSION['donor_data']['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= (isset($_SESSION['donor_data']['gender']) && $_SESSION['donor_data']['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= (isset($_SESSION['donor_data']['gender']) && $_SESSION['donor_data']['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="tel" id="contact" name="contact" required 
                            value="<?= isset($_SESSION['donor_data']['contact']) ? htmlspecialchars($_SESSION['donor_data']['contact']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email (Optional)</label>
                        <input type="email" id="email" name="email" 
                            value="<?= isset($_SESSION['donor_data']['email']) ? htmlspecialchars($_SESSION['donor_data']['email']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="hospital">Hospital/Medical Center</label>
                        <input type="text" id="hospital" name="hospital" required 
                            value="<?= isset($_SESSION['donor_data']['hospital']) ? htmlspecialchars($_SESSION['donor_data']['hospital']) : '' ?>">
                    </div>
                    
                    <button type="submit">Register as Donor</button>
                </form>
            </div>
        </div>
        
        <!-- Search Donors Form -->
        <div id="searchForm" style="display: <?= (isset($_GET['action']) && $_GET['action'] == 'search') ? 'block' : 'none' ?>;">

            <div class="form-container">
                <h2>Search for Donors</h2>
                <form method="GET" action="Donate.php">
                    <input type="hidden" name="action" value="search">
                    
                    <div class="form-group">
                        <label for="searchDonationType">Donation Type</label>
                        <select id="searchDonationType" name="searchDonationType" onchange="toggleSearchFields()">
                            <option value="">Any Type</option>
                            <option value="blood" <?= (isset($_GET['searchDonationType']) && $_GET['searchDonationType'] == 'blood') ? 'selected' : '' ?>>Blood</option>
                            <option value="organ" <?= (isset($_GET['searchDonationType']) && $_GET['searchDonationType'] == 'organ') ? 'selected' : '' ?>>Organ</option>
                        </select>
                    </div>
                    
                    <div id="searchBloodGroupField" class="form-group" style="display: <?= (isset($_GET['searchDonationType']) && $_GET['searchDonationType'] == 'blood') ? 'block' : 'none' ?>;">
                        <label for="searchBloodGroup">Blood Group</label>
                        <select id="searchBloodGroup" name="searchBloodGroup">
                            <option value="">Any Blood Group</option>
                            <option value="A+" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'A+' ? 'selected' : '') ?>>A+</option>
                            <option value="A-" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'A-' ? 'selected' : '') ?>>A-</option>
                            <option value="B+" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'B+' ? 'selected' : '') ?>>B+</option>
                            <option value="B-" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'B-' ? 'selected' : '') ?>>B-</option>
                            <option value="O+" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'O+' ? 'selected' : '') ?>>O+</option>
                            <option value="O-" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'O-' ? 'selected' : '') ?>>O-</option>
                            <option value="AB+" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'AB+' ? 'selected' : '') ?>>AB+</option>
                            <option value="AB-" <?= (isset($_GET['searchBloodGroup']) && $_GET['searchBloodGroup'] == 'AB-' ? 'selected' : '') ?>>AB-</option>
                        </select>
                    </div>

                    
                    <div id="searchOrganTypeField" class="form-group" style="display: <?= (isset($_GET['searchDonationType']) && $_GET['searchDonationType'] == 'organ') ? 'block' : 'none' ?>;">
                        <label for="searchOrganType">Organ Type</label>
                        <select id="searchOrganType" name="searchOrganType">
                            <option value="">Any Organ</option>
                            <option value="Kidney" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Kidney' ? 'selected' : '') ?>>Kidney</option>
                            <option value="Liver" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Liver' ? 'selected' : '') ?>>Liver</option>
                            <option value="Heart" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Heart' ? 'selected' : '') ?>>Heart</option>
                            <option value="Lungs" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Lungs' ? 'selected' : '') ?>>Lungs</option>
                            <option value="Pancreas" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Pancreas' ? 'selected' : '') ?>>Pancreas</option>
                            <option value="Eyes" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Eyes' ? 'selected' : '') ?>>Eyes</option>
                            <option value="Bone Marrow" <?= (isset($_GET['searchOrganType']) && $_GET['searchOrganType'] == 'Bone Marrow' ? 'selected' : '') ?>>Bone Marrow</option>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="searchHospital">Hospital (Optional)</label>
                        <input type="text" id="searchHospital" name="searchHospital" 
                            value="<?= isset($_GET['searchHospital']) ? htmlspecialchars($_GET['searchHospital']) : '' ?>">
                    </div>
                    
                    <button type="submit">Search Donors</button>
                </form>
            </div>
            
            <!-- Search Results -->
            <?php if (isset($_GET['action']) && $_GET['action'] == 'search'): ?>
                <div class="form-container">
                    <h2>Search Results</h2>
                    
                    <?php if (!empty($searchResults)): ?>
                        <h3>Total Donors Found: <?= count($searchResults) ?></h3>
                        <div class="donor-results">
                            <?php foreach ($searchResults as $donor): ?>
                                <div class="donor-card">
                                    <h4>
                                        <?= htmlspecialchars($donor['donation_type'] === 'blood' ? 'Blood Donor' : 'Organ Donor') ?>
                                        <?php if ($donor['donation_type'] === 'blood' && !empty($donor['blood_group'])): ?>
                                            <span class="blood-type-badge" style="background-color: <?= getBloodGroupColor($donor['blood_group']) ?>">
                                                <?= htmlspecialchars($donor['blood_group']) ?>
                                            </span>
                                        <?php elseif ($donor['donation_type'] === 'organ' && !empty($donor['organ_type'])): ?>
                                            <span class="organ-type-badge">
                                                <?= htmlspecialchars($donor['organ_type']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </h4>
                                    
                                    <div class="donor-details">
                                        <p><strong>Type:</strong> <?= htmlspecialchars(ucfirst($donor['donation_type'])) ?></p>
                                        
                                        <?php if ($donor['donation_type'] === 'blood' && !empty($donor['blood_group'])): ?>
                                            <p><strong>Blood Group:</strong> <?= htmlspecialchars($donor['blood_group']) ?></p>
                                            <p><strong>Compatible With:</strong> <?= implode(', ', getCompatibleBloodGroups($donor['blood_group'])) ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if ($donor['donation_type'] === 'organ' && !empty($donor['organ_type'])): ?>
                                            <p><strong>Organ Type:</strong> <?= htmlspecialchars($donor['organ_type']) ?></p>
                                        <?php endif; ?>
                                        
                                        <p><strong>Gender:</strong> <?= htmlspecialchars($donor['gender']) ?></p>
                                        <p><strong>Contact:</strong> <?= htmlspecialchars($donor['contact']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($donor['email']) ?></p>
                                        <p><strong>Hospital:</strong> <?= htmlspecialchars($donor['hospital']) ?></p>
                                        <p><strong>Registered:</strong> <?= date('M d, Y h:i A', strtotime($donor['registration_date'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No donors found matching your search criteria.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Blood Information Section -->
        <div class="blood-info">
            <h2>Blood Type Compatibility</h2>
            <p>Understanding blood type compatibility is crucial for safe transfusions. Here's a quick reference:</p>
            
            <div class="blood-types">
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('A+') ?>">
                    <h3>A+</h3>
                    <p>Can donate to: A+, AB+</p>
                    <p>Can receive from: A+, A-, O+, O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('A-') ?>">
                    <h3>A-</h3>
                    <p>Can donate to: A+, A-, AB+, AB-</p>
                    <p>Can receive from: A-, O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('B+') ?>">
                    <h3>B+</h3>
                    <p>Can donate to: B+, AB+</p>
                    <p>Can receive from: B+, B-, O+, O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('B-') ?>">
                    <h3>B-</h3>
                    <p>Can donate to: B+, B-, AB+, AB-</p>
                    <p>Can receive from: B-, O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('O+') ?>">
                    <h3>O+</h3>
                    <p>Can donate to: O+, A+, B+, AB+</p>
                    <p>Can receive from: O+, O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('O-') ?>">
                    <h3>O-</h3>
                    <p>Universal Donor</p>
                    <p>Can receive from: O-</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('AB+') ?>">
                    <h3>AB+</h3>
                    <p>Universal Recipient</p>
                    <p>Can donate to: AB+</p>
                </div>
                <div class="blood-type" style="background-color: <?= getBloodGroupColor('AB-') ?>">
                    <h3>AB-</h3>
                    <p>Can donate to: AB+, AB-</p>
                    <p>Can receive from: A-, B-, AB-, O-</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
     
      <!-- footer start -->
      <footer class="footer-container">
        <div class="footer-center wrapper">
            <div class="footer-links-main">
                <ul class="footer-links">
                    <li><a href="./home.html" class="footer-link">HOME</a></li>
                    <li><a href="./Donate.html" class="footer-link active">DONATE</a></li>
                    <li><a href="./about.html" class="footer-link">ABOUT</a></li>
                    <li><a href="./contact.html" class="footer-link">CONTACT</a></li>
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
                <p>copy right <span class="copyright-date">@ 2025</span>,done by </p>
            </div>
        </div>
       </footer>
       <!-- footer ends -->
    
    <!-- JavaScript -->
    <script>
        // Toggle between Donate and Search forms
        function toggleForms() {
            const donateOption = document.getElementById('donateOption').checked;
            document.getElementById('donorForm').style.display = donateOption ? 'block' : 'none';
            document.getElementById('searchForm').style.display = donateOption ? 'none' : 'block';
            
            // Update URL without reloading
            const action = donateOption ? 'donate' : 'search';
            history.pushState(null, null, `Donate.php?action=${action}`);
        }
        
        // Toggle between Blood and Organ fields in donor form
        function toggleDonationFields() {
            const donateBlood = document.getElementById('donateBlood').checked;
            document.getElementById('bloodGroupField').style.display = donateBlood ? 'block' : 'none';
            document.getElementById('organTypeField').style.display = donateBlood ? 'none' : 'block';
            
            // Set required attributes
            document.getElementById('bloodGroup').required = donateBlood;
            document.getElementById('organType').required = !donateBlood;
        }
        
        // Toggle between Blood and Organ fields in search form
        function toggleSearchFields() {
            const searchType = document.getElementById('searchDonationType').value;
            document.getElementById('searchBloodGroupField').style.display = 
                (searchType === 'blood') ? 'block' : 'none';
            document.getElementById('searchOrganTypeField').style.display = 
                (searchType === 'organ') ? 'block' : 'none';
        }
        
        // Initialize form states on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for action parameter
            const urlParams = new URLSearchParams(window.location.search);
            const action = urlParams.get('action');
            
            if (action === 'search') {
                document.getElementById('searchOption').checked = true;
                toggleForms();
            }
            
            // Initialize donation type fields
            toggleDonationFields();
            toggleSearchFields();
        });
    </script>
</body>
</html>