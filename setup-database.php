<?php
include("config/db.php");

$message = "";

// Check existing data
$existing_domains = mysqli_query($conn, "SELECT COUNT(*) as count FROM domains");
$domain_count = mysqli_fetch_assoc($existing_domains)['count'];

$existing_companies = mysqli_query($conn, "SELECT COUNT(*) as count FROM companies");
$company_count = mysqli_fetch_assoc($existing_companies)['count'];

if(isset($_POST['setup_all'])) {
    $setup_domains = true;
    $setup_companies = true;
} else {
    $setup_domains = isset($_POST['setup_domains']);
    $setup_companies = isset($_POST['setup_companies']);
}

$domains_created = 0;
$companies_created = 0;

// Create sample domains
if($setup_domains && $domain_count == 0) {
    $domain_list = array(
        "Technology",
        "Data Analytics",
        "UI/UX Design",
        "Digital Marketing",
        "Business Management",
        "Finance",
        "Healthcare",
        "E-commerce",
        "Mobile Development",
        "Cloud Computing",
        "Cybersecurity",
        "Content Writing",
        "HR & Recruitment",
        "Sales",
        "Operations"
    );

    foreach($domain_list as $domain) {
        $insert = mysqli_query($conn, "
            INSERT INTO domains (domain_name)
            VALUES ('$domain')
        ");
        if($insert) $domains_created++;
    }
    $message .= "✅ Created $domains_created domains<br>";
}

// Create sample companies
if($setup_companies && $company_count == 0) {
    $company_list = array(
        array("name" => "Google", "location" => "Bangalore", "website" => "https://www.google.com", "desc" => "Google LLC is an American multinational technology company."),
        array("name" => "Microsoft", "location" => "Hyderabad", "website" => "https://www.microsoft.com", "desc" => "Microsoft is a technology corporation that develops software and hardware products."),
        array("name" => "Amazon", "location" => "Bangalore", "website" => "https://www.amazon.in", "desc" => "Amazon is an e-commerce and cloud computing company."),
        array("name" => "Meta", "location" => "Bangalore", "website" => "https://www.meta.com", "desc" => "Meta Platforms, formerly Facebook, is a social media and technology company."),
        array("name" => "Apple", "location" => "Bangalore", "website" => "https://www.apple.com", "desc" => "Apple Inc. designs and manufactures consumer electronics and software."),
        array("name" => "IBM", "location" => "Bangalore", "website" => "https://www.ibm.com", "desc" => "IBM is a multinational technology and consulting company."),
        array("name" => "Intel", "location" => "Bangalore", "website" => "https://www.intel.com", "desc" => "Intel is a semiconductor manufacturing company."),
        array("name" => "Adobe", "location" => "Noida", "website" => "https://www.adobe.com", "desc" => "Adobe provides creative and marketing software solutions."),
        array("name" => "Flipkart", "location" => "Bangalore", "website" => "https://www.flipkart.com", "desc" => "Flipkart is an Indian e-commerce company."),
        array("name" => "Infosys", "location" => "Bangalore", "website" => "https://www.infosys.com", "desc" => "Infosys is an Indian IT services and consulting company.")
    );

    foreach($company_list as $company) {
        $name = $company['name'];
        $location = $company['location'];
        $website = $company['website'];
        $desc = $company['desc'];
        
        $insert = mysqli_query($conn, "
            INSERT INTO companies (company_name, location, website, description)
            VALUES ('$name', '$location', '$website', '$desc')
        ");
        if($insert) $companies_created++;
    }
    $message .= "✅ Created $companies_created companies<br>";
}

if($message == "") {
    if($domain_count > 0 && $company_count > 0) {
        $message = "✅ Setup already completed! Domains: $domain_count, Companies: $company_count";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <style>
        .setup-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .setup-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .setup-header h1 {
            color: #2563EB;
            font-size: 28px;
        }
        .status {
            background: #f4f7fc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2563EB;
        }
        .status p {
            margin: 5px 0;
            color: #333;
        }
        .status strong {
            color: #2563EB;
        }
        .button-group {
            display: grid;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-primary {
            background: #2563EB;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        .btn-secondary:hover {
            background: #4b5563;
        }
        .message {
            background: #efe;
            color: #3a3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3a3;
        }
        .next-steps {
            background: #e0f2fe;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0284c7;
            margin-top: 20px;
        }
        .next-steps h3 {
            color: #0284c7;
            margin-top: 0;
        }
        .next-steps ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1>🎯 Intern Hub Setup</h1>
            <p>Initialize your database with sample data</p>
        </div>

        <div class="status">
            <p><strong>Current Status:</strong></p>
            <p>Domains in Database: <strong><?= $domain_count ?></strong></p>
            <p>Companies in Database: <strong><?= $company_count ?></strong></p>
        </div>

        <?php if($message != ""): ?>
            <div class="message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="button-group">
                <?php if($domain_count == 0): ?>
                    <button type="submit" name="setup_domains" value="1" class="btn btn-primary">
                        ➕ Add Sample Domains (15)
                    </button>
                <?php endif; ?>

                <?php if($company_count == 0): ?>
                    <button type="submit" name="setup_companies" value="1" class="btn btn-primary">
                        ➕ Add Sample Companies (10)
                    </button>
                <?php endif; ?>

                <?php if($domain_count == 0 || $company_count == 0): ?>
                    <button type="submit" name="setup_all" value="1" class="btn btn-secondary">
                        ⚡ Setup All
                    </button>
                <?php endif; ?>
            </div>
        </form>

        <?php if($domain_count > 0 && $company_count > 0): ?>
            <div class="next-steps">
                <h3>✅ Next Steps:</h3>
                <ol>
                    <li>Visit: <a href="add-sample-internships.php" style="color: #0284c7; font-weight: 600;">Add Sample Internships</a></li>
                    <li>Fix Admin Password: <a href="fix-admin-password.php" style="color: #0284c7; font-weight: 600;">Fix Admin Password</a></li>
                    <li>Go to: <a href="index.php" style="color: #0284c7; font-weight: 600;">Home Page</a></li>
                </ol>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
