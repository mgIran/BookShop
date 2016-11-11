/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-11-11 12:57:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('1', 'rahbod', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('28', 'mrketabic', '$2a$12$y.e4VsL6rSQ9hiItn96GM..bYIFel/FToEX1tzO.7VuVuE4pEiDEu', 'k.rahebi@gmail.com', '2');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'Super Admin', 'superAdmin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'مدیریت', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('4', 'نویسنده', 'author');

-- ----------------------------
-- Table structure for ym_admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_role_permissions`;
CREATE TABLE `ym_admin_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_admin_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_admin_role_permissions
-- ----------------------------
INSERT INTO `ym_admin_role_permissions` VALUES ('141', '2', 'base', 'BookCategoriesController', 'create,update,admin,delete,upload,deleteUpload,uploadIcon,deleteUploadIcon');
INSERT INTO `ym_admin_role_permissions` VALUES ('142', '2', 'base', 'BookController', 'reportSales,reportIncome');
INSERT INTO `ym_admin_role_permissions` VALUES ('143', '2', 'base', 'TagsController', 'index,create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('144', '2', 'admins', 'AdminsDashboardController', 'index');
INSERT INTO `ym_admin_role_permissions` VALUES ('145', '2', 'admins', 'AdminsManageController', 'index,views,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('146', '2', 'admins', 'AdminsRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('147', '2', 'advertises', 'AdvertisesManageController', 'create,update,admin,delete,upload,deleteUpload');
INSERT INTO `ym_admin_role_permissions` VALUES ('148', '2', 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve');
INSERT INTO `ym_admin_role_permissions` VALUES ('149', '2', 'manageBooks', 'ManageBooksBaseManageController', 'index,view,create,update,admin,delete,upload,deleteUpload,uploadFile,deleteUploadFile,changeConfirm,changePackageStatus,deletePackage,savePackage,images,download,downloadPackage');
INSERT INTO `ym_admin_role_permissions` VALUES ('150', '2', 'manageBooks', 'ManageBooksImagesManageController', 'upload,deleteUploaded');
INSERT INTO `ym_admin_role_permissions` VALUES ('151', '2', 'news', 'NewsCategoriesManageController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('152', '2', 'news', 'NewsManageController', 'create,update,admin,delete,upload,deleteUpload,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('153', '2', 'pages', 'PageCategoriesManageController', 'index,view,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('154', '2', 'pages', 'PagesManageController', 'index,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('155', '2', 'publishers', 'PublishersPanelController', 'manageSettlement');
INSERT INTO `ym_admin_role_permissions` VALUES ('156', '2', 'setting', 'SettingManageController', 'changeSetting,social_links');
INSERT INTO `ym_admin_role_permissions` VALUES ('157', '2', 'tickets', 'TicketsDepartmentsController', 'admin,create,update,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('158', '2', 'tickets', 'TicketsManageController', 'delete,pendingTicket,openTicket,admin,index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_admin_role_permissions` VALUES ('159', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_admin_role_permissions` VALUES ('160', '2', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,confirmDevID,deleteDevID,confirmPublisher,refusePublisher');
INSERT INTO `ym_admin_role_permissions` VALUES ('161', '2', 'users', 'UsersRolesController', 'create,update,admin,delete');

-- ----------------------------
-- Table structure for ym_books
-- ----------------------------
DROP TABLE IF EXISTS `ym_books`;
CREATE TABLE `ym_books` (
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
  `seen` int(10) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`publisher_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `ym_books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_books
-- ----------------------------
INSERT INTO `ym_books` VALUES ('52', 'دختر شینا', 'JNSLy1477560156.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', '120', '', 'فارسی', 'enable', null, '54', null, '45', 'accepted', '1478818629', '2', '1', '0');
INSERT INTO `ym_books` VALUES ('53', 'فتح خون', 'gvXUa1477582174.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', '150', '', 'فارسی', 'enable', null, '52', 'واحه', null, 'accepted', '1477687320', '5', '1', '0');
INSERT INTO `ym_books` VALUES ('54', 'دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل', 'wD8Oc1477588685.jpg', '<p>دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل</p>\r\n', '150', '', 'فارسی', 'enable', null, '54', 'گلوری', null, 'accepted', '1477687323', '6', '5', '0');

-- ----------------------------
-- Table structure for ym_book_advertises
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_advertises`;
CREATE TABLE `ym_book_advertises` (
  `book_id` int(10) unsigned NOT NULL COMMENT 'برنامه',
  `cover` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'تصویر کاور',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT 'وضعیت',
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  CONSTRAINT `ym_book_advertises_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_advertises
-- ----------------------------
INSERT INTO `ym_book_advertises` VALUES ('53', 'KUOsW1477596138.jpg', '1', '1477596158');

-- ----------------------------
-- Table structure for ym_book_buys
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_buys`;
CREATE TABLE `ym_book_buys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_book_buys_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_buys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_buys
-- ----------------------------
INSERT INTO `ym_book_buys` VALUES ('9', '54', '43', '1478350663');
INSERT INTO `ym_book_buys` VALUES ('10', '54', '45', '1478352463');
INSERT INTO `ym_book_buys` VALUES ('11', '54', '57', '1478352870');
INSERT INTO `ym_book_buys` VALUES ('13', '53', '45', '1478676772');
INSERT INTO `ym_book_buys` VALUES ('14', '52', '45', '1478676805');

-- ----------------------------
-- Table structure for ym_book_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_categories`;
CREATE TABLE `ym_book_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `icon_color` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE,
  CONSTRAINT `ym_book_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_book_categories
-- ----------------------------
INSERT INTO `ym_book_categories` VALUES ('52', 'پزشکی', null, null, 'OexZc1477466535.jpg', 'c2gA51477466537.svg', '#accf3d');
INSERT INTO `ym_book_categories` VALUES ('53', 'مهندسی', null, null, 'wMjo41477466558.jpg', 'Kd4hS1477466560.svg', '#2e9fc7');
INSERT INTO `ym_book_categories` VALUES ('54', 'حسابداری', null, null, 'c2gA51477466621.jpg', 'aUw011477477874.svg', '#e96e44');
INSERT INTO `ym_book_categories` VALUES ('55', 'کشاورزی', null, null, 'DAeop1477466811.jpg', 'Uy1Uw1477466814.svg', '#fbb11a');

-- ----------------------------
-- Table structure for ym_book_discounts
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_discounts`;
CREATE TABLE `ym_book_discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `start_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان',
  `percent` int(3) unsigned DEFAULT NULL COMMENT 'درصد',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `ym_book_discounts_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_discounts
-- ----------------------------
INSERT INTO `ym_book_discounts` VALUES ('1', '52', '1477670471', '1479679471', '10');

-- ----------------------------
-- Table structure for ym_book_images
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_images`;
CREATE TABLE `ym_book_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_images_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_images
-- ----------------------------
INSERT INTO `ym_book_images` VALUES ('13', '52', 'bGccf1477566838.jpg');

-- ----------------------------
-- Table structure for ym_book_packages
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_packages`;
CREATE TABLE `ym_book_packages` (
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
  `sale_printed` tinyint(1) DEFAULT NULL COMMENT 'فروش نسخه چاپی',
  `printed_price` decimal(10,0) unsigned DEFAULT NULL,
  `print_year` varchar(8) DEFAULT NULL COMMENT 'سال چاپ',
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_packages_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_packages
-- ----------------------------
INSERT INTO `ym_book_packages` VALUES ('46', '52', '1', 'تیراژ اول', '978-3-16-148410-0', 'GJLsY1478819947.pdf', '1477566615', '1478822126', 'accepted', '', 'old_book', '10000', '1', '150000', '1394');
INSERT INTO `ym_book_packages` VALUES ('47', '53', '3', 'فتح خون جلد اول', '978-3-16-148410-0', 'ig6Xo1478814578.pdf', '1477582805', '1478817000', 'accepted', '', 'old_book', '1500', '1', '5000', '1370');
INSERT INTO `ym_book_packages` VALUES ('48', '54', '1', 'جلد اول', '978-3-16-148410-0', 'kpg841477592881.docx', '1477592909', '1477687323', 'accepted', '', 'new_book', '100', '1', '1220', '1370');
INSERT INTO `ym_book_packages` VALUES ('69', '53', '1', null, '978-3-16-148410-0', '5JAX91478815087.pdf', '1478811430', '1478816997', 'accepted', '', 'old_book', '10000', '1', '120000', '1395');

-- ----------------------------
-- Table structure for ym_book_persons
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_persons`;
CREATE TABLE `ym_book_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_family` varchar(100) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام',
  `alias` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام مستعار',
  `birthday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ تولد',
  `deathday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ وفات',
  `biography` text COLLATE utf8_persian_ci COMMENT 'شرح حال',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_persons
-- ----------------------------
INSERT INTO `ym_book_persons` VALUES ('1', 'یوسف مبشری', null, null, null, null);
INSERT INTO `ym_book_persons` VALUES ('2', 'جلال آل احمد', null, null, null, null);

-- ----------------------------
-- Table structure for ym_book_person_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_person_roles`;
CREATE TABLE `ym_book_person_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان نقش',
  `order` int(10) unsigned NOT NULL COMMENT 'الویت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_person_roles
-- ----------------------------
INSERT INTO `ym_book_person_roles` VALUES ('1', 'نویسنده', '1');
INSERT INTO `ym_book_person_roles` VALUES ('2', 'مترجم', '2');

-- ----------------------------
-- Table structure for ym_book_person_role_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_person_role_rel`;
CREATE TABLE `ym_book_person_role_rel` (
  `book_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`person_id`,`role_id`),
  KEY `person_id` (`person_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_book_person_role_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_person_role_rel_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ym_book_persons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_person_role_rel_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `ym_book_person_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_person_role_rel
-- ----------------------------
INSERT INTO `ym_book_person_role_rel` VALUES ('52', '1', '1');
INSERT INTO `ym_book_person_role_rel` VALUES ('54', '1', '1');
INSERT INTO `ym_book_person_role_rel` VALUES ('54', '1', '2');
INSERT INTO `ym_book_person_role_rel` VALUES ('53', '2', '1');
INSERT INTO `ym_book_person_role_rel` VALUES ('54', '2', '1');

-- ----------------------------
-- Table structure for ym_book_ratings
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_ratings`;
CREATE TABLE `ym_book_ratings` (
  `user_id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  `rate` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`book_id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_ratings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_ratings
-- ----------------------------
INSERT INTO `ym_book_ratings` VALUES ('45', '52', '4');
INSERT INTO `ym_book_ratings` VALUES ('46', '53', '5');

-- ----------------------------
-- Table structure for ym_book_tag_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_tag_rel`;
CREATE TABLE `ym_book_tag_rel` (
  `book_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `for_seo` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`book_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `ym_book_tag_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_tag_rel_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `ym_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_tag_rel
-- ----------------------------
INSERT INTO `ym_book_tag_rel` VALUES ('54', '643', '0');
INSERT INTO `ym_book_tag_rel` VALUES ('54', '644', '1');

-- ----------------------------
-- Table structure for ym_comments
-- ----------------------------
DROP TABLE IF EXISTS `ym_comments`;
CREATE TABLE `ym_comments` (
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('Books', '52', '98', null, '45', 'Admin', null, 'asd', '1475916072', '1478356023', '1');
INSERT INTO `ym_comments` VALUES ('Books', '53', '99', null, '46', 'Admin', null, 'عالی', '1478204412', '1478352930', '1');
INSERT INTO `ym_comments` VALUES ('Books', '58', '100', null, '47', null, null, 'بسیار عالی', '1478385179', null, '0');

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '163');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457704');
INSERT INTO `ym_counter_save` VALUES ('max_count', '10');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1478334600');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '1');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1478854853');

-- ----------------------------
-- Table structure for ym_news
-- ----------------------------
DROP TABLE IF EXISTS `ym_news`;
CREATE TABLE `ym_news` (
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
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_news_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_news
-- ----------------------------
INSERT INTO `ym_news` VALUES ('15', 'هوای تهران آلوده است', 'تست', '<p>تست</p>\n', 'A65Fw1478356304.jpg', '0', '1478356317', '1478356317', 'publish', '4', null);

-- ----------------------------
-- Table structure for ym_news_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_news_categories`;
CREATE TABLE `ym_news_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `parent_id` int(10) unsigned DEFAULT NULL COMMENT 'والد',
  `path` varchar(255) DEFAULT NULL COMMENT 'مسیر',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `ym_news_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_news_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_news_categories
-- ----------------------------
INSERT INTO `ym_news_categories` VALUES ('4', 'عمومی', null, null);

-- ----------------------------
-- Table structure for ym_news_tag_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_news_tag_rel`;
CREATE TABLE `ym_news_tag_rel` (
  `tag_id` int(10) unsigned NOT NULL,
  `news_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`news_id`),
  KEY `news_id` (`news_id`),
  CONSTRAINT `ym_news_tag_rel_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `ym_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_news_tag_rel_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `ym_news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_news_tag_rel
-- ----------------------------
INSERT INTO `ym_news_tag_rel` VALUES ('642', '15');

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'درباره ما - بخش فوتر', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('3', 'درباره ما - بخش نمایش کتاب', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('6', 'راهنما', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد ناشران', 'متن قرارداد', '1');
INSERT INTO `ym_pages` VALUES ('8', 'تماس با ما', 'متن تماس با ما', '1');
INSERT INTO `ym_pages` VALUES ('9', 'ناشران', 'متن ناشران', '1');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');

-- ----------------------------
-- Table structure for ym_rows_homepage
-- ----------------------------
DROP TABLE IF EXISTS `ym_rows_homepage`;
CREATE TABLE `ym_rows_homepage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `const_query` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `query` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `order` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_rows_homepage
-- ----------------------------
INSERT INTO `ym_rows_homepage` VALUES ('2', 'پیشنهاد ما', '1', '0', 'suggested', '1');
INSERT INTO `ym_rows_homepage` VALUES ('3', 'پرفروش ترین ها', '1', '1', 'buy', '2');
INSERT INTO `ym_rows_homepage` VALUES ('4', 'تازه ترین کتاب ها', '1', '1', 'latest', '3');
INSERT INTO `ym_rows_homepage` VALUES ('5', 'پربازدیدترین ها', '1', '1', 'popular', '4');

-- ----------------------------
-- Table structure for ym_row_book_rel
-- ----------------------------
DROP TABLE IF EXISTS `ym_row_book_rel`;
CREATE TABLE `ym_row_book_rel` (
  `row_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`row_id`,`book_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `ym_row_book_rel_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_row_book_rel_ibfk_1` FOREIGN KEY (`row_id`) REFERENCES `ym_rows_homepage` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_row_book_rel
-- ----------------------------
INSERT INTO `ym_row_book_rel` VALUES ('2', '52', '3');
INSERT INTO `ym_row_book_rel` VALUES ('2', '53', '2');
INSERT INTO `ym_row_book_rel` VALUES ('2', '54', '1');
INSERT INTO `ym_row_book_rel` VALUES ('3', '52', '5');
INSERT INTO `ym_row_book_rel` VALUES ('3', '53', '6');
INSERT INTO `ym_row_book_rel` VALUES ('3', '54', '4');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'مرجع خرید و فروش کتاب آنلاین');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'کتابیک');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', '');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', '');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\",\"30000\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '1000');
INSERT INTO `ym_site_setting` VALUES ('7', 'tax', 'میزان مالیات (درصد)', '9');
INSERT INTO `ym_site_setting` VALUES ('8', 'commission', 'حق کمیسیون (درصد)', '15');
INSERT INTO `ym_site_setting` VALUES ('9', 'social_links', 'شبکه های اجتماعی', '{\"facebook\":\"http:\\/\\/facebook.com\",\"twitter\":\"http:\\/\\/twitter.com\"}');
INSERT INTO `ym_site_setting` VALUES ('10', 'android_app_url', 'آدرس دانلود نرم افزار اندروید سایت', 'http://');
INSERT INTO `ym_site_setting` VALUES ('11', 'windows_app_url', 'آدرس دانلود نرم افزار ویندوز سایت', 'http://');

-- ----------------------------
-- Table structure for ym_tags
-- ----------------------------
DROP TABLE IF EXISTS `ym_tags`;
CREATE TABLE `ym_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=645 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_tags
-- ----------------------------
INSERT INTO `ym_tags` VALUES ('637', 'گایت');
INSERT INTO `ym_tags` VALUES ('638', 'فیزی');
INSERT INTO `ym_tags` VALUES ('639', 'بسبب.س');
INSERT INTO `ym_tags` VALUES ('640', 'سقلرصق');
INSERT INTO `ym_tags` VALUES ('641', 'لرسربی');
INSERT INTO `ym_tags` VALUES ('642', '');
INSERT INTO `ym_tags` VALUES ('643', 'نمایشی');
INSERT INTO `ym_tags` VALUES ('644', 'سئو');

-- ----------------------------
-- Table structure for ym_tickets
-- ----------------------------
DROP TABLE IF EXISTS `ym_tickets`;
CREATE TABLE `ym_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه تیکت',
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` enum('waiting','pending','open','close') COLLATE utf8_persian_ci DEFAULT 'waiting' COMMENT 'وضعیت تیکت',
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `subject` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `department_id` int(10) unsigned DEFAULT NULL COMMENT 'بخش',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_tickets_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `ym_ticket_departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_tickets
-- ----------------------------
INSERT INTO `ym_tickets` VALUES ('2', '10000', '45', 'waiting', '1478384825', 'مشکل در آپلود فایل', '2');

-- ----------------------------
-- Table structure for ym_ticket_departments
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_departments`;
CREATE TABLE `ym_ticket_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_departments
-- ----------------------------
INSERT INTO `ym_ticket_departments` VALUES ('1', 'مدیریت');
INSERT INTO `ym_ticket_departments` VALUES ('2', 'بخش فنی');
INSERT INTO `ym_ticket_departments` VALUES ('3', 'بخش پرداخت ها');

-- ----------------------------
-- Table structure for ym_ticket_messages
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_messages`;
CREATE TABLE `ym_ticket_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL COMMENT 'تیکت',
  `sender` enum('admin','supporter','user') COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `text` text COLLATE utf8_persian_ci COMMENT 'متن',
  `attachment` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل ضمیمه',
  `visit` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`) USING BTREE,
  CONSTRAINT `ym_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ym_tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_messages
-- ----------------------------
INSERT INTO `ym_ticket_messages` VALUES ('2', '2', 'user', '1478384825', 'سلام', null, '1');
INSERT INTO `ym_ticket_messages` VALUES ('3', '2', 'admin', '1478420402', 'علیک', null, '1');

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  `auth_mode` varchar(50) NOT NULL DEFAULT 'site',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', '2', '1460634664', 'active', 'ec0bfa4e54eed8afb0d7fb0305d52759', '1', 'site');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'yusef.mobasheri@gmail.com', '2', '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', '1', 'site');
INSERT INTO `ym_users` VALUES ('46', 'k.rahebi@gmail.com', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'k.rahebi@gmail.com', '1', '1469083948', 'active', null, '0', 'site');
INSERT INTO `ym_users` VALUES ('51', '', '$2a$12$gvyjmX5ttqTkrzj5JBy7rukf.8NMati8EMybX8XZa1TnUDfRXUrre', 'yast6r@gmail.com', '1', '1478345220', 'pending', '018d909b5d2e14e87bad349e23705455', '0', 'site');
INSERT INTO `ym_users` VALUES ('56', '', '$2a$12$N0dHav/DVmD/s1e2xOrL4.gWEH7c6RHKnPiu7z6WKfghx9m7kLuzW', 'Dr.D347h@gmail.com', '1', '1478352314', 'pending', '276b1a99a7c347ea79daed09fd8e27de', '0', 'site');
INSERT INTO `ym_users` VALUES ('57', '', '$2a$12$qomUr6PNpq8bZYtfjxOzp.iIODRKDWrEOxxHbI4ynhkslrkT.enPa', 'ketabic.ir@gmail.com', '1', '1478352672', 'active', null, '0', 'google');
INSERT INTO `ym_users` VALUES ('58', '', '$2a$12$c04VvE0TP/2i47zMcxfgXuBqV0nNznTsEb1ZXAcY7cOSTrDImiNym', 'yast6r@yahoo.com', '1', '1478364134', 'pending', '27809b661848b43d3737f9e62c517bb2', '0', 'site');
INSERT INTO `ym_users` VALUES ('59', '', '$2a$12$n8jCCVKNv4A56EQXsZ19oe8B5k.jiXHcMGkvckQod1Ez.bLapr1YK', 'soltan.e.eshgh2008@gmail.com', '1', '1478383869', 'active', null, '0', 'google');

-- ----------------------------
-- Table structure for ym_user_book_bookmark
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_book_bookmark`;
CREATE TABLE `ym_user_book_bookmark` (
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`user_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_user_book_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_book_bookmark_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_book_bookmark
-- ----------------------------
INSERT INTO `ym_user_book_bookmark` VALUES ('43', '52');
INSERT INTO `ym_user_book_bookmark` VALUES ('43', '53');
INSERT INTO `ym_user_book_bookmark` VALUES ('46', '53');
INSERT INTO `ym_user_book_bookmark` VALUES ('46', '54');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
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
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '1460', 'Masoud', 'accepted', '1', '123456789123456789123456', 'Masoud', 'real', null, null, null, null, '3', null);
INSERT INTO `ym_user_details` VALUES ('45', 'یوسف مبشری', 'yusef', null, null, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '48500', 'Yusef', 'accepted', '1', '23423', null, 'real', null, null, null, null, '4', null);
INSERT INTO `ym_user_details` VALUES ('46', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('51', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('56', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('57', null, null, null, null, null, null, null, null, null, '3400', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('58', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('59', null, null, null, null, null, null, null, null, null, '0', null, 'pending', '0', null, null, 'real', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for ym_user_dev_id_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_dev_id_requests`;
CREATE TABLE `ym_user_dev_id_requests` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه درخواستی',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ym_user_dev_id_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_dev_id_requests
-- ----------------------------

-- ----------------------------
-- Table structure for ym_user_notifications
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_notifications`;
CREATE TABLE `ym_user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'متن پیام',
  `seen` tinyint(4) NOT NULL COMMENT 'مشاهده شده',
  `date` varchar(30) NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------
INSERT INTO `ym_user_notifications` VALUES ('2', '43', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('3', '43', 'شناسه شما توسط مدیر سیستم تایید شد.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('4', '43', 'برنامه  برنامه لیدکامب - لکنت کودکان تایید شده است.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('6', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464262310');
INSERT INTO `ym_user_notifications` VALUES ('7', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464262422');
INSERT INTO `ym_user_notifications` VALUES ('8', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464353232');
INSERT INTO `ym_user_notifications` VALUES ('9', '43', 'بسته asdfsdf توسط مدیر سیستم حذف شد.', '1', '1464358109');
INSERT INTO `ym_user_notifications` VALUES ('10', '43', 'بسته ir.tgbs.android.iranappasd توسط مدیر سیستم حذف شد.', '1', '1464358330');
INSERT INTO `ym_user_notifications` VALUES ('13', '43', 'بسته ir.tgbs.android.iranapp3 توسط مدیر سیستم رد شد.', '1', '1465459197');
INSERT INTO `ym_user_notifications` VALUES ('14', '43', 'بسته ir.tgbs.android.iranapp2 نیاز به تغییر دارد.', '1', '1465459228');
INSERT INTO `ym_user_notifications` VALUES ('15', null, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '0', '1467040015');
INSERT INTO `ym_user_notifications` VALUES ('16', '43', 'بسته ir.tgbs.android.iranapp123 توسط مدیر سیستم تایید شد.', '1', '1469083395');
INSERT INTO `ym_user_notifications` VALUES ('17', '43', 'برنامه تلگرام نیاز به تغییرات دارد.', '1', '1469083457');
INSERT INTO `ym_user_notifications` VALUES ('18', '45', 'بسته ir.tgbs.android.iranapp2 توسط مدیر سیستم تایید شد.', '1', '1470122805');
INSERT INTO `ym_user_notifications` VALUES ('19', '45', 'برنامه موبوگرام رد شده است.', '1', '1470123368');
INSERT INTO `ym_user_notifications` VALUES ('20', '45', 'برنامه موبوگرام نیاز به تغییرات دارد.', '1', '1470123486');
INSERT INTO `ym_user_notifications` VALUES ('21', '45', 'برنامه موبوگرام تایید شده است.', '1', '1470123513');
INSERT INTO `ym_user_notifications` VALUES ('22', '45', 'نوبت چاپ تیراژ اول نیاز به تغییر دارد.', '1', '1477567625');
INSERT INTO `ym_user_notifications` VALUES ('23', '45', 'کتاب دختر شینا نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش کتاب مراجعه فرمایید.', '1', '1477568006');
INSERT INTO `ym_user_notifications` VALUES ('24', '45', 'کتاب دختر شینا تایید شده است.', '1', '1477568018');
INSERT INTO `ym_user_notifications` VALUES ('25', null, 'نوبت چاپ فتح خون جلد اول توسط مدیر سیستم تایید شد.', '0', '1477584165');
INSERT INTO `ym_user_notifications` VALUES ('26', '45', 'کتاب دختر شینا تایید شده است.', '1', '1477685627');
INSERT INTO `ym_user_notifications` VALUES ('27', '45', 'کتاب دختر شینا تایید شده است.', '1', '1477685687');
INSERT INTO `ym_user_notifications` VALUES ('28', null, 'کتاب فتح خون تایید شده است.', '0', '1477685708');
INSERT INTO `ym_user_notifications` VALUES ('29', null, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', '0', '1477686990');
INSERT INTO `ym_user_notifications` VALUES ('30', '45', 'کتاب دختر شینا تایید شده است.', '1', '1477687246');
INSERT INTO `ym_user_notifications` VALUES ('31', '45', 'کتاب دختر شینا تایید شده است.', '1', '1477687277');
INSERT INTO `ym_user_notifications` VALUES ('32', null, 'کتاب فتح خون تایید شده است.', '0', '1477687321');
INSERT INTO `ym_user_notifications` VALUES ('33', null, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', '0', '1477687323');
INSERT INTO `ym_user_notifications` VALUES ('34', '45', 'کتاب دختر شینا تایید شده است.', '1', '1478355968');
INSERT INTO `ym_user_notifications` VALUES ('35', null, 'نوبت چاپ  توسط مدیر سیستم تایید شد.', '0', '1478816997');
INSERT INTO `ym_user_notifications` VALUES ('36', null, 'نوبت چاپ فتح خون جلد اول توسط مدیر سیستم تایید شد.', '0', '1478817000');
INSERT INTO `ym_user_notifications` VALUES ('37', '45', 'کتاب دختر شینا تایید شده است.', '1', '1478818629');
INSERT INTO `ym_user_notifications` VALUES ('38', '45', 'نوبت چاپ تیراژ اول توسط مدیر سیستم تایید شد.', '1', '1478822126');

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
INSERT INTO `ym_user_roles` VALUES ('2', 'ناشر', 'publisher');

-- ----------------------------
-- Table structure for ym_user_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_role_permissions`;
CREATE TABLE `ym_user_role_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT 'نقش',
  `module_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ماژول',
  `controller_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کنترلر',
  `actions` text CHARACTER SET utf8 COMMENT 'اکشن ها',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_user_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_role_permissions
-- ----------------------------
INSERT INTO `ym_user_role_permissions` VALUES ('52', '1', 'base', 'BookController', 'buy,bookmark,rate');
INSERT INTO `ym_user_role_permissions` VALUES ('53', '1', 'publishers', 'PublishersPanelController', 'uploadNationalCardImage,uploadRegistrationCertificateImage,signup');
INSERT INTO `ym_user_role_permissions` VALUES ('54', '1', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('55', '1', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('56', '1', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('57', '1', 'users', 'UsersCreditController', 'buy,bill,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('58', '1', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,changePassword,bookmarked,downloaded,transactions,library');
INSERT INTO `ym_user_role_permissions` VALUES ('81', '2', 'base', 'BookController', 'buy,bookmark,rate');
INSERT INTO `ym_user_role_permissions` VALUES ('82', '2', 'base', 'BookPersonsController', 'list');
INSERT INTO `ym_user_role_permissions` VALUES ('83', '2', 'base', 'TagsController', 'list');
INSERT INTO `ym_user_role_permissions` VALUES ('84', '2', 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve');
INSERT INTO `ym_user_role_permissions` VALUES ('85', '2', 'publishers', 'PublishersPanelController', 'uploadNationalCardImage,uploadRegistrationCertificateImage,account,index,discount,settlement,sales,documents');
INSERT INTO `ym_user_role_permissions` VALUES ('86', '2', 'publishers', 'PublishersBooksController', 'create,update,delete,uploadImage,deleteImage,upload,deleteUpload,uploadFile,deleteUploadFile,deleteFile,images,savePackage,updatePackage,deletePackage');
INSERT INTO `ym_user_role_permissions` VALUES ('87', '2', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('88', '2', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('89', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('90', '2', 'users', 'UsersCreditController', 'buy,bill,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('91', '2', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,changePassword,bookmarked,downloaded,transactions,library');

-- ----------------------------
-- Table structure for ym_user_settlement
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_settlement`;
CREATE TABLE `ym_user_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(15) DEFAULT NULL COMMENT 'مبلغ',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `iban` varchar(24) DEFAULT NULL COMMENT 'شماره شبا',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_settlement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_settlement
-- ----------------------------
INSERT INTO `ym_user_settlement` VALUES ('28', '43', '19000', '1462175546', '234242342');
INSERT INTO `ym_user_settlement` VALUES ('29', '45', '4949900', '1478354499', '23423');

-- ----------------------------
-- Table structure for ym_user_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_transactions`;
CREATE TABLE `ym_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(10) DEFAULT NULL COMMENT 'مقدار',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `status` enum('unpaid','paid') DEFAULT 'unpaid' COMMENT 'وضعیت',
  `token` varchar(50) DEFAULT NULL COMMENT 'کد رهگیری',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('1', '43', '5000', '1461646925', 'paid', 'j2343jk4h2k4h24h', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('4', '45', '100', '1470118630', 'unpaid', null, null);
INSERT INTO `ym_user_transactions` VALUES ('5', '46', '5000', '1478352890', 'unpaid', null, null);
INSERT INTO `ym_user_transactions` VALUES ('6', '43', '5000', '1478341454', 'unpaid', null, null);
INSERT INTO `ym_user_transactions` VALUES ('7', '57', '5000', '1478352780', 'paid', '44178512655', 'خرید اعتبار از طریق درگاه زرین پال');
