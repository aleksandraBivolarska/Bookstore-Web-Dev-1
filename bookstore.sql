-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 06, 2025 at 12:18 PM
-- Server version: 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--
CREATE DATABASE IF NOT EXISTS `bookstore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bookstore`;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `genre`, `stock`, `price`, `image`) VALUES
(1, 'A Game of Thrones', 'George R.R. Martin', 'Fiction', 10, '10.49', 'https://m.media-amazon.com/images/I/81xf7GKNKTL.jpg'),
(2, 'Dune', 'Frank Herbert', 'Fiction', 1, '9.99', 'https://m.media-amazon.com/images/I/71oO1E-XPuL._AC_UF1000,1000_QL80_.jpg'),
(3, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Mystery', 0, '9.99', 'https://images.penguinrandomhouse.com/cover/9780307454546'),
(4, 'Pride and Prejudice', 'Jane Austen', 'Romance', 6, '14.00', 'https://images.penguinrandomhouse.com/cover/9780593622452'),
(5, 'The Shining', 'Stephen King', 'Other', 1, '9.99', 'https://m.media-amazon.com/images/I/81IMi+0fyJL._UF1000,1000_QL80_.jpg'),
(6, 'The Hunger Games', 'Suzanne Collins', 'Fantasy', 11, '9.79', 'https://www.worldofbooks.com/cdn/shop/files/1407132083.jpg?v=1718312249'),
(14, 'Alice in Wonderland', 'Lewis Carroll', 'Fantasy', 39, '12.00', 'https://www.gutenberg.org/files/11/11-h/images/cover.jpg'),
(16, 'Meow: A Novel', 'Sam Austen', 'Science Fiction', 7, '13.21', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVEA0rkb3DFu6xgDJNUmX9Y1fEs1YjlAU8BRJbLpne_1kOVVzL'),
(24, 'The Diary of a Young Girl', 'Anne Frank', 'Biography', 3, '10.99', 'https://cdn.kobo.com/book-images/1131b4f6-dc54-4f46-aadc-43d57e27f16f/1200/1200/False/the-diary-of-anne-frank-7.jpg'),
(25, 'John Adams', 'David McCullough', 'History', 11, '8.99', 'https://m.media-amazon.com/images/I/71wLn1zZBrL._AC_UF894,1000_QL80_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `book_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `book_id`, `quantity`) VALUES
(1, 2, 4, 2),
(2, 3, 4, 3),
(3, 2, 5, 5),
(4, 2, 6, 4),
(10, 3, 3, 1),
(20, 4, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'Dan', 'Admin', 'admin@email.com', '$2y$10$cnUq4cqM2bl48nuj6uH6S.3d7dYJ6hPDPruDDIHhwmJo9VtOgu7V.', 'admin'),
(2, 'Vanessa', 'Customer', 'customer@email.com', '$2y$10$kEAkNXFdz5aJAKE5Oy7xrO4D1PtpcTi9eJdoedSYvdo3jBQeprWFS', 'customer'),
(3, 'Lili', 'Smith', 'ls@tsemail.com', 'pass123', 'customer'),
(4, 'Tom', 'Smith', 'ts@email.com', 'pass234', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
