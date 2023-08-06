<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
</head>
<body>
    <h1>Add Book</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection settings
        $host = 'db'; // MySQL host name (the service name in the docker-compose.yml)
        $user = 'user'; // MySQL username (replace with your actual username)
        $password = 'sm@rt'; // MySQL password (replace with your actual password)
        $database = 'mybooks_db'; // MySQL database name

        // Create a connection to MySQL
        $conn = new mysqli($host, $user, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get book details from the form
        $bookName = $_POST['book_name'];
        $description = $_POST['description'];

        // Prepare the SQL query to insert the book into the 'books' table
        $stmt = $conn->prepare("INSERT INTO books (book_name, description) VALUES (?, ?)");

        // Check if the query preparation is successful
        if ($stmt !== false) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ss", $bookName, $description);

            if ($stmt->execute()) {
                echo "Book added successfully.";
            } else {
                echo "Error adding book: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error handling for failed query preparation
            echo "Error preparing the SQL query: " . $conn->error;
        }

        // Close the MySQL connection
        $conn->close();
    }
    ?>

    <form method="post">
        <label for="book_name">Book Name:</label><br>
        <input type="text" id="book_name" name="book_name"><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Add">
    </form>

    <p><a href="mybooks.php">Back to My Books</a></p>
</body>
</html>
