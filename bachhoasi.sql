-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2022 at 03:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bachhoasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CatID` varchar(10) NOT NULL,
  `CatName` varchar(50) NOT NULL,
  `CatDesc` varchar(1000) NOT NULL,
  `Cat_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CatID`, `CatName`, `CatDesc`, `Cat_image`) VALUES
('C01', 'BOBSON', 'BOBSON product', 'BOBSON-brand.png'),
('C02', 'Levi\'s', 'Levi\'s product', 'Levis-brand.png'),
('C03', 'EDWIN', 'EDWIN product', 'edwin_brand.png'),
('C04', 'MLB', 'MLB product', 'MLB-brand.png'),
('C05', 'Champion', 'Champion product', 'Champion-brand.png'),
('C06', 'GILDAN', 'GILDAN product', 'GILDAN_brand.png'),
('C07', 'DeLong', 'DeLong product', 'DeLONG-brand.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `CustName` varchar(50) NOT NULL,
  `CustSex` varchar(6) NOT NULL,
  `CustPhone` varchar(12) NOT NULL,
  `CustMail` varchar(100) NOT NULL,
  `CustAddress` varchar(100) NOT NULL,
  `Birthday` date NOT NULL,
  `State` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Username`, `Password`, `CustName`, `CustSex`, `CustPhone`, `CustMail`, `CustAddress`, `Birthday`, `State`) VALUES
