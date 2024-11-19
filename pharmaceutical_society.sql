-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmaceutical_society`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni_degrees`
--

CREATE TABLE `alumni_degrees` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_degrees`
--

INSERT INTO `alumni_degrees` (`id`, `alumni_id`, `degree`, `year`) VALUES
(19, 14, 'B. Pharm', 2019),
(20, 14, 'M. Pharm', 2023),
(24, 16, 'M. Pharm', 2017);

-- --------------------------------------------------------

--
-- Table structure for table `alumni_registration`
--

CREATE TABLE `alumni_registration` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_location` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_registration`
--

INSERT INTO `alumni_registration` (`id`, `full_name`, `dob`, `gender`, `email`, `phone`, `address`, `job_title`, `company`, `company_location`, `linkedin`, `twitter`, `facebook`, `profile_picture`, `created_at`) VALUES
(14, 'Mr Bibek Biswas', '2003-02-11', 'male', 'bibek@mail.com', '8778865764', 'Mandhan Nagar', 'Doctor', 'Clinical Medicos', 'Noida', 'https://www.linkedin.com/in/bibek-aesthetic-05292a258?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app', '', 'https://m.facebook.com/bibek-aesthetic', 'uploads/Dig Sol Cell Logo from sir.jpg', '2024-11-16 16:12:51'),
(16, 'Rajiv Dixit', '1998-02-01', 'male', 'rajib.aesthetic@gmail.com', '8712678534', 'Mandharia', 'Unemployed', 'Clinical Development LTD', 'Home', 'https://www.linkedin.com/in/rajib-x-05292a258?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app', 'https://www.x.com/76536125467', 'https://m.facebook.com/rajib-aesthetic', 'uploads/2nd.jpg', '2024-11-16 16:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `date`, `is_read`, `created_at`, `updated_at`) VALUES
(7, 'welcome', 'Welcome everyone to the gropup', '2024-11-18', 0, '2024-11-18 10:44:51', '2024-11-18 10:44:51'),
(8, 'dada', 'adad', '2024-11-19', 0, '2024-11-19 18:09:15', '2024-11-19 18:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_validated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author`, `timestamp`, `title`, `content`, `is_validated`) VALUES
(1, 'Dr. Anjali Verma', '2024-11-16 10:35:00', 'What are the latest developments in drug delivery systems?', 'Recent advancements in drug delivery systems include nanoparticles, liposomes, and microneedles. These innovations aim to improve the targeted delivery of drugs and reduce side effects.', 1),
(2, 'Dr. Rajiv Menon', '2024-11-16 11:05:00', 'What is the role of Pharmacogenomics in personalized medicine?', 'Pharmacogenomics is the study of how genes affect a person’s response to drugs. It helps tailor drug treatments based on individual genetic profiles, improving efficacy and minimizing side effects.', 0),
(4, 'Dr. Vikram Reddy', '2024-11-16 13:20:00', 'What are the challenges in clinical trials for new drugs?', 'Clinical trials face challenges such as patient recruitment, regulatory hurdles, and maintaining ethical standards. Overcoming these obstacles is essential for the success of new drug approvals.', 0),
(17, 'Current User', '2024-11-17 22:42:22', 'ghwadhadx', 'hjsd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_validated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `author`, `timestamp`, `title`, `content`, `is_validated`) VALUES
(1, 'Anita Sharma', '2024-11-16 09:15:00', 'What are the most effective drug delivery systems?', 'Effective drug delivery systems include targeted nanoparticles, liposomal encapsulation, and transdermal patches that provide controlled drug release to enhance therapeutic outcomes.', 0),
(2, 'Vikram Bhatia', '2024-11-16 10:00:00', 'How does Pharmacogenomics impact drug selection?', 'Pharmacogenomics helps in selecting the right drug for individuals by analyzing genetic variations that influence drug metabolism, thus improving drug efficacy and reducing adverse reactions.', 1),
(3, 'Meenal Gupta', '2024-11-16 11:30:00', 'What are the challenges in developing vaccines for emerging diseases?', 'Developing vaccines for emerging diseases involves challenges like understanding the virus’s mutation rate, safety concerns, and speeding up clinical trials without compromising safety.', 1),
(4, 'Arvind Patel', '2024-11-16 12:45:00', 'What are the recent advancements in gene therapy?', 'Recent advancements in gene therapy include CRISPR technology, which allows for precise gene editing to treat genetic disorders by modifying specific genes at the molecular level.', 0),
(7, 'Current User', '2024-11-17 22:42:31', 'steryre', 'seafwearfewt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `signup-admins`
--

CREATE TABLE `signup-admins` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup-admins`
--

INSERT INTO `signup-admins` (`id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'Kalyan', 'kalyangupta2002@gmail.com', '$2y$10$1YXxXUENIB/KpViBe0YI5e.Ss69UXE0ZAAEeAJLPUS9lmpuriA1EW');

-- --------------------------------------------------------

--
-- Table structure for table `signup-users`
--

CREATE TABLE `signup-users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup-users`
--

INSERT INTO `signup-users` (`id`, `user_name`, `user_email`, `user_password`) VALUES
(14, 'Kalyan Gupta', 'kalyangupta2002@gmail.com', '$2y$10$vWhK2xiXRc5lxVWU6mpMv.xbfEFM1wYZK8X6QIMUAWTpCSNDQYAWO'),
(15, 'saheb', 'saheb786182@gmail.com', '$2y$10$MWn9I10tfN2chLScPTF4s..PiRuhqUW/vTPb5LPf8cBSOZdOGXYbe');

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

CREATE TABLE `student_registration` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `year_of_admission` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_registration`
--

INSERT INTO `student_registration` (`id`, `full_name`, `email`, `phone`, `course`, `submitted_at`, `profile_pic`, `dob`, `year_of_admission`) VALUES
(7, 'Gulab Gogoi', 'gulab67@gmail.com', '6753778369', 'M. Pharm', '2024-11-16 16:15:53', 'uploads/students/profile_6738c539d3cd79.54788572.png', '2003-01-10', 2015),
(8, 'Shivam Das', 'shivamdas@gmail.com', '8657836527', 'B. Pharm', '2024-11-16 16:39:14', 'uploads/students/profile_6738cab29c4938.98423091.jpg', '2001-06-16', 2017);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_degrees`
--
ALTER TABLE `alumni_degrees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `alumni_registration`
--
ALTER TABLE `alumni_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup-admins`
--
ALTER TABLE `signup-admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `signup-users`
--
ALTER TABLE `signup-users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `student_registration`
--
ALTER TABLE `student_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni_degrees`
--
ALTER TABLE `alumni_degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `alumni_registration`
--
ALTER TABLE `alumni_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `signup-admins`
--
ALTER TABLE `signup-admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `signup-users`
--
ALTER TABLE `signup-users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_registration`
--
ALTER TABLE `student_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_degrees`
--
ALTER TABLE `alumni_degrees`
  ADD CONSTRAINT `alumni_degrees_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni_registration` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
