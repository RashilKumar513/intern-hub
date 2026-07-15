<?php
include("config/db.php");

// Check if internships already exist
$existing = mysqli_query($conn, "SELECT COUNT(*) as count FROM internships");
$existing_data = mysqli_fetch_assoc($existing);

if($existing_data['count'] > 0) {
    echo "✅ Internships already exist in the database (" . $existing_data['count'] . " records)";
    exit;
}

// Get company IDs
$companies = array();
$company_query = mysqli_query($conn, "SELECT id FROM companies LIMIT 5");
while($c = mysqli_fetch_assoc($company_query)) {
    $companies[] = $c['id'];
}

// Get domain IDs
$domains = array();
$domain_query = mysqli_query($conn, "SELECT id FROM domains LIMIT 5");
while($d = mysqli_fetch_assoc($domain_query)) {
    $domains[] = $d['id'];
}

if(count($companies) == 0 || count($domains) == 0) {
    echo "❌ Please add companies and domains first!";
    exit;
}

// Sample internships data
$internships = array(
    array(
        "title" => "Web Development Intern",
        "description" => "Join our web development team and work on cutting-edge projects. You'll learn modern web technologies, work with experienced developers, and contribute to real-world applications.",
        "company_id" => $companies[0],
        "domain_id" => $domains[0],
        "location" => "Bangalore",
        "mode" => "Remote",
        "duration" => "3 months",
        "stipend" => "15000"
    ),
    array(
        "title" => "Data Analytics Intern",
        "description" => "Analyze complex datasets and create insights. Learn about data visualization, statistical analysis, and business intelligence tools. Help drive data-driven decision making.",
        "company_id" => $companies[1],
        "domain_id" => $domains[1],
        "location" => "Mumbai",
        "mode" => "Onsite",
        "duration" => "2 months",
        "stipend" => "12000"
    ),
    array(
        "title" => "UI/UX Design Intern",
        "description" => "Create beautiful and functional user interfaces. Work with design tools, learn UX principles, and contribute to product design decisions. Perfect for design enthusiasts.",
        "company_id" => $companies[2],
        "domain_id" => $domains[2],
        "location" => "Delhi",
        "mode" => "Hybrid",
        "duration" => "3 months",
        "stipend" => "10000"
    ),
    array(
        "title" => "Python Backend Developer Intern",
        "description" => "Develop robust backend systems using Python. Work with databases, APIs, and scalable architecture. Ideal for those passionate about backend development.",
        "company_id" => $companies[3],
        "domain_id" => $domains[3],
        "location" => "Hyderabad",
        "mode" => "Remote",
        "duration" => "3 months",
        "stipend" => "18000"
    ),
    array(
        "title" => "Digital Marketing Intern",
        "description" => "Learn digital marketing strategies and execute campaigns. Work with SEO, social media, email marketing, and analytics. Great opportunity to build your marketing portfolio.",
        "company_id" => $companies[4],
        "domain_id" => $domains[4],
        "location" => "Pune",
        "mode" => "Hybrid",
        "duration" => "2 months",
        "stipend" => "8000"
    ),
    array(
        "title" => "Android Development Intern",
        "description" => "Build amazing Android applications. Learn about mobile architecture, UI frameworks, and user experience. Contribute to real Android projects.",
        "company_id" => $companies[0],
        "domain_id" => $domains[0],
        "location" => "Bangalore",
        "mode" => "Onsite",
        "duration" => "3 months",
        "stipend" => "16000"
    ),
    array(
        "title" => "Machine Learning Intern",
        "description" => "Work on ML models and AI solutions. Learn about deep learning, NLP, and computer vision. Apply your skills to solve real-world problems.",
        "company_id" => $companies[1],
        "domain_id" => $domains[1],
        "location" => "Bangalore",
        "mode" => "Remote",
        "duration" => "3 months",
        "stipend" => "20000"
    ),
    array(
        "title" => "React Developer Intern",
        "description" => "Build interactive web applications with React. Learn component design, state management, and modern JavaScript. Contribute to frontend projects.",
        "company_id" => $companies[2],
        "domain_id" => $domains[0],
        "location" => "Delhi",
        "mode" => "Hybrid",
        "duration" => "3 months",
        "stipend" => "14000"
    ),
    array(
        "title" => "Business Analyst Intern",
        "description" => "Analyze business requirements and create solutions. Learn about business processes, data analysis, and strategic planning.",
        "company_id" => $companies[3],
        "domain_id" => $domains[2],
        "location" => "Gurgaon",
        "mode" => "Onsite",
        "duration" => "3 months",
        "stipend" => "9000"
    ),
    array(
        "title" => "DevOps Engineer Intern",
        "description" => "Learn about cloud infrastructure, CI/CD, and containerization. Work with Docker, Kubernetes, and AWS. Build scalable systems.",
        "company_id" => $companies[4],
        "domain_id" => $domains[3],
        "location" => "Bangalore",
        "mode" => "Remote",
        "duration" => "3 months",
        "stipend" => "17000"
    )
);

$inserted = 0;
foreach($internships as $internship) {
    $title = $internship['title'];
    $description = $internship['description'];
    $company_id = $internship['company_id'];
    $domain_id = $internship['domain_id'];
    $location = $internship['location'];
    $mode = $internship['mode'];
    $duration = $internship['duration'];
    $stipend = $internship['stipend'];
    $posted_at = date('Y-m-d H:i:s');

    $insert = mysqli_query($conn, "
        INSERT INTO internships 
        (title, description, company_id, domain_id, location, mode, duration, stipend, posted_at)
        VALUES
        ('$title', '$description', $company_id, $domain_id, '$location', '$mode', '$duration', '$stipend', '$posted_at')
    ");

    if($insert) $inserted++;
}

if($inserted > 0) {
    echo "✅ Successfully inserted $inserted sample internships!";
    echo "<br><a href='internships.php'>View Internships</a>";
} else {
    echo "❌ Error inserting internships. Please check your database.";
}
?>
