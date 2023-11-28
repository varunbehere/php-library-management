-- Create a database named "library" (if not exists)
CREATE DATABASE IF NOT EXISTS library;

-- Use the "library" database
USE library;

-- Create a table named "books" to store book details
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bookName VARCHAR(255) NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    bookTitle VARCHAR(255) NOT NULL,
    authorName VARCHAR(255) NOT NULL,
    publisherName VARCHAR(255) NOT NULL
);

-- Insert some sample data (optional)
INSERT INTO books (bookName, isbn, bookTitle, authorName, publisherName) VALUES
('Sample Book 1', '1234567890123', 'Sample Title 1', 'Author 1', 'Publisher 1'),
('Sample Book 2', '9876543210123', 'Sample Title 2', 'Author 2', 'Publisher 2');
