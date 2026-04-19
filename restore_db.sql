-- Repair and Re-initialize Shopping Portal
-- WARNING: This will drop corrupted tables and recreate a fresh schema

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `admin`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `subcategory`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `ordersdetails`;
DROP TABLE IF EXISTS `wishlist`;
DROP TABLE IF EXISTS `userlog`;
DROP TABLE IF EXISTS `productreviews`;
DROP TABLE IF EXISTS `addresses`;
SET FOREIGN_KEY_CHECKS = 1;

-- Admin Table
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Categories
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(255) DEFAULT NULL,
  `categoryDescription` longtext,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Sub-Categories
CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Products
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT NULL,
  `subCategory` int(11) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCompany` varchar(255) DEFAULT NULL,
  `productPrice` int(11) DEFAULT NULL,
  `productPriceBeforeDiscount` int(11) DEFAULT NULL,
  `productDescription` longtext,
  `productImage1` varchar(255) DEFAULT NULL,
  `productImage2` varchar(255) DEFAULT NULL,
  `productImage3` varchar(255) DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `productAvailability` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `shippingAddress` longtext,
  `shippingState` varchar(255) DEFAULT NULL,
  `shippingCity` varchar(255) DEFAULT NULL,
  `shippingPincode` int(11) DEFAULT NULL,
  `billingAddress` longtext,
  `billingState` varchar(255) DEFAULT NULL,
  `billingCity` varchar(255) DEFAULT NULL,
  `billingPincode` int(11) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Cart (Internal Sync table)
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `productQty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Orders
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `addressId` int(11) DEFAULT NULL,
  `totalAmount` decimal(20,2) DEFAULT NULL,
  `txnType` varchar(255) DEFAULT NULL,
  `txnNumber` varchar(255) DEFAULT NULL,
  `orderStatus` varchar(255) DEFAULT 'Pending',
  `orderDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `ordersdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `orderNumber` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Addresses
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `billingAddress` longtext,
  `billingCity` varchar(255) DEFAULT NULL,
  `billingState` varchar(255) DEFAULT NULL,
  `billingPincode` varchar(255) DEFAULT NULL,
  `billingCountry` varchar(255) DEFAULT NULL,
  `shippingAddress` longtext,
  `shippingCity` varchar(255) DEFAULT NULL,
  `shippingState` varchar(255) DEFAULT NULL,
  `shippingPincode` varchar(255) DEFAULT NULL,
  `shippingCountry` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- INSERT SAMPLE DATA --
INSERT INTO `admin` (`username`, `password`) VALUES ('admin', '$2y$10$9.p.t6Q8eS9v86bM5qH8ue0p/a5x3/i6Yv/O0z.t.Xh7p/x.i.f/i'); -- password is 'Test@123'

INSERT INTO `category` (`id`, `categoryName`, `categoryDescription`) VALUES (1, 'Elite Electronics', 'Modern and high-end electronic gadgets'), (2, 'Premium Lifestyle', 'Luxury accessories and lifestyle products');

INSERT INTO `subcategory` (`id`, `categoryid`, `subcategory`) VALUES (1, 1, 'Laptops'), (2, 1, 'Smartphones'), (3, 2, 'Luxury Watches');

INSERT INTO `products` (`category`, `subCategory`, `productName`, `productCompany`, `productPrice`, `productPriceBeforeDiscount`, `productDescription`, `shippingCharge`, `productAvailability`) VALUES 
(1, 1, 'UltraBook Pro 2026', 'FutureTech', 120000, 150000, 'The most powerful laptop ever built.', 500, 'In Stock'),
(1, 2, 'Nexus X Smartphone', 'Nexus', 85000, 95000, 'Experience the future in your hand.', 0, 'In Stock'),
(2, 3, 'Chrono Luxe V1', 'Chrono', 45000, 55000, 'Timeless elegance for the modern leader.', 100, 'In Stock');
