<!DOCTYPE html>
<html>
<head>
    <title>My Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .edit-button, .delete-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .edit-button:hover, .delete-button:hover {
            background-color: #45a049;
        }

        .add-button {
            padding: 10px 15px;
            background-color: #008CBA;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .add-button:hover {
            background-color: #007A99;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #007A99;
        }

        nav ul li a:hover {
            color: #004455;
        }
    </style>
</head>
<body>
    <h1>My Books</h1>

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

    // Handle book deletion
    if (isset($_GET['delete'])) {
        $bookId = $_GET['delete'];

        // Prepare and execute the SQL query to delete the book from the 'books' table
        $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $bookId);

        if ($stmt->execute()) {
            echo "Book deleted successfully.";
        } else {
            echo "Error deleting book: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // SQL query to fetch books from the 'books' table
    $sql = "SELECT * FROM books";

    // Execute the query and get the result
    $result = $conn->query($sql);

    // Check if there are any books in the result set
    if ($result !== false && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Book Name</th><th>Description</th><th>Actions</th></tr>';

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['book_name'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td class="actions">';
            echo '<a class="edit-button" href="edit.php?id=' . $row['id'] . '">Edit</a>';
            echo '<a class="delete-button" href="?delete=' . $row['id'] . '">Del</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "No books found.";
    }

    // Close the MySQL connection
    $conn->close();
    ?>

    <button class="add-button" onclick="location.href='add.php'">Add a Book</button>

    <nav>
        <ul>
            <li><a href="./index.html">Home</a></li>
        </ul>
    </nav>
</body>
</html>
