<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "library"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["insert"])) {
        // Insert operation
        $bookData = [
            'bookName' => $_POST['bookName'],
            'isbn' => $_POST['isbn'],
            'bookTitle' => $_POST['bookTitle'],
            'authorName' => $_POST['authorName'],
            'publisherName' => $_POST['publisherName']
        ];

        insertBookDetails($conn, $bookData);

        $_SESSION['result'] = 'Inserted book details successfully.';
    } elseif (isset($_POST["delete"])) {
        // Delete operation
        $isbn = $_POST['isbn'];
        deleteBookRecord($conn, $isbn);

        $_SESSION['result'] = 'Deleted book record successfully.';
    } elseif (isset($_POST["update"])) {
        // Update operation
        $isbn = $_POST['isbn'];
        $newBookData = [
            'bookName' => $_POST['bookName'],
            'bookTitle' => $_POST['bookTitle'],
            'authorName' => $_POST['authorName'],
            'publisherName' => $_POST['publisherName']
        ];

        updateBookDetails($conn, $isbn, $newBookData);

        $_SESSION['result'] = 'Updated book details successfully.';
    } elseif (isset($_POST["showBooks"])) {
        // Display books based on ISBN
        $isbn = $_POST['isbn'];
        $result = displayBooks($conn, $isbn);
        $_SESSION['result'] = $result;
    }
}

$conn->close();
header("Location: index.html");

function insertBookDetails($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO books (bookName, isbn, bookTitle, authorName, publisherName) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data['bookName'], $data['isbn'], $data['bookTitle'], $data['authorName'], $data['publisherName']);
    $stmt->execute();
    $stmt->close();

    showPrompt('Inserted book details successfully.');
}

function deleteBookRecord($conn, $isbn) {
    $stmt = $conn->prepare("DELETE FROM books WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $stmt->close();

    showPrompt('Deleted book record successfully.');
}

function updateBookDetails($conn, $isbn, $data) {
    $stmt = $conn->prepare("UPDATE books SET bookName = ?, bookTitle = ?, authorName = ?, publisherName = ? WHERE isbn = ?");
    $stmt->bind_param("sssss", $data['bookName'], $data['bookTitle'], $data['authorName'], $data['publisherName'], $isbn);
    $stmt->execute();
    $stmt->close();

    showPrompt('Updated book details successfully.');
}

function displayBooks($conn, $isbn) {
    $result = '<h3>Book Details</h3>';

    $stmt = $conn->prepare("SELECT * FROM books WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $queryResult = $stmt->get_result();
    $stmt->close();

    if ($queryResult->num_rows > 0) {
        $result .= '<table border="1">';
        $result .= '<tr><th>ID</th><th>Book Name</th><th>ISBN</th><th>Book Title</th><th>Author Name</th><th>Publisher Name</th></tr>';

        while ($row = $queryResult->fetch_assoc()) {
            $result .= "<tr><td>{$row['id']}</td><td>{$row['bookName']}</td><td>{$row['isbn']}</td><td>{$row['bookTitle']}</td><td>{$row['authorName']}</td><td>{$row['publisherName']}</td></tr>";
        }

        $result .= '</table>';
    } else {
        $result .= 'No books found for the given ISBN.';
    }

    showPrompt($result);
}

function showPrompt($message) {
    echo "<script>alert('$message');</script>";
}
?>
