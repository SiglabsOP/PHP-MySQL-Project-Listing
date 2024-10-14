<?php
// Include database connection
$dbhost = 'set your sql dbhost';
$dbuser = 'your sql dbuser';
$dbpass = 'your sql dbpass';
$dbname = 'Your sql dbname';
$port = 3306;  // set sql port

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);

// Check if database connection is successful
if (!$connect) {
    die('Error connecting to MySQL: ' . mysqli_connect_error());
}

// Function to remove a project
function removeProject($connect, $projectId) {
    $projectId = mysqli_real_escape_string($connect, $projectId);
    
    $query = "DELETE FROM projects WHERE project_id = '$projectId'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "Project removed successfully!"; // Debugging message
        return true;
    } else {
        echo "Error removing project: " . mysqli_error($connect); // Debugging message
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if project ID is provided
    if (isset($_POST['project_id'])) {
        $projectId = $_POST['project_id'];

        // Remove the project
        $success = removeProject($connect, $projectId);

        if (!$success) {
            echo "Error removing project!"; // Debugging message
        }
    } else {
        echo "No project ID provided!"; // Debugging message
    }
}

// Fetch projects from the database
$query = "SELECT project_id, project_name FROM projects";
$result = mysqli_query($connect, $query);

// Check if the query executed successfully
if (!$result) {
    die('Error executing query: ' . mysqli_error($connect));
}

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    echo "Rows fetched successfully!"; // Debugging message
} else {
    echo "No projects found!"; // Debugging message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Project</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
    <?php include 'header.html'; ?> <!-- Include header -->
    
    <main>
        <section>
            <h2>Remove Project</h2>
            <form action="remove_project.php" method="POST">
                <label for="project_id">Select Project:</label>
                <select id="project_id" name="project_id" required>
                    <option value="">Select Project</option>
                    <!-- PHP code to fetch and display projects dynamically -->
                    <?php
                    // Loop through the result set and display project options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['project_id'] . "'>" . $row['project_name'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Remove Project</button>
            </form>
        </section>
    </main>

    <?php include 'footer.html'; ?> <!-- Include footer -->
</body>
</html>

<?php
// Close database connection
mysqli_close($connect);
?>
