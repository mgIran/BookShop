/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-11-02 12:03:23
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('1', 'rahbod', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'gharagozlu.masoud@gmial.com', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_admin_role_permissions
-- ----------------------------
INSERT INTO `ym_admin_role_permissions` VALUES ('99', '2', 'base', 'BookCategoriesController', 'create,update,admin,delete,upload,deleteUpload,uploadIcon,deleteUploadIcon');
INSERT INTO `ym_admin_role_permissions` VALUES ('100', '2', 'base', 'BookController', 'reportSales,reportIncome');
INSERT INTO `ym_admin_role_permissions` VALUES ('101', '2', 'base', 'TagsController', 'index,create,update,admin,delete,list');
INSERT INTO `ym_admin_role_permissions` VALUES ('102', '2', 'admins', 'AdminsDashboardController', 'index');
INSERT INTO `ym_admin_role_permissions` VALUES ('103', '2', 'admins', 'AdminsManageController', 'index,views,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('104', '2', 'admins', 'AdminsRolesController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('105', '2', 'advertises', 'AdvertisesManageController', 'create,update,admin,delete,upload,deleteUpload');
INSERT INTO `ym_admin_role_permissions` VALUES ('106', '2', 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve');
INSERT INTO `ym_admin_role_permissions` VALUES ('107', '2', 'manageBooks', 'ManageBooksBaseManageController', 'index,view,create,update,admin,delete,upload,deleteUpload,uploadFile,deleteUploadFile,changeConfirm,changePackageStatus,deletePackage,savePackage,images,download,downloadPackage');
INSERT INTO `ym_admin_role_permissions` VALUES ('108', '2', 'manageBooks', 'ManageBooksImagesManageController', 'upload,deleteUploaded');
INSERT INTO `ym_admin_role_permissions` VALUES ('109', '2', 'news', 'NewsCategoriesManageController', 'create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('110', '2', 'news', 'NewsManageController', 'create,update,admin,delete,upload,deleteUpload,order');
INSERT INTO `ym_admin_role_permissions` VALUES ('111', '2', 'pages', 'PageCategoriesManageController', 'index,view,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('112', '2', 'pages', 'PagesManageController', 'index,create,update,admin,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('113', '2', 'publishers', 'PublishersPanelController', 'manageSettlement');
INSERT INTO `ym_admin_role_permissions` VALUES ('114', '2', 'setting', 'SettingManageController', 'changeSetting,social_links');
INSERT INTO `ym_admin_role_permissions` VALUES ('115', '2', 'tickets', 'TicketsDepartmentsController', 'admin,create,update,delete');
INSERT INTO `ym_admin_role_permissions` VALUES ('116', '2', 'tickets', 'TicketsManageController', 'delete,pendingTicket,openTicket,admin,index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_admin_role_permissions` VALUES ('117', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_admin_role_permissions` VALUES ('118', '2', 'users', 'UsersManageController', 'index,view,create,update,admin,delete,confirmDevID,deleteDevID,confirmPublisher,refusePublisher');
INSERT INTO `ym_admin_role_permissions` VALUES ('119', '2', 'users', 'UsersRolesController', 'create,update,admin,delete');

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
  `seen` tinyint(1) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`publisher_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `ym_books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_books
-- ----------------------------
INSERT INTO `ym_books` VALUES ('52', 'دختر شینا', 'JNSLy1477560156.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', '120', '', 'فارسی', 'enable', null, '52', null, '45', 'accepted', '1477687276', '255', '0', '0');
INSERT INTO `ym_books` VALUES ('53', 'فتح خون', 'gvXUa1477582174.jpg', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n\r\n<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', '150', '', 'فارسی', 'enable', null, '52', 'واحه', null, 'accepted', '1477687320', '97', '0', '0');
INSERT INTO `ym_books` VALUES ('54', 'دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل', 'wD8Oc1477588685.jpg', '<p>دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل</p>\r\n', '150', '', 'فارسی', 'enable', null, '52', 'گلوری', null, 'accepted', '1477687323', '37', '0', '0');
INSERT INTO `ym_books` VALUES ('55', 'تست', 'btT6c1477722786.jpg', '<p>لورم ایپسوم</p>\r\n', '1025', '', 'فارسی', 'enable', null, '55', 'انتشارات علوی', null, 'accepted', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('56', 'test', 'Xcdss1478068579.jpg', '<p>testttt</p>\r\n', '12', '', 'en', 'enable', null, '52', null, '43', 'pending', null, '0', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_buys
-- ----------------------------

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
  `sale_printed` tinyint(4) DEFAULT NULL COMMENT 'فروش نسخه چاپی',
  `printed_price` decimal(10,0) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_packages_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_packages
-- ----------------------------
INSERT INTO `ym_book_packages` VALUES ('46', '52', '1', 'تیراژ اول', '978-3-16-148410-0', 'AXfrV1477566608.docx', '1477566615', '1477687277', 'accepted', '', 'old_book', '10000', null, '150000');
INSERT INTO `ym_book_packages` VALUES ('47', '53', '1', 'فتح خون جلد اول', '978-3-16-148410-0', '2BRbY1477582248.docx', '1477582805', '1477687320', 'accepted', '', 'old_book', '1500', null, '5000');
INSERT INTO `ym_book_packages` VALUES ('48', '54', '1', 'جلد اول', '978-3-16-148410-0', 'kpg841477592881.docx', '1477592909', '1477687323', 'accepted', '', 'new_book', '100', null, '1220');

-- ----------------------------
-- Table structure for ym_book_persons
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_persons`;
CREATE TABLE `ym_book_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام',
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام خانوادگی',
  `alias` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام مستعار',
  `birthday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ تولد',
  `deathday` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ وفات',
  `biography` text COLLATE utf8_persian_ci COMMENT 'شرح حال',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_persons
-- ----------------------------
INSERT INTO `ym_book_persons` VALUES ('1', 'یوسف', 'مبشری', null, null, null, null);

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
  CONSTRAINT `ym_book_person_role_rel_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `ym_book_person_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_person_role_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_person_role_rel_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ym_book_persons` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_person_role_rel
-- ----------------------------
INSERT INTO `ym_book_person_role_rel` VALUES ('52', '1', '1');

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
INSERT INTO `ym_book_ratings` VALUES ('44', '52', '5');
INSERT INTO `ym_book_ratings` VALUES ('45', '52', '4');

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
  CONSTRAINT `ym_book_tag_rel_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `ym_tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_tag_rel_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_tag_rel
-- ----------------------------
INSERT INTO `ym_book_tag_rel` VALUES ('55', '628', '0');
INSERT INTO `ym_book_tag_rel` VALUES ('55', '629', '1');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '631', '0');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '632', '0');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '633', '0');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '634', '1');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '635', '1');
INSERT INTO `ym_book_tag_rel` VALUES ('56', '636', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('Books', '52', '98', null, '45', null, null, 'asd', '1475916072', null, '1');

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
INSERT INTO `ym_counter_save` VALUES ('counter', '140');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457695');
INSERT INTO `ym_counter_save` VALUES ('max_count', '5');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1457598600');
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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1478075584');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_news
-- ----------------------------
INSERT INTO `ym_news` VALUES ('14', 'من دریاچه ارومیه هستم', 'لورم ایپسوم', '<p>لورم ایپسوم</p>\r\n', '8skPt1477773185.jpg', '0', '1477772334', '1477772334', 'publish', '6', null);

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
INSERT INTO `ym_news_categories` VALUES ('5', 'کلاس های ارائه شده', null, null);
INSERT INTO `ym_news_categories` VALUES ('6', 'اخبار جدید در مورد امتحان تافل آی بی تی', null, null);
INSERT INTO `ym_news_categories` VALUES ('7', 'کارنامه  زبان آموزان', null, null);

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
INSERT INTO `ym_news_tag_rel` VALUES ('630', '14');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'درباره ما - بخش فوتر', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('3', 'درباره ما - بخش نمایش کتاب', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چـاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآن چـنان کـه لازم اسـت و بـرای شرایط فعلی تکنولوژی مورد نیاز و کاربـردهای متـنوع با هـدف بهـبود ابـزارهـای کاربردی می باشد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.', '1');
INSERT INTO `ym_pages` VALUES ('6', 'راهنما', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد ناشران', 'متن قرارداد', '1');
INSERT INTO `ym_pages` VALUES ('8', 'تماس با ما', 'متن تماس با ما', null);

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
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\"]');
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
) ENGINE=InnoDB AUTO_INCREMENT=637 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_tags
-- ----------------------------
INSERT INTO `ym_tags` VALUES ('628', 'نمایشی');
INSERT INTO `ym_tags` VALUES ('629', 'سئو');
INSERT INTO `ym_tags` VALUES ('630', 'خبر کامین');
INSERT INTO `ym_tags` VALUES ('631', 'a');
INSERT INTO `ym_tags` VALUES ('632', 'b');
INSERT INTO `ym_tags` VALUES ('633', 'c');
INSERT INTO `ym_tags` VALUES ('634', 'aa');
INSERT INTO `ym_tags` VALUES ('635', 'bb');
INSERT INTO `ym_tags` VALUES ('636', 'cc');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_tickets
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_messages
-- ----------------------------

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
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', '2', '1460634664', 'active', 'ec0bfa4e54eed8afb0d7fb0305d52759', '1');
INSERT INTO `ym_users` VALUES ('44', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'mr.m.gharagozlu@gmail.com', '2', '1460634664', 'deleted', 'ec0bfa4e54eed8afb0d7fb0305d52759', '0');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'yusef.mobasheri@gmail.com', '2', '1469083948', 'active', '72ca2204ef7d713a27204d6dfeb615a4', '1');

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
  CONSTRAINT `ym_user_book_bookmark_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_book_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_book_bookmark
-- ----------------------------
INSERT INTO `ym_user_book_bookmark` VALUES ('43', '52');
INSERT INTO `ym_user_book_bookmark` VALUES ('43', '53');

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
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '1760', 'Masoud', 'accepted', '1', '123456789123456789123456', 'Masoud', 'real', null, null, null, null, '0', null);
INSERT INTO `ym_user_details` VALUES ('44', 'مسعود قراگوزلو', null, '', null, null, null, '38888888', '3718958691', 'قم - همونجا', '2000', null, 'pending', '0', null, 'وای ام', 'legal', 'ceo', 'وب ایران', '134644535', 'OPxRK1466844466.jpg', '0', null);
INSERT INTO `ym_user_details` VALUES ('45', 'یوسف مبشری', 'yusef', null, null, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '4951000', 'Yusef', 'accepted', '1', '23423', null, 'real', null, null, null, null, '1', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

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
INSERT INTO `ym_user_notifications` VALUES ('23', '45', 'کتاب دختر شینا نیاز به تغییرات دارد. جهت مشاهده پیام کارشناسان به صفحه ویرایش کتاب مراجعه فرمایید.', '0', '1477568006');
INSERT INTO `ym_user_notifications` VALUES ('24', '45', 'کتاب دختر شینا تایید شده است.', '0', '1477568018');
INSERT INTO `ym_user_notifications` VALUES ('25', null, 'نوبت چاپ فتح خون جلد اول توسط مدیر سیستم تایید شد.', '0', '1477584165');
INSERT INTO `ym_user_notifications` VALUES ('26', '45', 'کتاب دختر شینا تایید شده است.', '0', '1477685627');
INSERT INTO `ym_user_notifications` VALUES ('27', '45', 'کتاب دختر شینا تایید شده است.', '0', '1477685687');
INSERT INTO `ym_user_notifications` VALUES ('28', null, 'کتاب فتح خون تایید شده است.', '0', '1477685708');
INSERT INTO `ym_user_notifications` VALUES ('29', null, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', '0', '1477686990');
INSERT INTO `ym_user_notifications` VALUES ('30', '45', 'کتاب دختر شینا تایید شده است.', '0', '1477687246');
INSERT INTO `ym_user_notifications` VALUES ('31', '45', 'کتاب دختر شینا تایید شده است.', '0', '1477687277');
INSERT INTO `ym_user_notifications` VALUES ('32', null, 'کتاب فتح خون تایید شده است.', '0', '1477687321');
INSERT INTO `ym_user_notifications` VALUES ('33', null, 'کتاب دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل تایید شده است.', '0', '1477687323');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_role_permissions
-- ----------------------------
INSERT INTO `ym_user_role_permissions` VALUES ('1', '2', 'base', 'BookController', 'buy,bookmark,rate');
INSERT INTO `ym_user_role_permissions` VALUES ('2', '2', 'comments', 'CommentsCommentController', 'admin,adminBooks,delete,approve');
INSERT INTO `ym_user_role_permissions` VALUES ('3', '2', 'publishers', 'PublishersBooksController', 'create,update,delete,uploadImage,deleteImage,upload,deleteUpload,uploadFile,deleteUploadFile,images,savePackage');
INSERT INTO `ym_user_role_permissions` VALUES ('4', '2', 'publishers', 'PublishersPanelController', 'uploadRegistrationCertificateImage,uploadNationalCardImage,account,index,discount,settlement,sales,documents');
INSERT INTO `ym_user_role_permissions` VALUES ('5', '2', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('6', '2', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('7', '2', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('8', '2', 'users', 'UsersCreditController', 'buy,bill,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('9', '2', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,bookmarked');
INSERT INTO `ym_user_role_permissions` VALUES ('10', '1', 'base', 'BookController', 'rate,bookmark,buy');
INSERT INTO `ym_user_role_permissions` VALUES ('11', '1', 'publishers', 'PublishersPanelController', 'signup,uploadNationalCardImage,uploadRegistrationCertificateImage');
INSERT INTO `ym_user_role_permissions` VALUES ('12', '1', 'tickets', 'TicketsDepartmentsController', 'create,update');
INSERT INTO `ym_user_role_permissions` VALUES ('13', '1', 'tickets', 'TicketsMessagesController', 'delete,create');
INSERT INTO `ym_user_role_permissions` VALUES ('14', '1', 'tickets', 'TicketsManageController', 'index,view,create,update,closeTicket,upload,deleteUploaded,send');
INSERT INTO `ym_user_role_permissions` VALUES ('15', '1', 'users', 'UsersCreditController', 'buy,bill,verify');
INSERT INTO `ym_user_role_permissions` VALUES ('16', '1', 'users', 'UsersPublicController', 'dashboard,logout,setting,notifications,bookmarked');

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_settlement
-- ----------------------------
INSERT INTO `ym_user_settlement` VALUES ('28', '43', '19000', '1462175546', '234242342');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('1', '43', '5000', '1461646925', 'paid', 'j2343jk4h2k4h24h', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('4', '45', '100', '1470118630', 'unpaid', null, null);
