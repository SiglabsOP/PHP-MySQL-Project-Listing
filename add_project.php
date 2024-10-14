<?php
// Include database connection
$dbhost = 'set your sql dbhost';
$dbuser = 'your sql dbuser';
$dbpass = 'your sql dbpass';
$dbname = 'Your sql dbname';
$port = 3306;  // set sql port

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port) or die('Error connecting to MySQL: ' . mysqli_connect_error());

// Function to insert new project into database
function addProject($connect, $projectName, $projectDescription) {
    $projectName = mysqli_real_escape_string($connect, $projectName);
    $projectDescription = mysqli_real_escape_string($connect, $projectDescription);

    $query = "INSERT INTO projects (project_name, project_description) VALUES ('$projectName', '$projectDescription')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        return true;
    } else {
        // Display detailed error message
        echo "Error adding project: " . mysqli_error($connect);
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if project_name and project_description are set in $_POST
    if(isset($_POST['project_name']) && isset($_POST['project_description'])) {
        $projectName = $_POST['project_name'];
        $projectDescription = $_POST['project_description'];

        // Add project to database
        $success = addProject($connect, $projectName, $projectDescription);

        if ($success) {
            echo "Project added successfully!";
        } else {
            echo "Error adding project!";
        }
    } else {
        echo "Project name and description are required!";
    }
}

// Close database connection
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <!-- Link to CSS file for styling -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Project</h1>
        <!-- Navigation links -->
        <nav>
            <ul>
                <li><a href="#">Home</a></li>    <!-- you can have your home url here --->
             
            
            </ul>
        </nav>
    </header>
    
    <main>
        <section class="add-project">
            <h2>Add Project</h2>
            <!-- Form to add a new project -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="project_name">Project Name:</label><br>
                <input type="text" id="project_name" name="project_name"><br>
                <label for="project_description">Project Description:</label><br>
                <textarea id="project_description" name="project_description"></textarea><br>
                <input type="submit" value="Add Project">
            </form>
        </section>
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