('quangndgcc200030', 'e10adc3949ba59abbe56e057f20f883e', 'Quang Nguyen Duy', 'Male', '0916843367', 'quangndgcc200030@fpt.edu.vn', 'Can Tho city', '2002-08-05', 1),
('shmily', '9ea04374c01e81fcb68912c7cce3c9d0', 'Quang Nguyen', 'Male', '0327281160', 'quangnd@fpt.edu.vn', 'Can Tho city', '2002-08-05', 0),
('usercustomer', 'e10adc3949ba59abbe56e057f20f883e', 'Quang Nguyen', 'Male', '0123456789', 'usercustomer@gmail.com', 'Hung Loi, Ninh Kieu, Can Tho', '2002-08-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `sendDate` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `ProID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedID`, `Content`, `sendDate`, `state`, `Username`, `ProID`) VALUES
(6, 'Good clothes', '2022-05-11 17:15:09', 1, 'shmily', 'P02'),
(7, 'Good quality fabric', '2022-05-11 17:15:52', 1, 'shmily', 'P06'),
(10, 'Nice shirt, cool fabric', '2022-05-13 10:47:24', 1, 'shmily', 'P01'),
(11, 'Nice pants, soft fabric', '2022-05-13 10:49:55', 1, 'shmily', 'P03'),
(13, 'Shirt fits people, cool', '2022-05-13 17:01:39', 0, 'usercustomer', 'P12');

-- --------------------------------------------------------

--
-- Table structure for table `noti`
--

CREATE TABLE `noti` (
  `NoID` int(11) NOT NULL,
  `Nocontent` varchar(255) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ProID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderID` int(11) NOT NULL,
  `ProID` varchar(10) NOT NULL,
  `Qty` int(11) NOT NULL,
  `TotalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProID`, `Qty`, `TotalPrice`) VALUES
(36, 'P02', 1, 20),
(36, 'P04', 1, 25),
(37, 'P01', 1, 15),
(37, 'P14', 1, 30),
(38, 'P15', 1, 25),
(39, 'P18', 1, 35),
(40, 'P16', 1, 22),
(41, 'P02', 1, 20),
(42, 'P15', 2, 50),
(43, 'P02', 1, 20),
(43, 'P06', 2, 40),
(44, 'P10', 2, 18);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL,
  `DeliveryDate` datetime NOT NULL,
  `Deliverylocal` varchar(200) NOT NULL,
  `Paymentmethod` varchar(10) NOT NULL,
  `Username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `DeliveryDate`, `Deliverylocal`, `Paymentmethod`, `Username`) VALUES
(35, '2022-05-10 15:26:28', '2022-05-10 15:26:28', 'Can Tho city', 'Cash', 'quangndgcc200030'),
(36, '2022-05-10 15:27:53', '2022-05-10 15:27:53', 'Can Tho city', 'Cash', 'quangndgcc200030'),
(37, '2022-05-11 14:26:51', '2022-05-11 14:26:51', 'Can Tho city', 'Cash', 'shmily'),
(38, '2022-05-11 14:29:49', '2022-05-11 14:29:49', 'Can Tho city', 'Cash', 'shmily'),
(39, '2022-05-11 14:31:00', '2022-05-11 14:31:00', 'Can Tho city', 'Cash', 'shmily'),
(40, '2022-05-11 14:31:48', '2022-05-11 14:31:48', 'Can Tho city', 'Cash', 'shmily'),
(41, '2022-05-11 14:32:54', '2022-05-11 14:32:54', 'Can Tho city', 'Cash', 'shmily'),
(42, '2022-05-12 13:27:47', '2022-05-12 13:27:47', 'Can Tho city', 'Cash', 'shmily'),
(43, '2022-05-13 06:58:35', '2022-05-13 06:58:35', 'Can Tho city', 'Cash', 'shmily'),
(44, '2022-05-14 10:04:31', '2022-05-14 10:04:31', 'Hung Loi, Ninh Kieu, Can Tho', 'Cash', 'usercustomer');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProID` varchar(10) NOT NULL,
  `ProName` varchar(50) NOT NULL,
  `ProPrice` bigint(20) NOT NULL,
  `OldPrice` decimal(12,2) NOT NULL,
  `SmallDesc` varchar(1000) NOT NULL,
  `DetailDesc` text NOT NULL,
  `ProDate` datetime NOT NULL,
  `Pro_qty` int(11) NOT NULL,
  `Pro_image` varchar(200) NOT NULL,
  `CatID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProID`, `ProName`, `ProPrice`, `OldPrice`, `SmallDesc`, `DetailDesc`, `ProDate`, `Pro_qty`, `Pro_image`, `CatID`) VALUES
('P01', 'Black T-shirt', 15, '0.00', 'Small desc black T-shirt', 'Detail desc black T-shirt\r\n', '2022-05-10 18:28:13', 4, 'pro1.jpg', 'C02'),
('P02', 'Black jeans', 20, '0.00', 'Small desc black jeans', 'Detail desc black jeans', '2022-05-10 18:27:39', 1, 'pro2.jpg', 'C01'),
('P03', 'Light blue jeans', 10, '0.00', 'Small desc light blue jeans', 'Detail desc light blue jeans\r\n', '2022-05-10 18:26:38', 1, 'pro3.jpg', 'C03'),
('P04', 'Loose jeans', 25, '0.00', 'Small desc loose jeans', 'Detail desc loose jeans\r\n', '2022-05-10 18:25:15', 1, 'pro4.jpg', 'C04'),
('P05', 'Green T-shirt', 10, '0.00', 'Small desc green T-shirt', 'Detail desc green T-shirt', '2022-05-12 10:29:30', 2, 'download.jpg', 'C06'),
('P06', 'White T-shirt', 20, '0.00', 'Small desc white T-shirt', 'Detail desc white T-shirt', '2022-05-10 18:23:46', 1, 'z3398765216804_bbd37e95412ae276b0740ed82e342127.jpg', 'C05'),
('P07', 'Checkered shirt', 15, '0.00', 'Small desc checkered shirt', 'Detail desc checkered shirt\r\n', '2022-05-10 18:20:39', 5, 'z3398766422532_ede724b6a5829547fd899e7c185a16c8.jpg', 'C06'),
('P08', 'Shorts', 20, '0.00', 'Small descript shorts', 'Detail description shorts', '2022-05-10 18:19:22', 2, 'z3398766617127_271089c387fd75d4a1bcc129e6b7e14e.jpg', 'C02'),
('P09', 'Moss green shirt', 23, '0.00', 'Long sleeve', 'Detail desc long sleeve', '2022-05-10 18:35:51', 3, 'download (1).jpg', 'C05'),
('P10', 'Navy swim short', 9, '0.00', 'Small desc navy swim shorts', 'Detail desc navy swim shorts', '2022-06-02 04:32:50', 1, 'navyswimshorts.jpg', 'C05'),
('P11', 'Shorts Stock', 11, '0.00', 'Small desc shorts stock', 'Detail desc shorts stock', '2022-05-10 20:01:00', 3, 'ShortsStock.jpg', 'C04'),
('P12', 'Plaid shirt', 28, '0.00', 'Red and black', 'Detail desc Red and black', '2022-05-10 20:02:11', 2, 'images.jpg', 'C02'),
('P13', 'Blue t-shirt', 8, '0.00', 'Small desc blue t-shirt', 'Detail desc blue t-shirt', '2022-05-10 20:03:28', 5, '9088.png', 'C02'),
('P14', 'Leather jacket', 30, '0.00', 'Small Desc Leather Jacket', 'Detail Desc Leather Jacket', '2022-05-11 11:28:52', 5, 'LeatherJacket.jpg', 'C01'),
('P15', 'Bomber jacket', 25, '0.00', 'Small Desc Bomber Jacket', 'Detail Desc Bomber Jacket', '2022-05-11 11:29:51', 0, 'BomberJacket.jpg', 'C03'),
('P16', 'Plain hoodie', 22, '0.00', 'Small Desc Plain Hoodie', 'Detail Desc Plain Hoodie', '2022-05-11 11:30:41', 2, 'PlainHoodie.jpg', 'C04'),
('P17', 'Denim jacket', 30, '0.00', 'Small Desc Denim Jacket', 'Detail Desc Denim Jacket', '2022-05-11 11:31:42', 1, 'DenimJacket.jpeg', 'C06'),
('P18', 'Denim jeans', 35, '0.00', 'Small Desc large-black', 'Detail Desc large-black', '2022-05-11 11:32:58', 2, 'denim-jeans-large-black.jpg', 'C06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CatID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `CustPhone` (`CustPhone`,`CustMail`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedID`),
  ADD KEY `Username` (`Username`,`ProID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `noti`
--
ALTER TABLE `noti`
  ADD PRIMARY KEY (`NoID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderID`,`ProID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProID` (`ProID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProID`),
  ADD KEY `CatID` (`CatID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `noti`
--
ALTER TABLE `noti`
  MODIFY `NoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `customer` (`Username`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`);

--
-- Constraints for table `noti`
--
ALTER TABLE `noti`
  ADD CONSTRAINT `noti_ibfk_1` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProID`) REFERENCES `product` (`ProID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `customer` (`Username`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CatID`) REFERENCES `category` (`CatID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
