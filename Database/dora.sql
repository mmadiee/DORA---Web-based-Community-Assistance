-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 07:58 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dora`
--

-- --------------------------------------------------------

--
-- Table structure for table `social_worker_time_tracking`
--

CREATE TABLE `social_worker_time_tracking` (
  `id` int(11) NOT NULL,
  `sw_id` int(11) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_worker_time_tracking`
--

INSERT INTO `social_worker_time_tracking` (`id`, `sw_id`, `login_time`, `logout_time`) VALUES
(48, 2, '2023-09-03 19:02:04', '2023-09-03 19:49:05'),
(49, 2, '2023-09-03 19:49:53', '2023-09-03 19:50:01'),
(50, 2, '2023-09-03 19:52:53', '2023-09-03 19:54:07'),
(51, 2, '2023-09-03 20:15:04', '2023-09-04 02:13:17'),
(52, 2, '2023-09-03 21:17:11', '2023-09-04 02:13:17'),
(53, 2, '2023-09-03 21:17:12', '2023-09-04 02:13:17'),
(54, 2, '2023-09-04 02:17:23', '2023-09-06 05:49:15'),
(55, 2, '2023-09-04 12:40:24', '2023-09-06 05:49:15'),
(56, 2, '2023-09-04 12:53:31', '2023-09-06 05:49:15'),
(57, 2, '2023-09-06 04:59:11', '2023-09-06 05:49:15'),
(58, 2, '2023-09-09 12:41:49', '2023-09-09 12:42:22'),
(59, 2, '2023-09-09 12:43:30', '2023-09-09 13:13:22'),
(60, 2, '2023-09-09 13:16:57', '2023-09-09 14:22:53'),
(61, 2, '2023-09-09 15:08:52', '2023-09-09 20:44:50'),
(62, 2, '2023-09-09 19:57:41', '2023-09-09 20:44:50'),
(63, 2, '2023-09-09 20:45:49', '2023-09-09 20:47:17'),
(64, 2, '2023-09-09 20:49:40', '2023-09-09 20:51:04'),
(65, 2, '2023-09-09 20:53:13', '2023-09-09 21:23:18'),
(66, 2, '2023-09-09 21:23:22', '2023-09-09 22:21:37'),
(67, 2, '2023-09-09 22:22:02', '2023-09-09 22:41:46'),
(68, 2, '2023-09-09 22:43:22', '2023-09-09 23:52:13'),
(69, 2, '2023-09-10 13:10:59', '2023-09-10 15:43:16'),
(70, 2, '2023-09-10 23:49:05', '2023-09-11 03:06:08'),
(71, 2, '2023-09-12 17:01:21', '2023-09-13 21:08:50'),
(72, 3, '2023-09-13 16:42:55', '2023-09-13 21:08:50'),
(73, 2, '2023-09-13 18:25:31', '2023-09-13 21:08:50'),
(74, 2, '2023-09-13 19:15:21', '2023-09-13 21:08:50'),
(75, 2, '2023-09-13 19:22:07', '2023-09-13 21:08:50'),
(76, 2, '2023-09-13 19:28:01', '2023-09-13 21:08:50'),
(77, 2, '2023-09-13 20:24:16', '2023-09-13 21:08:50'),
(78, 2, '2023-09-26 18:30:16', '2023-09-26 19:37:45'),
(79, 2, '2023-09-26 18:59:34', '2023-09-26 19:37:45'),
(80, 2, '2023-09-26 19:36:31', '2023-09-26 19:37:45'),
(81, 2, '2023-09-27 10:29:30', '2023-09-27 10:31:51'),
(82, 2, '2023-09-27 11:40:04', '2023-09-27 11:40:28'),
(83, 2, '2023-09-27 11:55:51', '2023-09-27 17:34:33'),
(84, 2, '2023-09-27 17:51:23', '2023-09-27 20:15:34'),
(85, 2, '2023-09-27 17:59:01', '2023-09-27 20:15:34'),
(86, 2, '2023-09-27 20:30:02', '2023-10-01 22:03:15'),
(87, 2, '2023-09-27 21:31:05', '2023-10-01 22:03:15'),
(88, 2, '2023-10-01 21:56:07', '2023-10-01 22:03:15'),
(89, 11, '2023-10-01 22:03:34', NULL),
(90, 2, '2023-10-01 22:04:47', '2023-10-02 11:36:30'),
(91, 2, '2023-10-02 11:29:24', '2023-10-02 11:36:30'),
(92, 2, '2023-10-02 16:43:08', '2023-10-02 18:14:46'),
(93, 2, '2023-10-03 04:28:31', '2023-10-03 04:36:32'),
(94, 2, '2023-10-03 08:26:17', '2023-10-03 08:56:20'),
(95, 2, '2023-10-03 09:58:39', '2023-10-03 18:36:00'),
(96, 2, '2023-10-03 12:17:15', '2023-10-03 18:36:00'),
(97, 2, '2023-10-03 17:13:50', '2023-10-03 18:36:00'),
(98, 2, '2023-10-03 19:26:04', '2023-10-03 19:26:22'),
(99, 2, '2023-10-03 19:43:39', '2023-10-03 21:21:56'),
(100, 2, '2023-10-03 21:21:13', '2023-10-03 21:21:56'),
(101, 2, '2023-10-03 21:22:06', '2023-10-03 21:22:16'),
(102, 2, '2023-10-04 02:56:23', '2023-10-04 03:03:42'),
(103, 2, '2023-10-04 04:19:39', '2023-10-04 04:27:19'),
(104, 2, '2023-10-04 07:19:46', '2023-10-04 07:19:58'),
(105, 2, '2023-10-04 21:27:16', '2023-10-04 21:31:07'),
(106, 2, '2023-10-04 22:04:45', '2023-10-06 19:37:04'),
(107, 2, '2023-10-05 17:20:10', '2023-10-06 19:37:04'),
(108, 2, '2023-10-05 18:39:49', '2023-10-06 19:37:04'),
(109, 2, '2023-10-05 20:02:34', '2023-10-06 19:37:04'),
(110, 2, '2023-10-06 17:06:50', '2023-10-06 19:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_accs`
--

CREATE TABLE `tbl_admin_accs` (
  `admin_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_accs`
--

INSERT INTO `tbl_admin_accs` (`admin_id`, `name`, `email`, `password`, `image`, `contact`, `address`, `barangay`, `district`, `city`) VALUES
(2, 'Tracie Macatangay', 'tracie@gmail.com', '862d0b77008f5e151cda851abb5726a1', 'dora logo.png', '09195250367', '232 Juan Luna St, Binondo', 'Padilla', '2', 'Manila'),
(3, 'Darlene Alderson', 'darlene.alder@gmail.com', '65ff2bb85097dc900cb3fad8f2066181', 'images.jpg', '09663850987', '55 Hyacinth Street South Green Heights Village, Putatan', 'Putatan', '7', 'Muntinlupa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applicants`
--

CREATE TABLE `tbl_applicants` (
  `applicant_id` int(11) NOT NULL,
  `assistance_id` varchar(20) DEFAULT NULL,
  `appli_id` varchar(20) DEFAULT NULL,
  `text` varchar(200) NOT NULL,
  `proof` varchar(200) NOT NULL,
  `stat` varchar(20) NOT NULL,
  `submitteddate` varchar(20) NOT NULL,
  `qr_code_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_applicants`
--

INSERT INTO `tbl_applicants` (`applicant_id`, `assistance_id`, `appli_id`, `text`, `proof`, `stat`, `submitteddate`, `qr_code_path`) VALUES
(7, '7', '2', 'sadsadsa', 'school_supplies.jpg', 'Verified', '2023-05-12', '../../Views/SocialWorker/qr_codes/applicant_7.png'),
(10, '2', '6', 'asdasd', '346108876_606560987876132_128470284686433300_n.jpg', 'Invalid', '2023-05-13', '../../Views/SocialWorker/qr_codes/applicant_10.png'),
(14, '2', '7', 'asdasda', '346108876_606560987876132_128470284686433300_n.jpg', 'Invalid', '2023-05-14', '../../Views/SocialWorker/qr_codes/applicant_14.png'),
(15, '2', '5', 'Donation Title: Fundraising for the Homeless of ABC Street Body: The \"Fundraising for the Homeless of ABC Street\" project aims to raise funds to support the homeless population living on ABC Street in', '346108876_606560987876132_128470284686433300_n.jpg', 'Invalid', '2023-05-14', '../../Views/SocialWorker/qr_codes/applicant_15.png'),
(17, '7', '10', 'I need an extra allowance for my thesis project', 'college enrolment form.jpg', 'Verified', '2023-05-14', '../../Views/SocialWorker/qr_codes/applicant_17.png'),
(29, '2', '2', 'Sample Applicaitiom', 'errands 2.jpeg', 'Verified', '2023-10-03', '../../Views/SocialWorker/qr_codes/applicant_29.png'),
(30, '9', '2', 'Sample Assist Application', 'errands 1.jpeg', 'Pending', '2023-10-04', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appli_accs`
--

CREATE TABLE `tbl_appli_accs` (
  `appli_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_appli_accs`
--

INSERT INTO `tbl_appli_accs` (`appli_id`, `name`, `email`, `age`, `gender`, `contact`, `address`, `occupation`, `password`, `image`) VALUES
(2, 'Demi Manipolo', 'demi@gmail.com', '21', 'Female', '09207216375', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', 'a64c9e98476ec57c83b6edcdc6f76f74', 'dora logo.png'),
(5, 'Medalaine', 'saint@gmail.com', '19', 'Female', '09663850987', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', '7815696ecbf1c96e6894b779456d330e', '344293258_1288952505028232_8428134299567957280_n.jpg'),
(6, 'Judie Reyes', 'judie.reyes@gmail.com', '19', 'Female', '09125839571', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', 'c94897839feda80cbf79f574096cb8af', '346110526_726125709260373_1390888798368579943_n.jpg'),
(7, 'Medalaine', 'santosmedalaine@gmail.com', '36', 'Female', '09663850987', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', '46d3d32f012cc48a88e746eb496a9d29', '346110526_726125709260373_1390888798368579943_n.jpg'),
(10, 'Shane Monteroso', 'shane.monteroso@gmail.com', '28', 'Female', '09277708271', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', '7d12b8a0d82734c0d113012c4ecc9868', 'college girl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assistance`
--

CREATE TABLE `tbl_assistance` (
  `assistance_id` int(11) NOT NULL,
  `sw_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `avail_slot` int(11) NOT NULL,
  `uploadDate` varchar(100) NOT NULL,
  `deadline` varchar(50) NOT NULL,
  `text` varchar(200) NOT NULL,
  `location` varchar(100) NOT NULL,
  `proj_stat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_assistance`
--

INSERT INTO `tbl_assistance` (`assistance_id`, `sw_id`, `title`, `image`, `category`, `avail_slot`, `uploadDate`, `deadline`, `text`, `location`, `proj_stat`) VALUES
(2, 2, 'School Supplies for Elementary Students', 'school_supplies.jpg', 'School Supplies', 10, '2023-09-18', '2023-10-26', 'Good day! If you have a child or a younger sibling who are in need of necessary school supplies, kindly apply to our project. We will be providing a school supply set for 50 elementary students.', 'Barangay 104 Covered Court', 'ON GOING'),
(7, 2, 'Allowance for Working College Students ', '344297716_1003958710774726_5322018176862339526_n.jpg', 'Cash Assistance', 10, '2023-09-14', '2023-10-09', 'The Allowance for Working College Students\" project aims to provide financial support to college students who work to support themselves while studying. The project will provide a 1000 pesos allowance', 'Brgy. 105, Tondo, Manila', 'ON GOING'),
(9, 2, 'Sample Assistance Project', '1.png', 'Cash Assistance', 30, '2023-09-06', '2023-10-25', 'ajkbfehkaslkfbejaf', '271 Maginoo Street', 'ON GOING');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_don_proj`
--

CREATE TABLE `tbl_don_proj` (
  `don_project_id` int(11) NOT NULL,
  `sw_id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `goal` varchar(100) NOT NULL,
  `dropoff` varchar(200) NOT NULL,
  `qrgcash` varchar(200) NOT NULL,
  `start` varchar(30) NOT NULL,
  `end` varchar(20) NOT NULL,
  `proj_stat` text NOT NULL,
  `ext` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_don_proj`
--

INSERT INTO `tbl_don_proj` (`don_project_id`, `sw_id`, `image`, `text`, `title`, `category`, `goal`, `dropoff`, `qrgcash`, `start`, `end`, `proj_stat`, `ext`) VALUES
(117, 2, 'rizalfire.jpg', 'We are accepting donations for our kababayan that is hardly affected by Fire Victims especially the most vulnerable sector (PWD, Informal Sector, solo parents, etc.)', 'Call for Donations for the Fire Victims of Barangay Muzon, Taytay Rizal', 'Disaster Response', '10000', 'Brgy. Muzon Taytay, Rizal', 'gcashqr.jpg', '2023-09-06', '2023-09-26', 'PAST DUE', 2),
(119, 2, 'gorobao.jpg', 'The house of Ellen Rivera Gorabao in Zone 3 Aguic-Ican\r\nWest had been lost to a fire. We are humbly knocking on your doors to ask for your assistance for the Gorobao Family. For the affected family, the Barangay Malawag will conduct a donation drive.', 'Help for Gorobao Family', 'Disaster Response', '50000', 'Brgy Malawag, Brgy Hall', 'gcashqr.jpg', '2023-09-30', '2023-10-25', 'ON GOING', 0),
(139, 2, 'Dmuzon.png', 'Nangangailangan po ng damit, toiletries (gaya ng mga sabon, shampoo, toothbrush), tubig, kumot, at banig. Dalhin lamang sa Barangay Talayan Hall.\r\n\r\nHanapin si SK Chairman Lenard Karl Badiang, Elainne Eco, Jerica Sabordo, at Nathaniel Villaviray\r\n\r\nMaraming salamat sa pagtulong! Sama-sama, malalagpasan natin ang pagsubok na ito, sa gabay ng Dakilang Diyos Ama!', 'Call for Donations for the victims of Fire Incident at 199 Calamba, Brgy Talayan', 'Disaster Response', '100000', 'Barangay Talayan Hall', 'gcashqr.jpg', '2023-09-03', '2023-09-11', 'PAST DUE', 2),
(141, 2, 'Dmarigondon.png', 'Yesterday, a fire broke out at Sitio Marbeach, Barangay Marigondon affecting families and individuals. \r\n\r\nAccording to CDN in their article, “Firefighters of the Lapu-Lapu City Fire District battle an afternoon fire today, Feb. 12, in Sitio Marbeach, Barangay Marigondon this city at past 4 p.m. According to Fire Officer 3 (FO3) Jeffrey Gerodiaz, fire investigator in his report, that the fire was reported at 4:20 p.m., was placed under control at 4:48 p.m. and was declared fire out at 5:00 p.m. Gerodiaz said that the fire destroyed 26 houses and displaced 136 individuals.” \r\n\r\nTo give help and assistance to the affected families, the We Rise As One organization is organizing and initiating a donation drive and a relief operation from February 13-18, 2023; together with other Student Councils across Cebu Universities, and other affiliated Cebu Organizations.', 'Relief Operation For the Victims of the Marigondon Fire ', 'Disaster Response', '50000', 'Tower B Grand Residences Condominium, Kasambagan Cebu City', 'sampleqr.png', '2023-09-03', '2023-10-17', 'ON GOING', 2),
(153, 9, '344298704_1418893902245557_3007482624545186428_n.jpg', 'The \"Fundraising for the Homeless of ABC Street\" project aims to raise funds to support the homeless population living on ABC Street in our community. The project will focus on addressing the basic needs of homeless individuals and providing them with the support they require to get back on their feet. ', 'Fundraising for the Homeless of ABC Street ', 'Disaster Response', '10000', 'Barangay ABC Hall', 'sampleqr.png', '2023-09-14', '2023-11-10', 'COMPLETED', 1),
(164, 2, '1.png', 'Relelfjekjfirir', 'Sample Donation Project', 'Physical Health', '2000', 'Barangay 104 Hall', 'default-avatar.png', '2023-09-06', '2023-10-23', 'ON GOING', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dv_accs`
--

CREATE TABLE `tbl_dv_accs` (
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dv_accs`
--

INSERT INTO `tbl_dv_accs` (`user_id`, `name`, `email`, `age`, `gender`, `contact`, `address`, `occupation`, `password`, `image`) VALUES
(2, 'Laine Sanchez', 'saint@gmail.com', '20', 'Female', '09207216375', ' 1076 Que Grande Valenzuela, Metro Manila', 'Student', '78cd21f08d4bdee8c71fe8d59b0990eb', 'dora.png'),
(3, 'Medalaine Santos', 'santosmedalaine@gmail.com', '19', 'Female', '09207216375', ' 1076d Que Grande Valenzuela, Metro Manila', 'Student', '46d3d32f012cc48a88e746eb496a9d29', 'dora logo.png'),
(15, 'Marie Macatangay', 'marie@gmail.com', '20', 'Female', '09123421234', 'batangas', 'Student', 'b3725122c9d3bfef5664619e08e31877', '344297793_263438762733078_3633624384960728825_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery_images`
--

CREATE TABLE `tbl_gallery_images` (
  `image_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_type` int(1) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gallery_images`
--

INSERT INTO `tbl_gallery_images` (`image_id`, `project_id`, `project_type`, `image_path`, `uploaded_at`) VALUES
(1, 164, 1, 'gallery_images/1694546129_Emblem.png', '2023-09-12 19:15:29'),
(2, 164, 1, 'gallery_images/1694546129_Logo.png', '2023-09-12 19:15:29'),
(5, 164, 1, 'gallery_images/1695747992_events assistancec.jpg', '2023-09-26 17:06:32'),
(6, 164, 1, 'gallery_images/1695748016_errands 2.jpeg', '2023-09-26 17:06:56'),
(7, 164, 1, 'gallery_images/1695748032_sampleqr.png', '2023-09-26 17:07:12'),
(8, 164, 1, 'gallery_images/1695749824_errands 1.jpeg', '2023-09-26 17:37:04'),
(9, 164, 1, 'gallery_images/1695749824_errands.jpeg', '2023-09-26 17:37:04'),
(10, 164, 1, 'gallery_images/1695749824_cleaning.jpeg', '2023-09-26 17:37:04'),
(11, 164, 1, 'gallery_images/1695824758_@Rimokio.jfif', '2023-09-27 14:25:58'),
(12, 164, 1, 'gallery_images/1695824758_pic2.jpg', '2023-09-27 14:25:58'),
(15, 164, 1, 'gallery_images/1695825311_pic3.jpg', '2023-09-27 14:35:11'),
(20, 119, 1, 'gallery_images/1695826690_Text Version.png', '2023-09-27 14:58:10'),
(21, 3, 2, 'gallery_images/1695827430_Logo.png', '2023-09-27 15:10:30'),
(22, 6, 2, 'gallery_images/1695830356_errands 2.jpeg', '2023-09-27 15:59:16'),
(23, 2, 3, 'gallery_images/1695836449_events assistancec.jpg', '2023-09-27 17:40:49'),
(24, 7, 3, 'gallery_images/1695836517_Logo.png', '2023-09-27 17:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `report_ID` int(4) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_type` int(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reports`
--

INSERT INTO `tbl_reports` (`report_ID`, `project_id`, `project_type`, `title`, `body`, `date_posted`) VALUES
(5, 164, 1, 'Sample Report Title', 'body body body body body body body body body body body body body body body body body body body', '2023-09-13 02:51:01'),
(6, 139, 1, 'Final Report', 'Sample Final Report', '2023-09-13 04:11:02'),
(7, 164, 1, 'Report 2 ', 'This is report 2. ', '2023-09-14 00:22:33'),
(8, 164, 1, 'Sample Report ', 'This is without image.', '2023-09-14 03:03:27'),
(9, 139, 1, 'Project Turnout Sample', 'Sample sample sample ', '2023-09-27 18:22:31'),
(10, 117, 1, 'Project Completed! ', 'Hi hi hi', '2023-09-27 18:24:36'),
(11, 3, 2, 'Volunteer Report', 'volunteer report 1 ', '2023-09-27 20:59:01'),
(12, 6, 2, 'Mark Complete Vol Project 1 ', 'Sample Mark Complete Project 1 ', '2023-09-27 21:21:52'),
(13, 3, 2, 'Sample Vol report 2 ', 'sampleeee', '2023-09-27 21:58:30'),
(14, 3, 2, 'Sample Report 12', 'Without image', '2023-09-27 22:52:01'),
(15, 3, 2, 'Complete Vol', 'sample complete vol', '2023-09-27 23:16:42'),
(16, 2, 3, 'Sample Assistance Report', 'sample assistance report 1 ', '2023-09-28 01:36:27'),
(17, 2, 3, 'A1', 'sample', '2023-09-28 01:37:45'),
(18, 2, 3, 'A2', 'sampleplepd', '2023-09-28 01:39:44'),
(19, 2, 3, 'Assistance Project Complete', 'sample sample complete a1', '2023-09-28 01:42:41'),
(20, 7, 3, 'Sample report v2', 'Sampleee', '2023-09-28 02:30:35'),
(21, 119, 1, 'Sample Report', 'Sample Report', '2023-10-03 23:28:41'),
(22, 2, 3, 'Sample Report', 'asasdsad', '2023-10-04 00:26:29'),
(23, 119, 1, 'Sample Complete ', 'Complete Project', '2023-10-05 23:35:01'),
(24, 119, 1, 'Complete Project with Transparency Report', 'turnout blah blah', '2023-10-06 23:39:58'),
(25, 119, 1, 'Sample Report Complete', 'turnout', '2023-10-06 23:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports_images`
--

CREATE TABLE `tbl_reports_images` (
  `image_ID` int(11) NOT NULL,
  `report_ID` int(11) NOT NULL,
  `image_path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reports_images`
--

INSERT INTO `tbl_reports_images` (`image_ID`, `report_ID`, `image_path`) VALUES
(11, 5, 'reports_images/1694544661_errands 2.jpeg'),
(12, 5, 'reports_images/1694544661_errands 1.jpeg'),
(13, 6, 'reports_images/1694549462_errands.jpeg'),
(14, 7, 'reports_images/1694622153_cleaning.jpeg'),
(15, 9, 'reports_images/1695810151_errands 2.jpeg'),
(16, 10, 'reports_images/1695810276_errands 1.jpeg'),
(17, 11, 'reports_images/1695819541_girls black.png'),
(18, 11, 'reports_images/1695819541_girls.png'),
(19, 12, 'reports_images/1695820912_poison ivy.jpg'),
(20, 13, 'reports_images/1695823110_hs.png'),
(21, 15, 'reports_images/1695827802_errands 1.jpeg'),
(22, 16, 'reports_images/1695836187_iqjK2Gz.jpeg'),
(23, 17, 'reports_images/1695836265_pic2.jpg'),
(24, 19, 'reports_images/1695836561_Emblem.png'),
(25, 21, 'reports_images/1696346921_errands 1.jpeg'),
(26, 23, 'reports_images/1696520101_receiptsample.jpg'),
(27, 24, 'reports_images/1696606798_errands 2.jpeg'),
(28, 24, 'reports_images/1696606798_errands 1.jpeg'),
(29, 25, 'reports_images/1696607548_errands 2.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sw_accs`
--

CREATE TABLE `tbl_sw_accs` (
  `sw_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sw_accs`
--

INSERT INTO `tbl_sw_accs` (`sw_id`, `name`, `email`, `contact`, `password`, `profile`, `address`, `barangay`, `district`, `city`, `status`) VALUES
(2, 'Recchel Monteroso', 'recchel@gmail.com', '09663850987', '5f1f74ea052bad7fd056deafa1ae9b85', 'dora logo.png', 'Cavite', '104', '3', 'Bacoor', 'Verified'),
(3, 'Medalaine Santos', 'saint@gmail.com', '09203218765', '46d3d32f012cc48a88e746eb496a9d29', 'dora logo.png', 'Hyacinth', 'Putatan', '2', 'Muntinlupa', 'Verified'),
(5, 'Jenyn Stephanie', 'jenyn@gmail.com', '09876543210', '4ec8c6974c408b24413882b5f56d2d47', 'default-avatar.png', 'Immaculada Street', 'Brgy 97', '2', 'Manila', 'Verified'),
(9, 'Pamela Isley', 'ivy@gmail.com', '09195250367', 'e5bbf8a5d5b29c7ce5ba702906b53761', '344297793_263438762733078_3633624384960728825_n.jpg', 'Hyacinth Street', 'Barangay 104', '3', 'Muntinlupa City', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `transac_id` int(11) NOT NULL,
  `don_project_id` varchar(11) DEFAULT NULL COMMENT 'FK for  don_prod',
  `user_id` varchar(11) DEFAULT NULL COMMENT 'FK for user',
  `amount` varchar(100) NOT NULL,
  `receipt` varchar(100) NOT NULL,
  `stat` varchar(20) NOT NULL,
  `submitdate` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`transac_id`, `don_project_id`, `user_id`, `amount`, `receipt`, `stat`, `submitdate`) VALUES
(10, '117', '3', '800', 'gcashreceipt1.jpg', 'Verified', '2023-05-01'),
(11, '117', '3', '900', 'gcashreceipt1.jpg', 'Verified', '2023-05-02'),
(12, '117', '2', '800', 'gcashreceipt1.jpg', 'Invalid', '2023-05-03'),
(15, '117', '2', '800', 'gcashreceipt1.jpg', 'Invalid', '2023-05-03'),
(21, '117', '3', '800', 'gcashreceipt1.jpg', 'Invalid', '2023-05-04'),
(46, '153', '3', '1000', 'receiptsample.jpg', 'Invalid', '2023-09-06 09:28:59'),
(47, '153', '3', '1000', 'receiptsample.jpg', 'Pending', '2023-09-06 09:31:18'),
(49, '153', '3', '1000', 'receiptsample.jpg', 'Pending', '2023-09-06 09:38:59'),
(50, '153', '3', '1000', 'sampleqr.png', 'Pending', '2023-09-06 10:34:20'),
(51, '119', '3', '900', '342463607_1322145898725610_853734766843301268_n.jpg', 'Verified', '2023-10-01 19:09:22'),
(52, '119', '15', '500', 'receiptsample.jpg', 'Verified', '2023-10-04 00:58:11'),
(53, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-04 10:19:20'),
(54, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(55, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(56, '119', '3', '900', '342463607_1322145898725610_853734766843301268_n.jpg', 'Verified', '2023-10-01 19:09:22'),
(57, '119', '15', '500', 'receiptsample.jpg', 'Verified', '2023-10-04 00:58:11'),
(58, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-04 10:19:20'),
(59, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(60, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(61, '119', '3', '900', '342463607_1322145898725610_853734766843301268_n.jpg', 'Verified', '2023-10-01 19:09:22'),
(62, '119', '15', '500', 'receiptsample.jpg', 'Verified', '2023-10-04 00:58:11'),
(63, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-04 10:19:20'),
(64, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(65, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(66, '119', '3', '900', '342463607_1322145898725610_853734766843301268_n.jpg', 'Verified', '2023-10-01 19:09:22'),
(106, '119', '15', '500', 'receiptsample.jpg', 'Verified', '2023-10-04 00:58:11'),
(107, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-04 10:19:20'),
(108, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(109, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(110, '119', '3', '900', '342463607_1322145898725610_853734766843301268_n.jpg', 'Verified', '2023-10-01 19:09:22'),
(111, '119', '15', '500', 'receiptsample.jpg', 'Verified', '2023-10-04 00:58:11'),
(112, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-04 10:19:20'),
(113, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20'),
(114, '119', '3', '1000', 'receiptsample.jpg', 'Verified', '2023-10-06 10:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_volunteers`
--

CREATE TABLE `tbl_volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `vol_proj_id` varchar(11) DEFAULT NULL,
  `user_id` varchar(11) DEFAULT NULL,
  `story` varchar(500) NOT NULL,
  `valid` varchar(255) NOT NULL,
  `stat` varchar(20) NOT NULL,
  `submitteddate` varchar(20) NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_volunteers`
--

INSERT INTO `tbl_volunteers` (`volunteer_id`, `vol_proj_id`, `user_id`, `story`, `valid`, `stat`, `submitteddate`, `image_path`) VALUES
(2, '3', '3', 'To help', 'valid.png', 'Invalid', '2023-05-03', '../../Views/SocialWorker/vol_qrcodes/volunteer_2.png'),
(3, '3', '15', 'To help', 'valid.png', 'Verified', '2023-05-03', '../../Views/SocialWorker/vol_qrcodes/volunteer_3.png'),
(5, '6', '3', 'To help', 'valid.png', 'Pending', '2023-05-04', ''),
(6, '3', '2', 'To help', 'default-avatar.png', 'Invalid', '2023-05-04', ''),
(16, '4', '3', 'To help', '336178404_160446753203544_494636718257249519_n.jpg', 'Verified', '2023-05-09', '../../Views/SocialWorker/vol_qrcodes/volunteer_16.png'),
(34, '14', '3', 'I want to join....', 'valid.png', 'Pending', '2023-09-06', ''),
(36, '15', '3', 'asdasdasd', '323047368_566261678225438_5225973266391275988_n.jpg', 'Pending', '2023-10-03', ''),
(37, '15', '15', 'I want to join....', 'valid.png', 'Pending', '2023-10-04', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vol_proj`
--

CREATE TABLE `tbl_vol_proj` (
  `vol_proj_id` int(11) NOT NULL,
  `sw_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `uploadDate` varchar(30) NOT NULL,
  `eventDate` varchar(30) NOT NULL,
  `text` text NOT NULL,
  `totalGoal` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `proj_stat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vol_proj`
--

INSERT INTO `tbl_vol_proj` (`vol_proj_id`, `sw_id`, `title`, `image`, `category`, `uploadDate`, `eventDate`, `text`, `totalGoal`, `location`, `proj_stat`) VALUES
(3, 2, 'Supplementary Feeding Program in Tondo, Manila', 'vol.png', 'Food Security', '2023-09-27', '2023-10-04', 'Supplementary Feeding Program is the provision of food in addition to the regular meals to children currently enrolled in the Child Development Centers (CDCs) as part of the DSWD’s contribution to the Early Childhood Care and Development (ECCD) program of the government.', '5', 'Brgy. 105, Tondo, Manila', 'PAST DUE'),
(4, 2, 'Philippines: Disaster Resilience Improvement Program', 'Vdisaster.png', 'Disaster Response', '2023-09-23', '2023-10-20', 'The proposed program will provide the government with rapid access to resources to initiate disaster response and early recovery efforts and/or to address the health and economic impacts of health-related emergencies with minimal delay. The program is aligned with the Philippine Development Plan (PDP), 2017-2022 in supporting the integration of disaster resilience in various sectors of the economy and providing better access to healthcare, particularly in light of the vulnerabilities exposed by the coronavirus disease (COVID-19) pandemic.', '38', '6 ADB Avenue, Mandaluyong  City 1550, Metro Manila', 'ON GOING'),
(6, 2, 'Street Children Support in Tacloban City, Philippines', 'street.jpg', 'Food Security', '2023-09-24', '2023-10-21', 'This program is intended to help and stay with a host family and live like a local, help some of the poorest people in the Philippines, encourage the children and parents to send their kids to school, one way to break the poverty cycle, and to teach activities such as arts & crafts, sports, music and dance.\r\n\r\n• Provide assistance and counselling for poor families\r\n• Help to educate them into going to school and gaining an education\r\n• Work with the program, that provides meals and clothing to the families', '38', 'Tacloban City', 'ON GOING'),
(7, 5, 'Medical Outreach Program in Sampaloc, Manila', 'Vmedoutreach.png', 'Physical Health', '2023-09-25', '2023-10-18', 'In these communities you\'ll help with basic medical care and delivery highly nutritious food to hungry kids and communities. You\'ll assist our midwives at our pregnancy clinic as expecting mothers come in for checkups. We even have many visitors who are \r\npriveleged to help deliver a baby. We constantly hear stories of \'cutting the cord\' and \'catching the baby\'. In all these ministries, our main focus is creating connections and building relationships with people, sharing the life-changing love with them.', '19', 'Sampaloc, Manila', 'ON GOING'),
(14, 9, 'Call for Volunteers: Food Aid Packaging and Distribution ', '344292378_1498832364214309_6148424330772635_n.jpg', 'Food Security', '2023-09-24', '2023-09-30', 'Call for Volunteers: Food Aid Packaging and Distribution\" project aims to address food insecurity by packing and distributing food aid to individuals and families in need. The project will focus on mobilizing volunteers to help with the packaging and distribution of food aid in our community. ', '10', 'Brgy. 105, Tondo, Manila', 'PAST DUE'),
(15, 2, 'Sample Volunteer Project', '1.png', 'Food Security', '2023-09-26', '2023-10-19', 'FOOSFKSMMFKSMFD', '50', 'Barangay 104 Covered Court', 'ON GOING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `social_worker_time_tracking`
--
ALTER TABLE `social_worker_time_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_accs`
--
ALTER TABLE `tbl_admin_accs`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  ADD PRIMARY KEY (`applicant_id`);

--
-- Indexes for table `tbl_appli_accs`
--
ALTER TABLE `tbl_appli_accs`
  ADD PRIMARY KEY (`appli_id`);

--
-- Indexes for table `tbl_assistance`
--
ALTER TABLE `tbl_assistance`
  ADD PRIMARY KEY (`assistance_id`);

--
-- Indexes for table `tbl_don_proj`
--
ALTER TABLE `tbl_don_proj`
  ADD PRIMARY KEY (`don_project_id`);

--
-- Indexes for table `tbl_dv_accs`
--
ALTER TABLE `tbl_dv_accs`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_gallery_images`
--
ALTER TABLE `tbl_gallery_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`report_ID`);

--
-- Indexes for table `tbl_reports_images`
--
ALTER TABLE `tbl_reports_images`
  ADD PRIMARY KEY (`image_ID`),
  ADD KEY `fk_report_images_reports` (`report_ID`);

--
-- Indexes for table `tbl_sw_accs`
--
ALTER TABLE `tbl_sw_accs`
  ADD PRIMARY KEY (`sw_id`),
  ADD KEY `idx_sw_id` (`sw_id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`transac_id`);

--
-- Indexes for table `tbl_volunteers`
--
ALTER TABLE `tbl_volunteers`
  ADD PRIMARY KEY (`volunteer_id`);

--
-- Indexes for table `tbl_vol_proj`
--
ALTER TABLE `tbl_vol_proj`
  ADD PRIMARY KEY (`vol_proj_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `social_worker_time_tracking`
--
ALTER TABLE `social_worker_time_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `tbl_admin_accs`
--
ALTER TABLE `tbl_admin_accs`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_appli_accs`
--
ALTER TABLE `tbl_appli_accs`
  MODIFY `appli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_assistance`
--
ALTER TABLE `tbl_assistance`
  MODIFY `assistance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_don_proj`
--
ALTER TABLE `tbl_don_proj`
  MODIFY `don_project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tbl_dv_accs`
--
ALTER TABLE `tbl_dv_accs`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_gallery_images`
--
ALTER TABLE `tbl_gallery_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `report_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_reports_images`
--
ALTER TABLE `tbl_reports_images`
  MODIFY `image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_sw_accs`
--
ALTER TABLE `tbl_sw_accs`
  MODIFY `sw_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `transac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `tbl_volunteers`
--
ALTER TABLE `tbl_volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_vol_proj`
--
ALTER TABLE `tbl_vol_proj`
  MODIFY `vol_proj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_reports_images`
--
ALTER TABLE `tbl_reports_images`
  ADD CONSTRAINT `fk_report_images_reports` FOREIGN KEY (`report_ID`) REFERENCES `tbl_reports` (`report_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
