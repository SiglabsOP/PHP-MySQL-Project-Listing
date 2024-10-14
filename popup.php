<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <style>
        /* Add custom styles for the popup */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 20px;
        }
        /* Add word wrapping to project details */
        #projectName,
        #projectDescription {
            display: block;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <h2>Project Details</h2>
    <p><strong>Name:</strong> <span id="projectName"></span></p>
    <p><strong>Description:</strong> <span id="projectDescription"></span></p>

    <script>
        // Retrieve project details from localStorage
        var projectName = localStorage.getItem('projectName');
        var projectDescription = localStorage.getItem('projectDescription');

        // Display project details in the popup
        document.getElementById('projectName').textContent = projectName;
        document.getElementById('projectDescription').textContent = projectDescription;
    </script>
</body>
</html>
