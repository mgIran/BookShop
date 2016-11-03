-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2016 at 06:01 PM
-- Server version: 5.6.33-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ketabici_ym_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ym_admins`
--

CREATE TABLE IF NOT EXISTS `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `ym_admins`
--

INSERT INTO `ym_admins` (`id`, `username`, `password`, `email`, `role_id`) VALUES
(1, 'rahbod', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmial.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_admin_roles`
--

CREATE TABLE IF NOT EXISTS `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ym_admin_roles`
--

INSERT INTO `ym_admin_roles` (`id`, `name`, `role`) VALUES
(1, 'Super Admin', 'superAdmin'),
(2, 'مدیریت', 'admin'),
(4, 'نویسنده', 'author');

-- --------------------------------------------------------

--
-- Table structure for table `ym_admin_role_permissions`
--

CREATE TABLE IF NOT EXISTS `ym_admin_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=120 ;

--
-- Dumping data for table `ym_admin_role_permissions`
--

INSERT INTO `ym_admin_role_permissions` (`id`, `role_id`, `module_id`, `controller_id`, `actions`) VALUES
(99, 2, 'base', 'BookCategoriesController', 'create,update,admin,delete,upload,deleteUpload,uploadIcon,deleteUploadIcon'),
(100, 2, 'base', 'BookController', 'reportSales,reportIncome'),
(101, 2, 'base', 'TagsController', 'index,create,update,admin,delete,list'),
(102, 2, 'admins', 'AdminsDashboardController', 'index'),
(103, 2, 'admins', 'AdminsManageController', 'index,views,create,update,admin,delete'),
(104, 2, 'admins', 'AdminsRolesController', 'create,update,admin,delete'),
(105, 2, 'advertises', 'AdvertisesManageController', 'create,update,admin,delete,upload,deleteUpload'),
(106, 2, 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve'),
(107, 2, 'manageBooks', 'ManageBooksBaseManageController', 'index,view,create,update,admin,delete,upload,deleteUpload,uploadFile,deleteUploadFile,changeConfirm,changePackageStatus,deletePackage,savePackage,images,download,downloadPackage'),
(108, 2, 'manageBooks', 'ManageBooksImagesManageController', 'upload,deleteUploaded'),
(109, 2, 'news', 'NewsCategoriesManageController', 'create,update,admin,delete'),
(110, 2, 'news', 'NewsManageController', 'create,update,admin,delete,upload,deleteUpload,order'),
(111, 2, 'pages', 'PageCategoriesManageController', 'index,view,create,update,admin,delete'),
(112, 2, 'pages', 'PagesManageController', 'index,create,update,admin,delete'),
(113, 2, 'publishers', 'PublishersPanelController', 'manageSettlement'),
(114, 2, 'setting', 'SettingManageController', 'changeSetting,social_links'),
(115, 2, 'tickets', 'TicketsDepartmentsController', 'admin,create,update,delete'),
(116, 2, 'tickets', 'TicketsManageController', 'delete,pendingTicket,openTicket,admin,index,view,create,update,closeTicket,upload,deleteUploaded,send'),
(117, 2, 'tickets', 'TicketsMessagesController', 'delete,create'),
(118, 2, 'users', 'UsersManageController', 'index,view,create,update,admin,delete,confirmDevID,deleteDevID,confirmPublisher,refusePublisher'),
(119, 2, 'users', 'UsersRolesController', 'create,update,admin,delete');

-- --------------------------------------------------------

--
-- Table structure for table `ym_books`
--

CREATE TABLE IF NOT EXISTS `ym_books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `description` text,
  `number_of_pages` int(5) DEFAULT NULL,
  `change_log` text,
  `language` varchar(20) DEFAULT NULL,
  `status` enum('disable','enable') CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT 'enable',
  `size` float unsigned DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `publisher_name` varchar(50) DEFAULT NULL,
  `publisher_id` int(10) unsigned DEFAULT NULL,
  `confirm` enum('pending','refused','accepted','change_required') DEFAULT 'pending',
  `confirm_date` varchar(20) DEFAULT NULL,
  `seen` tinyint(1) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`publisher_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `ym_books`
--

INSERT INTO `ym_books` (`id`, `title`, `icon`, `description`, `number_of_pages`, `change_log`, `language`, `status`, `size`, `category_id`, `publisher_name`, `publisher_id`, `confirm`, `confirm_date`, `seen`, `download`, `deleted`) VALUES
(52, 'دختر شینا', 'JNSLy1477560156.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', 120, '', 'فارسی', 'enable', NULL, 52, NULL, 45, 'pending', '1477687276', 255, 0, 0),
(53, 'فتح خون', 'gvXUa1477582174.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', 150, '', 'فارسی', 'enable', NULL, 52, 'واحه', NULL, 'accepted', '1477687320', 97, 0, 0),
(54, 'دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل', 'wD8Oc1477588685.jpg', '<p>دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل</p>\r\n', 150, '', 'فارسی', 'enable', NULL, 52, 'گلوری', NULL, 'accepted', '1477687323', 37, 0, 0),
(55, 'تست', 'btT6c1477722786.jpg', '<p>لورم ایپسوم</p>\r\n', 1025, '', 'فارسی', 'enable', NULL, 55, 'انتشارات علوی', NULL, 'accepted', NULL, 0, 0, 0),
(56, 'test', 'Xcdss1478068579.jpg', '<p>testttt</p>\r\n', 12, '', 'en', 'enable', NULL, 52, NULL, 43, 'pending', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_advertises`
--

CREATE TABLE IF NOT EXISTS `ym_book_advertises` (
  `book_id` int(10) unsigned NOT NULL COMMENT 'برنامه',
  `cover` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'تصویر کاور',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT 'وضعیت',
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ym_book_advertises`
--

INSERT INTO `ym_book_advertises` (`book_id`, `cover`, `status`, `create_date`) VALUES
(53, 'KUOsW1477596138.jpg', 1, '1477596158');

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_buys`
--

CREATE TABLE IF NOT EXISTS `ym_book_buys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_categories`
--

CREATE TABLE IF NOT EXISTS `ym_book_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `icon_color` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `ym_book_categories`
--

INSERT INTO `ym_book_categories` (`id`, `title`, `parent_id`, `path`, `image`, `icon`, `icon_color`) VALUES
(52, 'پزشکی', NULL, NULL, 'OexZc1477466535.jpg', 'c2gA51477466537.svg', '#accf3d'),
(53, 'مهندسی', NULL, NULL, 'wMjo41477466558.jpg', 'Kd4hS1477466560.svg', '#2e9fc7'),
(54, 'حسابداری', NULL, NULL, 'c2gA51477466621.jpg', 'aUw011477477874.svg', '#e96e44'),
(55, 'کشاورزی', NULL, NULL, 'DAeop1477466811.jpg', 'Uy1Uw1477466814.svg', '#fbb11a');

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_discounts`
--

CREATE TABLE IF NOT EXISTS `ym_book_discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `start_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان',
  `percent` int(3) unsigned DEFAULT NULL COMMENT 'درصد',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_book_discounts`
--

INSERT INTO `ym_book_discounts` (`id`, `book_id`, `start_date`, `end_date`, `percent`) VALUES
(1, 52, '1477670471', '1479679471', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_images`
--

CREATE TABLE IF NOT EXISTS `ym_book_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ym_book_images`
--

INSERT INTO `ym_book_images` (`id`, `book_id`, `image`) VALUES
(13, 52, 'bGccf1477566838.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_packages`
--

CREATE TABLE IF NOT EXISTS `ym_book_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `book_id` int(10) unsigned DEFAULT NULL COMMENT 'برنامه',
  `version` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نسخه',
  `package_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'نام بسته',
  `isbn` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شابک',
  `file_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'فایل',
  `create_date` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ بارگذاری',
  `publish_date` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ انتشار',
  `status` enum('pending','accepted','refused','change_required') CHARACTER SET utf8 DEFAULT 'pending' COMMENT 'وضعیت',
  `reason` text CHARACTER SET utf8 COLLATE utf8_persian_ci COMMENT 'دلیل',
  `for` enum('new_book','old_book') CHARACTER SET utf8 DEFAULT NULL,
  `price` decimal(10,0) unsigned DEFAULT NULL,
  `sale_printed` tinyint(4) DEFAULT NULL COMMENT 'فروش نسخه چاپی',
  `printed_price` decimal(10,0) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `ym_book_packages`
--

INSERT INTO `ym_book_packages` (`id`, `book_id`, `version`, `package_name`, `isbn`, `file_name`, `create_date`, `publish_date`, `status`, `reason`, `for`, `price`, `sale_printed`, `printed_price`) VALUES
(46, 52, '1', 'تیراژ اول', '978-3-16-148410-0', 'AXfrV1477566608.docx', '1477566615', '1477687277', 'accepted', '', 'old_book', '10000', NULL, '150000'),
(47, 53, '1', 'فتح خون جلد اول', '978-3-16-148410-0', '2BRbY1477582248.docx', '1477582805', '1477687320', 'accepted', '', 'old_book', '1500', NULL, '5000'),
(48, 54, '1', 'جلد اول', '978-3-16-148410-0', 'kpg841477592881.docx', '1477592909', '1477687323', 'accepted', '', 'new_book', '100', NULL, '1220');

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_persons`
--

CREATE TABLE IF NOT EXISTS `ym_book_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام',
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام خانوادگی',
  `alias` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام مستعار',
  `birthday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ تولد',
  `deathday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ وفات',
  `biography` text COLLATE utf8_persian_ci COMMENT 'شرح حال',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_book_persons`
--

INSERT INTO `ym_book_persons` (`id`, `name`, `family`, `alias`, `birthday`, `deathday`, `biography`) VALUES
(1, 'یوسف', 'مبشری', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_person_roles`
--

CREATE TABLE IF NOT EXISTS `ym_book_person_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان نقش',
  `order` int(10) unsigned NOT NULL COMMENT 'الویت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ym_book_person_roles`
--

INSERT INTO `ym_book_person_roles` (`id`, `title`, `order`) VALUES
(1, 'نویسنده', 1),
(2, 'مترجم', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_person_role_rel`
--

CREATE TABLE IF NOT EXISTS `ym_book_person_role_rel` (
  `book_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`person_id`,`role_id`),
  KEY `person_id` (`person_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ym_book_person_role_rel`
--

INSERT INTO `ym_book_person_role_rel` (`book_id`, `person_id`, `role_id`) VALUES
(52, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_ratings`
--

CREATE TABLE IF NOT EXISTS `ym_book_ratings` (
  `user_id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  `rate` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`book_id`),
  KEY `app_id` (`book_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ym_book_ratings`
--

INSERT INTO `ym_book_ratings` (`user_id`, `book_id`, `rate`) VALUES
(44, 52, 5),
(45, 52, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ym_book_tag_rel`
--

CREATE TABLE IF NOT EXISTS `ym_book_tag_rel` (
  `book_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `for_seo` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`book_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ym_comments`
--

CREATE TABLE IF NOT EXISTS `ym_comments` (
  `owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `owner_id` int(12) NOT NULL,
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_comment_id` int(12) DEFAULT NULL,
  `creator_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_email` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_persian_ci,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `owner_name` (`owner_name`,`owner_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=99 ;

--
-- Dumping data for table `ym_comments`
--

INSERT INTO `ym_comments` (`owner_name`, `owner_id`, `comment_id`, `parent_comment_id`, `creator_id`, `user_name`, `user_email`, `comment_text`, `create_time`, `update_time`, `status`) VALUES
('Books', 52, 98, NULL, 45, NULL, NULL, 'asd', 1475916072, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_counter_save`
--

CREATE TABLE IF NOT EXISTS `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ym_counter_save`
--

INSERT INTO `ym_counter_save` (`save_name`, `save_value`) VALUES
('counter', 141),
('day_time', 2457696),
('max_count', 5),
('max_time', 1457598600),
('yesterday', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_counter_users`
--

CREATE TABLE IF NOT EXISTS `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ym_counter_users`
--

INSERT INTO `ym_counter_users` (`user_ip`, `user_time`) VALUES
('837ec5754f503cfaaee0929fd48974e7', 1478182131),
('f528764d624db129b32c21fbca0cb8d6', 1478182663);

-- --------------------------------------------------------

--
-- Table structure for table `ym_news`
--

CREATE TABLE IF NOT EXISTS `ym_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `summary` varchar(2000) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'خلاصه',
  `body` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'متن خبر',
  `image` varchar(200) DEFAULT NULL COMMENT 'تصویر',
  `seen` varchar(255) DEFAULT NULL COMMENT 'بازدید',
  `create_date` varchar(20) DEFAULT NULL,
  `publish_date` varchar(20) DEFAULT NULL COMMENT 'تاریخ انتشار',
  `status` enum('draft','publish') DEFAULT NULL COMMENT 'وضعیت',
  `category_id` int(10) unsigned NOT NULL COMMENT 'دسته بندی',
  `order` int(10) unsigned DEFAULT NULL COMMENT 'ترتیب',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `ym_news_categories`
--

CREATE TABLE IF NOT EXISTS `ym_news_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `parent_id` int(10) unsigned DEFAULT NULL COMMENT 'والد',
  `path` varchar(255) DEFAULT NULL COMMENT 'مسیر',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ym_news_categories`
--

INSERT INTO `ym_news_categories` (`id`, `title`, `parent_id`, `path`) VALUES
(4, 'عمومی', NULL, NULL),
(5, 'کلاس های ارائه شده', NULL, NULL),
(6, 'اخبار جدید در مورد امتحان تافل آی بی تی', NULL, NULL),
(7, 'کارنامه  زبان آموزان', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ym_news_tag_rel`
--

CREATE TABLE IF NOT EXISTS `ym_news_tag_rel` (
  `tag_id` int(10) unsigned NOT NULL,
  `news_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`news_id`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ym_pages`
--

CREATE TABLE IF NOT EXISTS `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ym_pages`
--

INSERT INTO `ym_pages` (`id`, `title`, `summary`, `category_id`) VALUES
(1, 'درباره ما', 'متن صفحه درباره ما', 1),
(2, 'درباره ما - بخش فوتر', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', 1),
(3, 'درباره ما - بخش نمایش کتاب', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', 1),
(6, 'راهنما', 'متن راهنما', 1),
(7, 'قرارداد ناشران', 'متن قرارداد', 1),
(8, 'تماس با ما', 'متن تماس با ما', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ym_page_categories`
--

CREATE TABLE IF NOT EXISTS `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_page_categories`
--

INSERT INTO `ym_page_categories` (`id`, `name`, `slug`, `multiple`) VALUES
(1, 'صفحات استاتیک', 'base', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_site_setting`
--

CREATE TABLE IF NOT EXISTS `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ym_site_setting`
--

INSERT INTO `ym_site_setting` (`id`, `name`, `title`, `value`) VALUES
(1, 'site_title', 'عنوان سایت', 'مرجع خرید و فروش کتاب آنلاین'),
(2, 'default_title', 'عنوان پیش فرض صفحات', 'کتابیک'),
(3, 'keywords', 'کلمات کلیدی سایت', ''),
(4, 'site_description', 'شرح وبسایت', ''),
(5, 'buy_credit_options', 'گزینه های خرید اعتبار', '["5000","10000","20000"]'),
(6, 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '1000'),
(7, 'tax', 'میزان مالیات (درصد)', '9'),
(8, 'commission', 'حق کمیسیون (درصد)', '15'),
(9, 'social_links', 'شبکه های اجتماعی', '{"facebook":"http:\\/\\/facebook.com","twitter":"http:\\/\\/twitter.com"}'),
(10, 'android_app_url', 'آدرس دانلود نرم افزار اندروید سایت', 'http://'),
(11, 'windows_app_url', 'آدرس دانلود نرم افزار ویندوز سایت', 'http://');

-- --------------------------------------------------------

--
-- Table structure for table `ym_tags`
--

CREATE TABLE IF NOT EXISTS `ym_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=637 ;

-- --------------------------------------------------------

--
-- Table structure for table `ym_tickets`
--

CREATE TABLE IF NOT EXISTS `ym_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه تیکت',
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` enum('waiting','pending','open','close') COLLATE utf8_persian_ci DEFAULT 'waiting' COMMENT 'وضعیت تیکت',
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `subject` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `department_id` int(10) unsigned DEFAULT NULL COMMENT 'بخش',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ym_ticket_departments`
--

CREATE TABLE IF NOT EXISTS `ym_ticket_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ym_ticket_departments`
--

INSERT INTO `ym_ticket_departments` (`id`, `title`) VALUES
(1, 'مدیریت'),
(2, 'بخش فنی'),
(3, 'بخش پرداخت ها');

-- --------------------------------------------------------

--
-- Table structure for table `ym_ticket_messages`
--

CREATE TABLE IF NOT EXISTS `ym_ticket_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL COMMENT 'تیکت',
  `sender` enum('admin','supporter','user') COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `text` text COLLATE utf8_persian_ci COMMENT 'متن',
  `attachment` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل ضمیمه',
  `visit` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ym_users`
--

CREATE TABLE IF NOT EXISTS `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `ym_users`
--

INSERT INTO `ym_users` (`id`, `username`, `password`, `email`, `role_id`, `create_date`, `status`, `verification_token`, `change_password_request_count`) VALUES
(43, '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', 2, '1460634664', 'active', 'ec0bfa4e54eed8afb0d7fb0305d52759', 1),
(44, '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'mr.m.gharagozlu@gmail.com', 2, '1460634664', 'deleted', 'ec0bfa4e54eed8afb0d7fb0305d52759', 0),
(45, '', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'yusef.mobasheri@gmail.com', 2, '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', 1),
(46, 'k.rahebi@gmail.com', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'k.rahebi@gmail.com', 1, '1469083948', 'active', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_book_bookmark`
--

CREATE TABLE IF NOT EXISTS `ym_user_book_bookmark` (
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`user_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `app_id` (`book_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ym_user_book_bookmark`
--

INSERT INTO `ym_user_book_bookmark` (`user_id`, `book_id`) VALUES
(43, 52),
(43, 53);

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_details`
--

CREATE TABLE IF NOT EXISTS `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `fa_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `en_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام انگلیسی',
  `fa_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `en_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت انگلیسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `national_card_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر کارت ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نشانی دقیق پستی',
  `credit` double DEFAULT NULL COMMENT 'اعتبار',
  `publisher_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه توسعه دهنده',
  `details_status` enum('refused','pending','accepted') CHARACTER SET utf8 DEFAULT 'pending' COMMENT 'وضعیت اطلاعات کاربر',
  `monthly_settlement` tinyint(4) DEFAULT '0' COMMENT 'تسویه حساب ماهانه',
  `iban` varchar(24) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره شبا',
  `nickname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام نمایشی',
  `type` enum('real','legal') CHARACTER SET utf8 DEFAULT 'real' COMMENT 'نوع حساب',
  `post` enum('ceo','board') CHARACTER SET utf8 DEFAULT NULL COMMENT 'سمت',
  `company_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شرکت',
  `registration_number` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره ثبت',
  `registration_certificate_image` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تصویر گواهی ثبت شرکت',
  `score` int(10) unsigned DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'آواتار',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ym_user_details`
--

INSERT INTO `ym_user_details` (`user_id`, `fa_name`, `en_name`, `fa_web_url`, `en_web_url`, `national_code`, `national_card_image`, `phone`, `zip_code`, `address`, `credit`, `publisher_id`, `details_status`, `monthly_settlement`, `iban`, `nickname`, `type`, `post`, `company_name`, `registration_number`, `registration_certificate_image`, `score`, `avatar`) VALUES
(43, 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', 1760, 'Masoud', 'accepted', 1, '123456789123456789123456', 'Masoud', 'real', NULL, NULL, NULL, NULL, 0, NULL),
(44, 'مسعود قراگوزلو', NULL, '', NULL, NULL, NULL, '38888888', '3718958691', 'قم - همونجا', 2000, NULL, 'pending', 0, NULL, 'وای ام', 'legal', 'ceo', 'وب ایران', '134644535', 'OPxRK1466844466.jpg', 0, NULL),
(45, 'یوسف مبشری', 'yusef', NULL, NULL, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', 4951000, 'Yusef', 'accepted', 1, '23423', NULL, 'real', NULL, NULL, NULL, NULL, 1, NULL),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 0, NULL, NULL, 'real', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_dev_id_requests`
--

CREATE TABLE IF NOT EXISTS `ym_user_dev_id_requests` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه درخواستی',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_notifications`
--

CREATE TABLE IF NOT EXISTS `ym_user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'متن پیام',
  `seen` tinyint(4) NOT NULL COMMENT 'مشاهده شده',
  `date` varchar(30) NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `ym_user_notifications`
--

INSERT INTO `ym_user_notifications` (`id`, `user_id`, `message`, `seen`, `date`) VALUES
(2, 43, 'اطلاعات شما توسط مدیر سیستم تایید شد.', 1, '1461845059'),
(3, 43, 'شناسه شما توسط مدیر سیستم تایید شد.', 1, '1461845059'),
(4, 43, 'برنامه  برنامه لیدکامب - لکنت کودکان تایید شده است.', 1, '1461845059'),
(6, 43, 'برنامه برنامه آزمایشی تایید شده است.', 1, '1464262310'),
(7, 43, 'برنامه برنامه آزمایشی تایید شده است.', 1, '1464262422'),
(8, 43, 'برنامه برنامه آزمایشی تایید شده است.', 1, '1464353232'),
(9, 43, 'بسته asdfsdf توسط مدیر سیستم حذف شد.', 1, '1464358109'),
(10, 43, 'بسته ir.tgbs.android.iranappasd توسط مدیر سیستم حذف شد.', 1, '1464358330'),
(13, 43, 'بسته ir.tgbs.android.iranapp3 توسط مدیر سیستم رد شد.', 1, '1465459197'),
(14, 43, 'بسته ir.tgbs.android.iranapp2 نیاز به تغییر دارد.', 1, '1465459228'),
(15, NULL, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', 0, '1467040015'),
(16, 43, 'بسته ir.tgbs.android.iranapp123 توسط مدیر سیستم تایید شد.', 1, '1469083395'),
(17, 43, 'برنامه تلگرام نیاز به تغییرات دارد.', 1, '1469083457'),
(18, 45, 'بسته ir.tgbs.android.iranapp2 توسط مدیر سیستم تایید شد.', 1, '1470122805'),
(19, 45, 'برنامه موبوگرام رد شده است.', 1, '1470123368'),
(20, 45, 'برنامه موبوگرام نیاز به تغییرات دارد.', 1, '1470123486'),
(21, 45, 'برنامه موبوگرام تایید شده است.', 1, '1470123513'),
(22, 45, 'نوبت چاپ تیراژ اول نیاز به تغییر دارد.', 1, '1477567625'),
(23, 45, 'کتاب دختر شینا نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش کتاب مراجعه فرمایید.', 1, '1477568006'),
(24, 45, 'کتاب دختر شینا تایید شده است.', 1, '1477568018'),
(25, NULL, 'نوبت چاپ فتح خون جلد اول توسط مدیر سیستم تایید شد.', 0, '1477584165'),
(26, 45, 'کتاب دختر شینا تایید شده است.', 1, '1477685627'),
(27, 45, 'کتاب دختر شینا تایید شده است.', 1, '1477685687'),
(28, NULL, 'کتاب فتح خون تایید شده است.', 0, '1477685708'),
(29, NULL, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', 0, '1477686990'),
(30, 45, 'کتاب دختر شینا تایید شده است.', 1, '1477687246'),
(31, 45, 'کتاب دختر شینا تایید شده است.', 1, '1477687277'),
(32, NULL, 'کتاب فتح خون تایید شده است.', 0, '1477687321'),
(33, NULL, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', 0, '1477687323');

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_roles`
--

CREATE TABLE IF NOT EXISTS `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ym_user_roles`
--

INSERT INTO `ym_user_roles` (`id`, `name`, `role`) VALUES
(1, 'کاربر معمولی', 'user'),
(2, 'ناشر', 'publisher');

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_role_permissions`
--

CREATE TABLE IF NOT EXISTS `ym_user_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `ym_user_role_permissions`
--

INSERT INTO `ym_user_role_permissions` (`id`, `role_id`, `module_id`, `controller_id`, `actions`) VALUES
(17, 1, 'base', 'BookController', 'buy,bookmark,rate'),
(18, 1, 'publishers', 'PublishersPanelController', 'uploadNationalCardImage,uploadRegistrationCertificateImage,signup'),
(19, 1, 'tickets', 'TicketsDepartmentsController', 'create,update'),
(20, 1, 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send'),
(21, 1, 'tickets', 'TicketsMessagesController', 'delete,create'),
(22, 1, 'users', 'UsersCreditController', 'buy,bill,verify'),
(23, 1, 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,bookmarked,library,transactions,downloaded,changePassword'),
(33, 2, 'base', 'BookController', 'buy,bookmark,rate'),
(34, 2, 'base', 'TagsController', 'list'),
(35, 2, 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve'),
(36, 2, 'publishers', 'PublishersPanelController', 'uploadNationalCardImage,uploadRegistrationCertificateImage,account,index,discount,settlement,sales,documents'),
(37, 2, 'publishers', 'PublishersBooksController', 'create,update,delete,uploadImage,deleteImage,upload,deleteUpload,uploadFile,deleteUploadFile,images,savePackage'),
(38, 2, 'tickets', 'TicketsDepartmentsController', 'create,update'),
(39, 2, 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send'),
(40, 2, 'tickets', 'TicketsMessagesController', 'delete,create'),
(41, 2, 'users', 'UsersCreditController', 'buy,bill,verify'),
(42, 2, 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,changePassword,bookmarked,downloaded,transactions,library');

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_settlement`
--

CREATE TABLE IF NOT EXISTS `ym_user_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(15) DEFAULT NULL COMMENT 'مبلغ',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `iban` varchar(24) DEFAULT NULL COMMENT 'شماره شبا',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `ym_user_settlement`
--

INSERT INTO `ym_user_settlement` (`id`, `user_id`, `amount`, `date`, `iban`) VALUES
(28, 43, '19000', '1462175546', '234242342');

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_transactions`
--

CREATE TABLE IF NOT EXISTS `ym_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(10) DEFAULT NULL COMMENT 'مقدار',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `status` enum('unpaid','paid') DEFAULT 'unpaid' COMMENT 'وضعیت',
  `token` varchar(50) DEFAULT NULL COMMENT 'کد رهگیری',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ym_user_transactions`
--

INSERT INTO `ym_user_transactions` (`id`, `user_id`, `amount`, `date`, `status`, `token`, `description`) VALUES
(1, 43, '5000', '1461646925', 'paid', 'j2343jk4h2k4h24h', 'خرید اعتبار از طریق درگاه زرین پال'),
(4, 45, '100', '1470118630', 'unpaid', NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ym_admins`
--
ALTER TABLE `ym_admins`
  ADD CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_admin_role_permissions`
--
ALTER TABLE `ym_admin_role_permissions`
  ADD CONSTRAINT `ym_admin_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_books`
--
ALTER TABLE `ym_books`
  ADD CONSTRAINT `ym_books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_advertises`
--
ALTER TABLE `ym_book_advertises`
  ADD CONSTRAINT `ym_book_advertises_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_buys`
--
ALTER TABLE `ym_book_buys`
  ADD CONSTRAINT `ym_book_buys_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_book_buys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_categories`
--
ALTER TABLE `ym_book_categories`
  ADD CONSTRAINT `ym_book_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_discounts`
--
ALTER TABLE `ym_book_discounts`
  ADD CONSTRAINT `ym_book_discounts_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_images`
--
ALTER TABLE `ym_book_images`
  ADD CONSTRAINT `ym_book_images_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_packages`
--
ALTER TABLE `ym_book_packages`
  ADD CONSTRAINT `ym_book_packages_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_person_role_rel`
--
ALTER TABLE `ym_book_person_role_rel`
  ADD CONSTRAINT `ym_book_person_role_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_book_person_role_rel_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ym_book_persons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_book_person_role_rel_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `ym_book_person_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_ratings`
--
ALTER TABLE `ym_book_ratings`
  ADD CONSTRAINT `ym_book_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_book_ratings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_book_tag_rel`
--
ALTER TABLE `ym_book_tag_rel`
  ADD CONSTRAINT `ym_book_tag_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_book_tag_rel_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `ym_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_news`
--
ALTER TABLE `ym_news`
  ADD CONSTRAINT `ym_news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_news_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_news_categories`
--
ALTER TABLE `ym_news_categories`
  ADD CONSTRAINT `ym_news_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_news_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_news_tag_rel`
--
ALTER TABLE `ym_news_tag_rel`
  ADD CONSTRAINT `ym_news_tag_rel_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `ym_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_news_tag_rel_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `ym_news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_pages`
--
ALTER TABLE `ym_pages`
  ADD CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_tickets`
--
ALTER TABLE `ym_tickets`
  ADD CONSTRAINT `ym_tickets_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `ym_ticket_departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_ticket_messages`
--
ALTER TABLE `ym_ticket_messages`
  ADD CONSTRAINT `ym_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ym_tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_users`
--
ALTER TABLE `ym_users`
  ADD CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_book_bookmark`
--
ALTER TABLE `ym_user_book_bookmark`
  ADD CONSTRAINT `ym_user_book_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ym_user_book_bookmark_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_details`
--
ALTER TABLE `ym_user_details`
  ADD CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_dev_id_requests`
--
ALTER TABLE `ym_user_dev_id_requests`
  ADD CONSTRAINT `ym_user_dev_id_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_notifications`
--
ALTER TABLE `ym_user_notifications`
  ADD CONSTRAINT `ym_user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_role_permissions`
--
ALTER TABLE `ym_user_role_permissions`
  ADD CONSTRAINT `ym_user_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_settlement`
--
ALTER TABLE `ym_user_settlement`
  ADD CONSTRAINT `ym_user_settlement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_transactions`
--
ALTER TABLE `ym_user_transactions`
  ADD CONSTRAINT `ym_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
