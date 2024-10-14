<?php
// Include database connection
$dbhost = 'set your sql dbhost';
$dbuser = 'your sql dbuser';
$dbpass = 'your sql dbpass';
$dbname = 'Your sql dbname';
$port = 3306;  // set sql port

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port) or die('Error connecting to MySQL');

// Function to fetch projects from the database
function fetchProjects($connect) {
    $query = "SELECT * FROM projects";
    $result = mysqli_query($connect, $query);
    $projects = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Truncate description to a certain number of characters
        $row['project_description_short'] = truncateText($row['project_description'], 100); // Adjust the number of characters as needed
        $projects[] = $row;
    }
    return $projects;
}

// Function to truncate text to a certain number of characters while preserving whole words
function truncateText($text, $maxLength) {
    if (strlen($text) > $maxLength) {
        // Find the last space before the maximum length
        $lastSpaceIndex = strrpos(substr($text, 0, $maxLength), ' ');
        
        // Truncate the text at the last space (or at the maxLength if no space found)
        $text = substr($text, 0, $lastSpaceIndex !== false ? $lastSpaceIndex : $maxLength) . '...';
    }
    return $text;
}


// Fetch projects from the database
$projects = fetchProjects($connect);

// Close database connection
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Listing</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add custom styles specific to this page */
        /* For example: */
        .project-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .project {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .project h3 {
            margin-bottom: 10px;
        }
        .project p {
            margin-bottom: 20px;
            overflow-wrap: break-word; /* Enable word wrapping */
        }
        .view-details {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .view-details:hover {
            background-color: #45a049;
        }
        /* Additional styles for different themes */
        body.light {
            background-color: #f0f0f0;
            color: #333;
        }
        body.dark {
            background-color: #333;
            color: #f0f0f0;
        }
    </style>
</head>
<body class="<?php echo isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light'; ?>">
    <?php include 'header.html'; ?> <!-- Include header -->
    
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="your index.html">Main</a></li>
          
            <li><a href="add_project.php">Add Project</a></li>
            
            <li><a href="remove_project.php">Remove Project</a></li>
           
        </ul>
    </nav>

    <main>
        <h1>Project Listing</h1>
        <div class="project-list">
            <!-- Loop through projects and display them -->
            <?php foreach ($projects as $project): ?>
                <div class="project">
                    <h3><?php echo $project['project_name']; ?></h3>
                    <p><?php echo $project['project_description_short']; ?></p>
                    <a class="view-details" data-name="<?php echo $project['project_name']; ?>" data-description="<?php echo $project['project_description']; ?>">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'footer.html'; ?> <!-- Include footer -->
<script>
    // Add event listener to each "View Details" link
    var viewDetailsLinks = document.querySelectorAll('.view-details');
    viewDetailsLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            var name = this.getAttribute('data-name');
            var description = this.getAttribute('data-description');
            
            // Save data to localStorage
            localStorage.setItem('projectName', name);
            localStorage.setItem('projectDescription', description);
            
            // Open popup window
            window.open('popup.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=600,height=400');
        });
    });
</script>



</body>
</html>
