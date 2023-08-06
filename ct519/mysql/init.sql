-- Create the database mybooks_db
CREATE DATABASE IF NOT EXISTS mybooks_db;

-- Use the database mybooks_db
USE mybooks_db;

-- Create the books table if it doesn't exist
CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
);
