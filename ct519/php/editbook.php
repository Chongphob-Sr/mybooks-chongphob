<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>

    <?php
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

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get book details from the form
        $bookId = $_POST['id'];
        $bookName = $_POST['book_name'];
        $description = $_POST['description'];

        // Prepare and execute the SQL query to update the book in the 'books' table
        $stmt = $conn->prepare("UPDATE books SET book_name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $bookName, $description, $bookId);

        if ($stmt->execute()) {
            echo "Book updated successfully.";
        } else {
            echo "Error updating book: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Check if the 'id' parameter is present in the URL
    if (isset($_GET['id'])) {
        $bookId = $_GET['id'];

        // SQL query to fetch the book with the specified 'id'
        $sql = "SELECT * FROM books WHERE id = $bookId";

        // Execute the query and get the result
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Fetch the book details
            $row = $result->fetch_assoc();
            $bookName = $row['book_name'];
            $description = $row['description'];

            // Display the edit form
            ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $bookId; ?>">
                <label for="book_name">Book Name:</label><br>
                <input type="text" id="book_name" name="book_name" value="<?php echo $bookName; ?>"><br><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50"><?php echo $description; ?></textarea><br><br>

                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "Book not found.";
        }
    } else {
        echo "Invalid request.";
    }

    // Close the MySQL connection
    $conn->close();
    ?>

    <p><a href="mybooks.php">Back to My Books</a></p>
</body>
</html>
