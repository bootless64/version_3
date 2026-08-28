-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2026 at 05:03 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asa_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('national','international','local') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `authors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `price` bigint DEFAULT NULL COMMENT 'قیمت به تومان',
  `is_free` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'رایگان یا پولی',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `price_set_by` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `articles_user_id_foreign` (`user_id`),
  KEY `articles_price_set_by_foreign` (`price_set_by`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `type`, `title`, `keywords`, `description`, `authors`, `publication_year`, `content`, `image`, `user_id`, `file`, `abstract_file`, `status`, `price`, `is_free`, `admin_note`, `is_published`, `created_at`, `updated_at`, `deleted_at`, `price_set_by`) VALUES
(11, 'national', 'ارائه چارچوب ارزیابی امنیت سامانه‌های مبتنی بر بلاک‌چین', 'بلاک‌چین، امنیت سایبری، ارزیابی امنیت، قراردادهای هوشمند', 'در این مقاله، یک چارچوب جامع برای ارزیابی امنیت سامانه‌های مبتنی بر فناوری بلاک‌چین ارائه شده است. این چارچوب با رویکردی چندلایه، امنیت را در سه سطح پروتکل، قرارداد هوشمند و برنامه کاربردی مورد بررسی قرار می‌دهد. روش پیشنهادی شامل شناسایی آسیب‌پذیری‌های رایج، ارائه معیارهای ارزیابی کمی و کیفی، و تدوین راهکارهای بهبود امنیت می‌باشد. نتایج پیاده‌سازی بر روی چند بستر بلاک‌چینی نشان می‌دهد که چارچوب ارائه شده می‌تواند تا ۸۵ درصد از آسیب‌پذیری‌های شناخته شده را شناسایی نماید.', 'دکتر احمد رضایی، دکتر مریم کریمی، مهندس علی زاهدی', '1403', ' ', NULL, 1, 'articles/files/6a6c8e45c4919_2 (2).pdf', 'articles/abstracts/6a6c8e45c8170_abstract_2 (2).pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:00:05', '2026-07-31 12:00:05', NULL, NULL),
(12, 'international', 'A Novel Approach for Intrusion Detection Using Deep Learning', 'Intrusion Detection, Deep Learning, Cybersecurity, Neural Networks', 'This paper presents a novel approach for intrusion detection in network systems using deep learning techniques. The proposed method utilizes a hybrid model combining Convolutional Neural Networks (CNN) and Long Short-Term Memory (LSTM) networks to effectively detect both known and unknown attack patterns. The model was trained and tested on the NSL-KDD and CIC-IDS2017', 'Dr. Ahmad Rezaei, Dr. Maryam Karimi, Prof. John Smith', '2024', ' ', NULL, 1, 'articles/files/6a6c8e9e1e3e6_1.pdf', 'articles/abstracts/6a6c8e9e1f806_abstract_1.pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:01:34', '2026-07-31 12:01:34', NULL, NULL),
(13, 'national', 'بررسی آسیب‌پذیری‌های امنیتی در اینترنت اشیا و راهکارهای مقابله', 'اینترنت اشیا، امنیت، آسیب‌پذیری، راهکارهای دفاعی', 'در این پژوهش، آسیب‌پذیری‌های امنیتی موجود در دستگاه‌های اینترنت اشیا (IoT) مورد بررسی و تحلیل قرار گرفته است. با توجه به رشد روزافزون کاربردهای IoT در صنایع مختلف و افزایش تهدیدات سایبری، شناسایی و رفع این آسیب‌پذیری‌ها از اهمیت بالایی برخوردار است. در این مقاله، طبقه‌بندی جامعی از آسیب‌پذیری‌های امنیتی در سه لایه سخت‌افزار، نرم‌افزار و شبکه ارائه شده و برای هر دسته، راهکارهای عملیاتی مقابله پیشنهاد گردیده است', 'دکتر سعید محمدی، مهندس محمدرضا کریمی، دکتر الهام صادقی', '1402', ' ', NULL, 1, 'articles/files/6a6c8ed57f148_2 (2).pdf', 'articles/abstracts/6a6c8ed57ff7d_abstract_2 (2).pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:02:29', '2026-07-31 12:02:29', NULL, NULL),
(14, 'international', 'Blockchain-Based Secure Data Sharing in Healthcare Systems', 'Blockchain, Healthcare, Data Sharing, Security, Privacy', 'This research proposes a secure framework for sharing medical data in healthcare systems using blockchain technology. The framework addresses critical challenges including data privacy, patient consent management, and secure interoperability between different healthcare providers. The proposed solution utilizes smart contracts to enforce access control policies and ensures data integrity through cryptographic techniques.', 'Dr. Fatemeh Hosseini, Dr. Reza Noori, Prof. David Wilson', '2023', ' ', NULL, 1, 'articles/files/6a6c8efb4f40a_1.pdf', 'articles/abstracts/6a6c8efb506d1_abstract_1.pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:03:07', '2026-07-31 12:03:07', NULL, NULL),
(15, 'national', 'طراحی و پیاده‌سازی الگوریتم رمزنگاری سبک برای کاربردهای اینترنت اشیا', 'رمزنگاری سبک، اینترنت اشیا، امنیت، الگوریتم، کارایی', 'در این مقاله، یک الگوریتم رمزنگاری سبک با مصرف انرژی پایین برای استفاده در دستگاه‌های اینترنت اشیا با منابع محدود طراحی و پیاده‌سازی شده است. الگوریتم پیشنهادی با بهینه‌سازی عملیات رمزنگاری و کاهش تعداد دورهای رمزگذاری، ضمن حفظ سطح امنیت قابل قبول، عملکردی سریع‌تر و مصرف انرژی کمتری نسبت به الگوریتم‌های موجود ارائه می‌دهد. آزمایش‌ها بر روی پلتفرم‌های سخت‌افزاری مختلف نشان می‌دهد که الگوریتم پیشنهادی حداقل ۳۰ درصد مصرف انرژی کمتری نسبت به روش‌های رایج دارد.', 'مهندس علی زاهدی، دکتر احمد رضایی، مهندس مریم کریمی', '1404', ' ', NULL, 1, 'articles/files/6a6c8f35c255f_2 (2).pdf', 'articles/abstracts/6a6c8f35c2e58_abstract_2 (2).pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:04:05', '2026-07-31 12:04:05', NULL, NULL),
(16, 'international', '123123', '123123', '123123', '123123', '2023', ' ', NULL, 1, 'articles/files/6a6c903dd1481_1.pdf', 'articles/abstracts/6a6c903dd30cd_abstract_1.pdf', 'approved', NULL, 1, NULL, 1, '2026-07-31 12:08:29', '2026-07-31 12:08:48', '2026-07-31 12:08:48', NULL),
(17, 'national', '123123', NULL, NULL, '12312313 — استاد راهنما: 123', '1403', ' ', NULL, 1, 'articles/files/6a8892f1275ef_6a8892e4b74f6_1.pdf', 'articles/abstracts/6a8892f128909_abstract_6a8892e4bbc95_abstract_1.pdf', 'approved', NULL, 1, NULL, 1, '2026-08-21 18:03:29', '2026-08-21 18:03:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_proposals`
--

DROP TABLE IF EXISTS `article_proposals`;
CREATE TABLE IF NOT EXISTS `article_proposals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `submission_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `research_field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `title_explanation` text COLLATE utf8mb4_unicode_ci,
  `similar_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `similar_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `similar_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `similar_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('national','international') COLLATE utf8mb4_unicode_ci NOT NULL,
  `thesis_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defense_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_proposals_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_proposals`
--

INSERT INTO `article_proposals` (`id`, `user_id`, `submission_type`, `title`, `authors`, `student_name`, `supervisor`, `research_field`, `keywords`, `description`, `title_explanation`, `similar_status`, `similar_year`, `similar_place`, `similar_link`, `type`, `thesis_type`, `publication_year`, `defense_year`, `file`, `abstract_file`, `status`, `admin_note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'article', '123123', '123123', NULL, NULL, NULL, '123', '1233123123', NULL, NULL, NULL, NULL, NULL, 'national', NULL, '1385', NULL, 'proposals/files/6a5bd160ae81e_all.pdf', 'proposals/abstracts/6a5bd160b2e19_abstract_all.pdf', 'pending', NULL, '2026-07-18 19:17:52', '2026-07-18 19:20:57', '2026-07-18 19:20:57'),
(2, 7, 'article', '123123', '21312312', NULL, NULL, NULL, '123123123', '123123123', NULL, NULL, NULL, NULL, NULL, 'national', NULL, '1385', NULL, 'proposals/files/6a5bd39861735_1.pdf', 'proposals/abstracts/6a5bd3986338c_abstract_700.pdf', 'pending', NULL, '2026-07-18 19:27:20', '2026-07-18 19:31:04', '2026-07-18 19:31:04'),
(3, 7, 'article', '123123', '21312312', NULL, NULL, NULL, '123123123', '123123', NULL, NULL, NULL, NULL, NULL, 'national', NULL, '1385', NULL, 'proposals/files/6a5bd48fda090_1.pdf', 'proposals/abstracts/6a5bd48fdbd3d_abstract_2 (2).pdf', 'rejected', 'hbafsbjhfadah', '2026-07-18 19:31:27', '2026-07-18 19:41:18', '2026-07-18 19:41:18'),
(4, 1, 'article', '1234567890', 'ghghghghghgh', NULL, NULL, NULL, NULL, '24334243', NULL, NULL, NULL, NULL, NULL, 'national', NULL, '1403', NULL, 'proposals/files/6a6c56066e9b1_2 (2).pdf', 'proposals/abstracts/6a6c5606e78c4_abstract_1.pdf', 'rejected', '12', '2026-07-31 08:00:06', '2026-07-31 08:49:16', '2026-07-31 08:49:16'),
(5, 1, 'thesis', '1233', '123123', '123123', '123123', '123123', '123,123,123,12312,3123,1231,2312,3', NULL, NULL, NULL, NULL, NULL, NULL, 'national', 'thesis', '1400', '1400', 'proposals/thesis/files/6a6c6120c0090_1.pdf', 'proposals/thesis/abstracts/6a6c6120c43f2_abstract_2 (2).pdf', 'rejected', '12', '2026-07-31 08:47:28', '2026-07-31 08:49:25', '2026-07-31 08:49:25'),
(6, 1, 'proposal_article', '123123', 'مدیر سایت', NULL, NULL, NULL, '123123', NULL, '123123', 'not_exists', NULL, NULL, NULL, 'national', NULL, '', NULL, NULL, NULL, 'rejected', '12', '2026-07-31 08:47:43', '2026-07-31 08:49:23', '2026-07-31 08:49:23'),
(7, 1, 'proposal_thesis', '213123', 'مدیر سایت', NULL, NULL, NULL, 'Intrusion Detection, Deep Learning, Cybersecurity, Neural Networks', NULL, '123123', 'exists', '1233', '213', 'http://127.0.0.1:8000/submit-proposal', 'national', 'thesis', '', NULL, NULL, NULL, 'rejected', '12', '2026-07-31 08:48:17', '2026-07-31 08:49:19', '2026-07-31 08:49:19'),
(8, 1, 'thesis', '123123', '12312313', '12312313', '123', '123123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'national', 'dissertation', '1403', '1403', 'proposals/thesis/files/6a8892e4b74f6_1.pdf', 'proposals/thesis/abstracts/6a8892e4bbc95_abstract_1.pdf', 'approved', NULL, '2026-08-21 18:03:16', '2026-08-21 18:03:55', '2026-08-21 18:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `article_topic`
--

DROP TABLE IF EXISTS `article_topic`;
CREATE TABLE IF NOT EXISTS `article_topic` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `topic_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_topic_article_id_foreign` (`article_id`),
  KEY `article_topic_topic_id_foreign` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_requests`
--

DROP TABLE IF EXISTS `assessment_requests`;
CREATE TABLE IF NOT EXISTS `assessment_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `security_assessment` tinyint(1) NOT NULL,
  `quality_assessment` tinyint(1) NOT NULL,
  `person_type` enum('natural_person','legal_person') COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_economic_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_landline_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_mobile_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_manager_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_manager_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_manager_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_manager_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` enum('local','non_local') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_brand_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `software_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_server` tinyint(1) NOT NULL,
  `mobile_application` tinyint(1) NOT NULL,
  `desktop_application` tinyint(1) NOT NULL,
  `web_application` tinyint(1) NOT NULL,
  `product_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assessment_requests_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_requests`
--

INSERT INTO `assessment_requests` (`id`, `user_id`, `security_assessment`, `quality_assessment`, `person_type`, `applicant_name`, `applicant_national_id`, `applicant_economic_code`, `applicant_landline_phone`, `applicant_mobile_phone`, `applicant_email`, `applicant_fax`, `manager_name`, `manager_national_id`, `manager_phone`, `manager_email`, `technical_manager_name`, `technical_manager_national_id`, `technical_manager_phone`, `technical_manager_email`, `product_type`, `product_name`, `product_brand_name`, `software_version`, `client_server`, `mobile_application`, `desktop_application`, `web_application`, `product_description`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 0, 'legal_person', 'مرکز پژوهشی امنیت سایبری شرق', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 'وبسایت مرکز پژوهشی امنیت سایبری شرق', NULL, '1.0.0', 1, 0, 0, 1, 'وبسایت مرکز پژوهشی آسا شرق با فریم‌ورک لاراول (ورژن 9) توسعه داده شده است.', '1_2025_09_02_174432.zip', '2025-09-02 13:14:32', '2025-09-02 13:14:32', NULL),
(6, 50, 1, 1, 'natural_person', 'علی زاهدی', '5552225', '555222558', '233325225', '091555555555', 'abb@abn.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'local', 'hhd', 'sse', '2.52', 1, 1, 1, 1, NULL, '50_2025_09_27_230521.rar', '2025-09-27 19:35:21', '2025-09-27 19:35:21', NULL),
(7, 54, 1, 0, 'legal_person', 'یگانه شکیب', '0770271855', NULL, NULL, '09303490856', 'shakibyeganeh@gmail.com', NULL, 'اقای سالخورده', NULL, '09151135801', NULL, 'عرفان حیدریان', NULL, '09153266958', NULL, 'local', 'سایت مرکز آسا شرق', NULL, '1', 0, 0, 0, 1, 'سایت مرتبط با مرکز آسا شرق', '54_2025_10_04_214321.zip', '2025-10-04 18:13:21', '2025-10-04 18:13:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_request_checklists`
--

DROP TABLE IF EXISTS `assessment_request_checklists`;
CREATE TABLE IF NOT EXISTS `assessment_request_checklists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `assessment_request_id` bigint UNSIGNED NOT NULL,
  `qa_product_catalog` tinyint(1) DEFAULT NULL,
  `qa_user_manual` tinyint(1) DEFAULT NULL,
  `qa_basic_procedures_description` tinyint(1) DEFAULT NULL,
  `qa_product_security_requirements` tinyint(1) DEFAULT NULL,
  `qa_product_release_version` tinyint(1) DEFAULT NULL,
  `qa_product_architecture` tinyint(1) DEFAULT NULL,
  `qa_database_documentation` tinyint(1) DEFAULT NULL,
  `qa_non_functional_requirements` tinyint(1) DEFAULT NULL,
  `qa_system_diagrams` tinyint(1) DEFAULT NULL,
  `qa_questionnaire` tinyint(1) DEFAULT NULL,
  `qa_manufacturer_info` tinyint(1) DEFAULT NULL,
  `qa_maintenance_manual` tinyint(1) DEFAULT NULL,
  `qa_communication_protocols` tinyint(1) DEFAULT NULL,
  `qa_programming_environment` tinyint(1) DEFAULT NULL,
  `sa_product_catalog` tinyint(1) DEFAULT NULL,
  `sa_user_manual` tinyint(1) DEFAULT NULL,
  `sa_product_identity` tinyint(1) DEFAULT NULL,
  `sa_product_security_requirements` tinyint(1) DEFAULT NULL,
  `sa_analysis_design_doc` tinyint(1) DEFAULT NULL,
  `sa_product_architecture` tinyint(1) DEFAULT NULL,
  `sa_security_target_doc` tinyint(1) DEFAULT NULL,
  `sa_product_release_version` tinyint(1) DEFAULT NULL,
  `sa_agd` tinyint(1) DEFAULT NULL,
  `sa_alc` tinyint(1) DEFAULT NULL,
  `sa_adv` tinyint(1) DEFAULT NULL,
  `sa_crypto_capability_declaration` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assessment_request_checklists_assessment_request_id_foreign` (`assessment_request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_request_checklists`
--

INSERT INTO `assessment_request_checklists` (`id`, `assessment_request_id`, `qa_product_catalog`, `qa_user_manual`, `qa_basic_procedures_description`, `qa_product_security_requirements`, `qa_product_release_version`, `qa_product_architecture`, `qa_database_documentation`, `qa_non_functional_requirements`, `qa_system_diagrams`, `qa_questionnaire`, `qa_manufacturer_info`, `qa_maintenance_manual`, `qa_communication_protocols`, `qa_programming_environment`, `sa_product_catalog`, `sa_user_manual`, `sa_product_identity`, `sa_product_security_requirements`, `sa_analysis_design_doc`, `sa_product_architecture`, `sa_security_target_doc`, `sa_product_release_version`, `sa_agd`, `sa_alc`, `sa_adv`, `sa_crypto_capability_declaration`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, '2025-09-08 07:23:18', '2025-09-08 07:23:18', NULL),
(9, 6, 0, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2025-09-27 19:35:49', '2025-09-27 19:35:49', NULL),
(10, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, '2025-10-04 18:15:23', '2025-10-04 18:15:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banned_ips`
--

DROP TABLE IF EXISTS `banned_ips`;
CREATE TABLE IF NOT EXISTS `banned_ips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `banned_by` (`banned_by`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------


--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_user_id_foreign` (`user_id`)
) ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `slider_images`, `user_id`, `status`, `is_archived`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'برگزاری مسابقه امنیت سایبری - فتح پرچم در دانشگاه سجاد', '<p style=\"text-align: justify; \">                    مسابقه فتح پرچم در روز پنجشنبه مورخ ۲۱ فروردین ۱۴۰۴ در محل دانشگاه سجاد با حمایت مرکز مدیریت راهبردی افتای خراسان رضوی و شرکت خدمات علمی صنعتی خراسان برگزار گردید.&nbsp;<span style=\"color: rgb(33, 37, 41); background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">اهداف اولیه این مسابقه، آشنایی دانشجویان رشته کامپیوتر با مباحث مختلف امنیت سایبری و استعدادیابی در این حوزه می‌باشد.&nbsp;</span><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">این مسابقه از ساعت ۷:۳۰ لغایت ۱۴ ادامه داشته نتایج به شرح زیر اعلام می‌گردد:</span></p><table class=\"table table-bordered\"><tbody><tr><td style=\"text-align: center; \"><b>رتبه</b></td><td style=\"text-align: center;\"><b>نام دانشگاه</b></td><td style=\"text-align: center; \"><b>اسم تیم</b></td><td style=\"text-align: center; \"><b>نام اعضای تیم</b></td></tr><tr><td style=\"text-align: center;\">1</td><td style=\"text-align: center; \">شهید منتظری</td><td style=\"text-align: center; \">Sucrose</td><td style=\"text-align: center; \">امیر‌حسین زیبایی - حمیدرضا حمیدی</td></tr><tr><td style=\"text-align: center;\">2</td><td style=\"text-align: center; \">امام رضا</td><td style=\"text-align: center; \">Null</td><td style=\"text-align: center; \">محمد خراشادی‌زاده - امیر زارع -&nbsp; مصطفی خراشادی‌زاده</td></tr><tr><td style=\"text-align: center;\">3</td><td style=\"text-align: center; \">صنعتی قوچان</td><td style=\"text-align: center; \">Access Point</td><td style=\"text-align: center; \">پوریا خندان - علی غفاریان</td></tr><tr><td style=\"text-align: center;\">4</td><td style=\"text-align: center; \">امام رضا</td><td style=\"text-align: center; \">Neuron</td><td style=\"text-align: center; \">سید امیررضا حسینی - محمدیاسین علی‌آبادی</td></tr><tr><td style=\"text-align: center;\">5</td><td style=\"text-align: center; \">امام رضا</td><td style=\"text-align: center; \">Black Pixel</td><td style=\"text-align: center; \">علی‌اکبر رضایوف - نیما اسلامی - علی حق‌شناس</td></tr></tbody></table><p><br></p><p>سایت مسابقه:&nbsp; 🖇 <a href=\"https://mashhad-ctf.ir\" target=\"_blank\">https://mashhad-ctf.ir</a><a href=\"https://mashhad-ctf.ir\" target=\"_blank\"></a></p><p><br></p><p>\r\n\r\n\r\n                </p>', '6851c516ba5ae.jpg', NULL, 1, 'approved', 0, '2025-05-18 18:25:44', '2025-09-11 16:05:10', NULL),
(2, 'مراسم اختتامیه مسابقه فتح پرچم (CTF)', '<p style=\"text-align: justify; \"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">نخستین دوره از مسابقات سراسری فتح پرچم با محتوای  امنیت سایبری با حضور دکتر طالبی معاونت آموزش و تحقیقات و دکتر مظهر معاونت فنی مرکز مدیریت راهبردی افتای ریاست جمهوری به همراه مهندس آقایی رئیس مرکز مدیریت راهبردی افتای</span><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">&nbsp;خراسان رضوی و معاونین در مورخ ۱۴۰۴/۱/۲۱ در محل دانشگاه سجاد برگزار گردید. در این دوره از مسابقات تعداد ۱۲۰ شرکت‌کننده در قالب ۵۳ تیم از دانشگاه‌های برجسته استان خراسان بزرگ حضور داشتند.</span></p><p style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\"><br></span></p>', '685123ba7b0ea.jpg', '[\"6867fffa759d2.jpg\",\"6867fffa7bf63.jpg\"]', 1, 'approved', 0, '2025-06-11 18:40:05', '2025-08-01 10:06:49', NULL),
(3, 'فراخوان جشنواره کاهش آسیب‌های فضای مجازی', '<p><div style=\"text-align: justify;\"><span style=\"color: rgb(33, 37, 41); background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">اگر دغدغه آسیب‌های فضای مجازی را دارید،</span></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">اگر دستی بر قلم، دوربین، ایده یا طراحی دارید،</span></div></span><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">و اگر می‌خواهید در مسیر اصلاح فرهنگی جامعه نقش‌آفرین باشید، در این حرکت فرهنگی اثرگذار، سهیم باشید.</span></div></span><div style=\"text-align: justify;\"><font color=\"#212529\"><br></font></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">از همه‌ی علاقه‌مندان، اساتید، معلمان، هنرمندان، دانشجویان، دانش‌آموزان، شرکتها و فعالان رسانه‌ای و دغدغه‌مند دعوت می‌شود تا آثار خلاقانه و اثرگذار خود را در خصوص محورهای جشنواره برای دبیرخانه ارسال نمایند.</span></div></span><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">آخرین مهلت ارسال آثار: </span><u style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">۳۱ مرداد ماه ۱۴۰۴</u></div></span><div style=\"text-align: justify;\"><font color=\"#212529\"><br></font></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">اطلاعات بیشتر و ارسال آثار از طریق وب سایت جشنواره به آدرس&nbsp;</span><a href=\"http://www.smartngo.ir\" target=\"_blank\" style=\"font-family: Vazir, IRANSans; font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">www.smartngo.ir</a></div></span><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">یا نشانی khrsmartngo@ در شبکه های اجتماعی و پیام‌رسان‌ها</span></div></span><div style=\"text-align: justify;\"><font color=\"#212529\"><br></font></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">به آثار منتخب 2.000.000.000 ریال جایزه نقدی و جوایز ارزنده غیر نقد دیگر اهدا خواهد شد.</span></div></span><div style=\"text-align: justify;\"><font color=\"#212529\"><br></font></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">منتظر خلاقیت‌های شما هستیم!</span></div></span><div style=\"text-align: justify;\"><font color=\"#212529\"><br></font></div><span style=\"color: rgb(33, 37, 41);\"><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">(انجمن عام‌المنفعه هوشمندسازی استان خراسان رضوی)</span></div></span></p><p><br></p>', '684b391edc075.jpg', NULL, 1, 'approved', 0, '2025-06-12 19:31:26', '2025-08-01 10:07:30', NULL),
(4, 'مراسم تقدیر از کادر اجرایی مسابقه فتح پرچم', '<div style=\"text-align: justify; \"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">مراسم تقدیر و تشکر از کادر اجرایی مسابقه فتح پرچم، روز سه‌شنبه، ۳۱ اردیبهشت ماه، با حضور نمایندگان محترم مرکز مدیریت راهبردی افتای خراسان رضوی و جمعی از مسئولین دانشگاه سجاد در محل این دانشگاه&nbsp;</span><span style=\"font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); background-color: var(--bs-body-bg);\">به منظور ارج نهادن به تلاش‌های بی‌وقفه و زحمات شبانه‌روزی دست‌اندرکاران و کادر اجرایی مسابقه فتح پرچم برگزار شد. سخنرانان در این مراسم، ضمن تقدیر از سطح برگزاری و کیفیت بالای مسابقه، بر اهمیت برگزاری رویدادهایی از این دست در راستای کشف و پرورش استعدادهای جوان در حوزه امنیت سایبری تأکید کردند.</span><br></div><div><div style=\"outline: none !important;\"><div style=\"text-align: justify;\"><br></div><div style=\"text-align: justify;\"><span style=\"background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">در پایان، با اهدای لوح تقدیر و هدایایی، از زحمات و همکاری‌های ارزشمند تمامی اعضای کادر اجرایی مسابقه فتح پرچم قدردانی به عمل آمد.</span></div></div><div style=\"outline: none !important;\"><br></div></div>', '68507685b665c.jpg', '[\"6862b9a95ab2c.jpg\",\"6862b9a963f9e.jpg\",\"6862b9a96958f.jpg\",\"6862b9a96f350.jpg\"]', 1, 'approved', 0, '2025-06-16 18:54:45', '2025-09-11 16:04:51', NULL),
(5, 'دوره آموزشی مجازی تهدیدات سایبری و راهکارهای دفاعی', '<div><span style=\"color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" background-color:=\"\" var(--bs-body-bg);=\"\" font-size:=\"\" var(--bs-body-font-size);=\"\" font-weight:=\"\" var(--bs-body-font-weight);\"=\"\">📢 دوره آموزشی مجازی تهدیدات سایبری و راهکارهای دفاعی</span><br></div><div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br style=\"outline: none !important;\"></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">📅 زمان برگزاری:</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">یکشنبه ۲۹ تیرماه | ساعت ۱۶:۰۰ تا ۱۹:۰۰</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br style=\"outline: none !important;\"></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">🖥 محل برگزاری:</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">به‌صورت آنلاین از طریق سامانه اسکای روم</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br style=\"outline: none !important;\"></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">&nbsp;🎯 سرفصل‌های کلیدی دوره: ️</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">&nbsp;- آشنایی با جدیدترین تهدیدات سایبری ️</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">- یادگیری راهکارهای دفاعی و امنیتی ️</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br style=\"outline: none !important;\"></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">&nbsp;-آموزش توسط اساتید مجرب ️</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">&nbsp;- ارائه گواهینامه معتبر</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br style=\"outline: none !important;\"></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">📞 اطلاعات بیشتر و ثبت‌نام:</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">۰۵۱-۳۸۷۸۷۷۶۶ | ۰۵۱-۳۸۷۸۹۳۶۷</div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\">🌐 <a href=\"http://tam.kmtc.ir\" target=\"_blank\">tam.kmtc.ir</a></div><div style=\"text-align: right; color: rgb(29, 34, 40); font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" outline:=\"\" none=\"\" !important;\"=\"\"><br></div></div>', '687a8a1eb74fe.jpg', NULL, 1, 'approved', 0, '2025-07-18 16:53:36', '2025-09-09 13:34:15', NULL);

-- --------------------------------------------------------


--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------



--
-- Table structure for table `category_news`
--

DROP TABLE IF EXISTS `category_news`;
CREATE TABLE IF NOT EXISTS `category_news` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_news_news_id_foreign` (`news_id`),
  KEY `category_news_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issued_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `news_id` bigint UNSIGNED DEFAULT NULL,
  `article_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_news_id_foreign` (`news_id`),
  KEY `comments_article_id_foreign` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `news_id`, `article_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 'خدا قوت', 1, 2, NULL, 'pending', '2025-09-27 18:45:01', '2025-09-27 18:45:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_requests`
--

DROP TABLE IF EXISTS `consultation_requests`;
CREATE TABLE IF NOT EXISTS `consultation_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` enum('ISO15408','ISO25000','penetration_test','document_management') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','responded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(61, '2014_10_12_000000_create_users_table', 1),
(62, '2014_10_12_100000_create_password_resets_table', 1),
(63, '2019_08_19_000000_create_failed_jobs_table', 1),
(64, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(65, '2025_03_18_180000_create_news_table', 1),
(66, '2025_03_18_181000_create_articles_table', 1),
(67, '2025_03_18_182000_create_comments_table', 1),
(68, '2025_03_18_183000_create_permission_tables', 1),
(69, '2025_06_30_120000_create_sliders_table', 1),
(70, '2025_07_05_200000_create_assessment_requests_table', 1),
(71, '2025_07_05_201000_create_assessment_request_checklists_table', 1),
(72, '2025_07_05_202000_create_projects_table', 1),
(73, '2025_07_05_203000_create_tickets_table', 1),
(74, '2025_08_26_200000_create_sessions_table', 1),
(75, '2025_09_30_160000_create_categories_table', 1),
(76, '2025_09_30_161000_create_category_news_table', 1),
(77, '2025_09_30_162000_create_topics_table', 1),
(78, '2025_09_30_163000_create_article_topic_table', 1),
(79, '2025_09_30_170000_create_standards_table', 1),
(80, '2025_09_30_171000_create_certificates_table', 1),
(81, '2025_09_30_172000_create_achievements_table', 1),
(83, '2026_06_12_183002_add_category_and_priority_to_tickets_table', 2),
(84, '2026_07_17_152035_add_receiver_role_to_tickets_table', 3),
(85, '2026_07_17_214322_update_articles_table_for_public_articles', 4),
(86, '2026_07_17_222345_add_description_to_articles_table', 5),
(87, '2026_07_18_152444_create_article_proposals_table', 6),
(88, '2026_07_18_160549_add_admin_note_to_articles_table', 7),
(89, '2026_07_18_200000_create_consultation_requests_table', 8),
(90, '2026_07_31_000000_add_submission_fields_to_article_proposals_table', 9),
(91, '2026_07_31_125958_add_price_fields_to_articles_table', 10),
(92, '2026_07_31_130018_create_orders_table', 10),
(93, '2026_07_31_130028_create_order_items_table', 10),
(94, '2026_07_31_130038_create_user_downloads_table', 10),
(95, '2026_07_31_135229_add_manage_orders_permission', 11),
(98, '2026_08_20_231056_create_settings_table', 13),
(99, '2026_08_20_231716_add_manage_settings_permission', 13),
(101, '2026_08_21_111637_create_system_logs_table', 14),
(102, '2026_08_21_212117_add_user_name_to_system_logs_table', 15),
(103, '2026_08_21_212117_add_user_name_to_system_logs_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(8, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(9, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25),
(8, 'App\\Models\\User', 26),
(2, 'App\\Models\\User', 27),
(8, 'App\\Models\\User', 29),
(2, 'App\\Models\\User', 30),
(2, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 32),
(9, 'App\\Models\\User', 33),
(2, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(2, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 55);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','paid','failed','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه تراکنش از درگاه',
  `total_amount` bigint NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `transaction_id`, `total_amount`, `payment_method`, `paid_at`, `buyer_name`, `buyer_email`, `buyer_phone`, `terms_accepted`, `admin_note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'paid', 'SIM_6a6c7498d4c2c', 110000, 'simulated', '2026-07-31 10:10:32', 'مدیر سایت', 'admin1@example.com', '09907702002', 1, NULL, '2026-07-31 10:10:22', '2026-07-31 10:10:32', NULL),
(2, 6, 'paid', 'SIM_6a6c7dd99505c', 110000, 'simulated', '2026-07-31 10:50:01', 'علی جهانی', 'a.jahani@example.org', '09645917461', 1, NULL, '2026-07-31 10:49:55', '2026-07-31 10:50:01', NULL),
(3, 6, 'pending', NULL, 115000, NULL, NULL, 'علی جهانی', 'a.jahani@example.org', '09645917461', 1, NULL, '2026-07-31 10:57:10', '2026-07-31 10:59:01', NULL),
(4, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:07:10', '2026-07-31 11:10:28', '2026-07-31 11:10:28'),
(5, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 1, NULL, '2026-07-31 11:10:37', '2026-07-31 11:23:28', '2026-07-31 11:23:28'),
(6, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:23:30', '2026-07-31 11:23:40', '2026-07-31 11:23:40'),
(7, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:23:42', '2026-07-31 11:25:28', '2026-07-31 11:25:28'),
(8, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:25:30', '2026-07-31 11:25:39', '2026-07-31 11:25:39'),
(9, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:25:41', '2026-07-31 11:25:44', '2026-07-31 11:25:44'),
(10, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:25:47', '2026-07-31 11:27:14', '2026-07-31 11:27:14'),
(11, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:27:18', '2026-07-31 11:27:24', '2026-07-31 11:27:24'),
(12, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:28:52', '2026-07-31 11:28:59', '2026-07-31 11:28:59'),
(13, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:30:04', '2026-07-31 11:31:35', '2026-07-31 11:31:35'),
(14, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:31:40', '2026-07-31 11:31:46', '2026-07-31 11:31:46'),
(15, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:31:49', '2026-07-31 11:44:23', '2026-07-31 11:44:23'),
(16, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:45:52', '2026-07-31 11:45:58', '2026-07-31 11:45:58'),
(17, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:46:00', '2026-07-31 11:46:06', '2026-07-31 11:46:06'),
(18, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:46:11', '2026-07-31 11:47:47', '2026-07-31 11:47:47'),
(19, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:48:05', '2026-07-31 11:49:29', '2026-07-31 11:49:29'),
(20, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:49:51', '2026-07-31 11:50:15', '2026-07-31 11:50:15'),
(21, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:50:20', '2026-07-31 11:50:22', '2026-07-31 11:50:22'),
(22, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:50:28', '2026-07-31 11:50:30', '2026-07-31 11:50:30'),
(23, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:50:33', '2026-07-31 11:50:36', '2026-07-31 11:50:36'),
(24, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:50:48', '2026-07-31 11:51:06', '2026-07-31 11:51:06'),
(25, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:51:09', '2026-07-31 11:52:41', '2026-07-31 11:52:41'),
(26, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:52:43', '2026-07-31 11:52:45', '2026-07-31 11:52:45'),
(27, 1, 'pending', NULL, 0, NULL, NULL, 'مدیر سایت', 'admin1@example.com', '09907702002', 0, NULL, '2026-07-31 11:52:53', '2026-07-31 11:52:58', '2026-07-31 11:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `price` bigint NOT NULL COMMENT 'قیمت در زمان خرید',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_article_id_foreign` (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `article_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 110000, '2026-07-31 10:10:22', '2026-07-31 10:10:22'),
(2, 2, 9, 110000, '2026-07-31 10:49:55', '2026-07-31 10:49:55'),
(3, 3, 8, 100000, '2026-07-31 10:57:10', '2026-07-31 10:57:10'),
(4, 3, 7, 15000, '2026-07-31 10:59:01', '2026-07-31 10:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fa_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `fa_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage_users', 'مدیریت کاربران', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(2, 'manage_roles', 'مدیریت نقش‌ها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(3, 'manage_projects', 'مدیریت پروژه‌ها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(4, 'manage_news', 'مدیریت خبرها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(5, 'manage_articles', 'مدیریت مقاله‌ها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(6, 'manage_sliders', 'مدیریت اسلایدرها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(7, 'manage_comments', 'مدیریت کامنت‌ها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(8, 'manage_tickets', 'مدیریت تیکت‌ها', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(9, 'manage_logs', 'مدیریت لاگ‌های سیستم', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(10, 'manage_support_tickets', 'مدیریت تیکت‌های پشتیبانی', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(11, 'submit_news', 'ثبت خبر', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(12, 'submit_article', 'ثبت مقاله', 'web', '2025-08-27 07:29:20', '2025-08-27 07:29:20'),
(13, 'manage_consultations', 'مدیریت درخواست‌های مشاوره', 'web', '2026-07-18 20:13:27', '2026-07-18 20:13:27'),
(14, 'manage_orders', 'مدیریت سفارشات', 'web', '2026-07-31 10:29:02', '2026-07-31 10:29:02'),
(15, 'manage_settings', 'مدیریت تنظیمات', 'web', '2026-08-20 19:47:35', '2026-08-20 19:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint UNSIGNED NOT NULL,
  `assessment_request_id` bigint UNSIGNED DEFAULT NULL,
  `primary_coach_id` bigint UNSIGNED NOT NULL,
  `secondary_coach_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('request_submission','initial_audit','contract_signing','testing_and_monitoring','final_confirmation','final_report_submission','end_of_contract') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'request_submission',
  `request_submission` text COLLATE utf8mb4_unicode_ci,
  `request_submission_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initial_audit` text COLLATE utf8mb4_unicode_ci,
  `initial_audit_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_signing` text COLLATE utf8mb4_unicode_ci,
  `contract_signing_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testing_and_monitoring` text COLLATE utf8mb4_unicode_ci,
  `testing_and_monitoring_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_confirmation` text COLLATE utf8mb4_unicode_ci,
  `final_confirmation_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_report_submission` text COLLATE utf8mb4_unicode_ci,
  `final_report_submission_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_of_contract` text COLLATE utf8mb4_unicode_ci,
  `end_of_contract_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_applicant_id_foreign` (`applicant_id`),
  KEY `projects_assessment_request_id_foreign` (`assessment_request_id`),
  KEY `projects_primary_coach_id_foreign` (`primary_coach_id`),
  KEY `projects_secondary_coach_id_foreign` (`secondary_coach_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `applicant_id`, `assessment_request_id`, `primary_coach_id`, `secondary_coach_id`, `title`, `status`, `request_submission`, `request_submission_file`, `initial_audit`, `initial_audit_file`, `contract_signing`, `contract_signing_file`, `testing_and_monitoring`, `testing_and_monitoring_file`, `final_confirmation`, `final_confirmation_file`, `final_report_submission`, `final_report_submission_file`, `end_of_contract`, `end_of_contract_file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 1, NULL, 'خلاصه اقدامات و جلسات برگزار شده در خصوص پروژه', 'initial_audit', 'گزارش کار پروژه\r\nموضوع: خلاصه اقدامات و جلسات برگزار شده در خصوص پروژه\r\nتاریخ: ۲۹ تیر ۱۴۰۴\r\nاین گزارش به منظور تشریح و مستندسازی فعالیت‌ها و جلسات برگزار شده در راستای پیشبرد پروژه، از مرحله بررسی محتوا تا تعیین وظایف تیم‌های فنی، تهیه و ارائه می‌گردد.', 'report-01.pdf', '۱. بررسی و تدوین محتوای پروژه:\r\n• برگزاری جلسات متعدد در دفتر جناب آقای دادرس: در این جلسات، محتواهای اولیه که از سوی ایشان در اختیار تیم قرار گرفته بود، مورد بحث و بررسی قرار گرفت.\r\n• بررسی فنی در آزمایشگاه افتا: محتوای دریافتی جهت تحلیل و ارزیابی فنی به آزمایشگاه افتا ارسال گردید.\r\n• مکتوب‌سازی تغییرات: کلیه موارد نیازمند حذف یا اضافه در محتوای پروژه به صورت مکتوب درآمد و در جلسات آتی با حضور جناب آقای دادرس مجدداً بررسی و نهایی شد.\r\n۲. نهایی‌سازی و امضای سند پروژه:\r\n• برگزاری سه جلسه نهایی: پس از تدوین محتوا، سه جلسه متمرکز بر روی فایل نهایی سند پروژه در دفتر جناب آقای دادرس برگزار گردید تا تمامی جوانب سند پیش از امضا، شفاف‌سازی شود.\r\n• امضای نهایی اسناد :در جلسه آخر، تمامی اوراق و اسناد مربوط به پروژه به امضای طرفین رسید. دو نسخه از اسناد امضا شده تهیه گردید که یک نسخه نزد جناب آقای دادرس و نسخه دیگر نزد جناب آقای دکتر سالخورده و جناب مهندس حسامی باقی ماند.\r\n۳. هماهنگی و زمان‌بندی تیم‌های اجرایی:\r\n• جلسه زمان‌بندی پروژه راهکار: یک جلسه اختصاصی در دفتر جناب آقای حسامی به منظور تدوین و نهایی‌سازی زمان‌بندی اجرای \"پروژه راهکار\" برگزار شد.\r\n• جلسات با تیم‌های فنی:\r\no یک جلسه مشترک با حضور تیم‌های فرانت‌اند (Front-End) و بک‌اند (Back-End) پروژه برگزار گردید.\r\no چندین جلسه مجزا با تیم طراحی رابط کاربری (UI) برگزار شد.\r\n۴. تخصیص و تحویل وظایف (تسک‌ها):\r\n• تیمهای فرانت‌اند و بک‌اند: در طی جلسه مشترک، تعدادی وظیفه (تسک) مشخص به این تیم‌ها محول گردید. مقرر شد تسک‌های مذکور تا انتهای هفته آتی تکمیل و تحویل داده شوند.\r\n• تیم UI: برای تیم طراحی رابط کاربری نیز وظایف مشخصی در نظر گرفته شد که این تیم با موفقیت تمامی تسک‌های محوله را به طور کامل انجام داده و تحویل نموده است.\r\nوضعیت فعلی:\r\nدر حال حاضر، تیم UI وظایف اولیه خود را به اتمام رسانده و تیمهای برنامه‌نویسی فرانت‌اند و بک‌اند در حال کار بر روی تسک‌های تعیین شده می‌باشند. پروژه طبق زمان‌بندی مورد توافق در حال پیشرفت است.\r\nبا احترام سیده یگانه خراشادی زاده', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-13 07:11:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-06-05 21:58:03', '2025-06-05 21:58:03'),
(2, 'user', 'web', '2025-06-05 21:58:03', '2025-06-05 21:58:03'),
(3, 'support', 'web', '2025-06-05 21:58:04', '2025-06-05 21:58:04'),
(8, 'coach', 'web', '2025-08-27 06:48:02', '2025-08-27 06:48:02'),
(9, 'delegate', 'web', '2025-08-27 07:01:40', '2025-08-27 07:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(1, 3),
(3, 3),
(4, 3),
(5, 3),
(7, 3),
(9, 3),
(10, 3),
(13, 3),
(14, 3),
(15, 3),
(10, 9);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7YqWc2qew4PVMRDtZb9eg7QBmj1147K7lcHSYSay', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOVJCNFMxNFRHR2lidVhud3RHaGczcmVXSEV1YUxBTU40VVBLRldCRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQvbWFuYWdlLXN1cHBvcnQtdGlja2V0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU5Nzg2NDE3O319', 1759787389);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'password_min_length', '8', '2026-08-20 20:07:40', '2026-08-20 20:09:53'),
(2, 'password_complexity', 'medium', '2026-08-20 20:07:40', '2026-08-20 20:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slide_number` tinyint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sliders_slide_number_unique` (`slide_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `slide_number`, `image`, `title`, `description`, `button_text`, `button_link`, `created_at`, `updated_at`) VALUES
(1, 1, 'banner.jpg', NULL, NULL, NULL, NULL, '2025-07-04 09:48:42', '2025-07-04 09:48:42'),
(2, 2, 'CTF06.jpg', 'مراسم اختتامیه مسابقه فتح پرچم (CTF)', 'نخستین دوره از مسابقات سراسری فتح پرچم با محتوای امنیت سایبری با حضور دکتر طالبی معاونت آموزش و تحقیقات و دکتر مظهر معاونت فنی مرکز مدیریت راهبردی افتای ریاست جمهوری به همراه مهندس آقایی رئیس مرکز مدیریت راهبردی افتای خراسان رضوی و معاونین در ...', 'نمایش خبر', '/news/2', '2025-07-04 09:51:27', '2025-07-04 15:31:55'),
(3, 3, 'CTF07.jpg', 'برگزاری مسابقه امنیت سایبری - فتح پرچم در دانشگاه سجاد', 'مسابقه فتح پرچم در روز پنجشنبه مورخ ۲۱ فروردین ۱۴۰۴ در محل دانشگاه سجاد با حمایت مرکز مدیریت راهبردی افتای خراسان رضوی و شرکت خدمات علمی صنعتی خراسان برگزار گردید...', 'نمایش خبر', '/news/1', '2025-07-04 09:53:06', '2025-07-04 15:47:22'),
(4, 4, 'CTF04.jpg', 'مراسم اختتامیه مسابقه فتح پرچم (CTF)', 'نخستین دوره از مسابقات سراسری فتح پرچم با محتوای امنیت سایبری با حضور دکتر طالبی معاونت آموزش و تحقیقات و دکتر مظهر معاونت فنی مرکز مدیریت راهبردی افتای ریاست جمهوری به همراه مهندس آقایی رئیس مرکز مدیریت راهبردی افتای خراسان رضوی و معاونین در ...', 'نمایش خبر', '/news/2', '2025-07-04 09:54:20', '2025-07-04 15:34:04'),
(5, 5, 'CTF05.jpg', 'مراسم اختتامیه مسابقه فتح پرچم (CTF)', 'نخستین دوره از مسابقات سراسری فتح پرچم با محتوای امنیت سایبری با حضور دکتر طالبی معاونت آموزش و تحقیقات و دکتر مظهر معاونت فنی مرکز مدیریت راهبردی افتای ریاست جمهوری به همراه مهندس آقایی رئیس مرکز مدیریت راهبردی افتای خراسان رضوی و معاونین در ...', 'نمایش خبر', '/news/2', '2025-07-04 09:57:25', '2025-07-04 15:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `standards`
--

DROP TABLE IF EXISTS `standards`;
CREATE TABLE IF NOT EXISTS `standards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

DROP TABLE IF EXISTS `system_logs`;
CREATE TABLE IF NOT EXISTS `system_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_result` tinyint(1) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `details` json DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `affected_entity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affected_entity_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_logs_user_id_foreign` (`user_id`),
  KEY `system_logs_event_time_event_type_user_id_index` (`event_time`,`event_type`,`user_id`),
  KEY `system_logs_event_category_event_result_index` (`event_category`,`event_result`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `event_time`, `event_type`, `event_category`, `event_result`, `user_id`, `user_name`, `user_ip`, `user_agent`, `session_id`, `method`, `url`, `route_name`, `description`, `details`, `error_message`, `affected_entity`, `affected_entity_id`, `created_at`, `updated_at`) VALUES
(2, '2026-08-21 08:44:22', 'data_delete', 'data', 1, 1, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'BmI0s0uQOpr9Glr8HYJ2Q22Ey0xpKbHt2fTv8RFf', 'DELETE', 'http://127.0.0.1:8000/dashboard/manage-logs/1', 'dashboard.manage-logs.destroy', 'حذف رکورد از system_log', '{\"data\": {\"log_id\": \"1\"}, \"entity\": \"system_log\", \"entity_id\": \"1\"}', NULL, NULL, NULL, '2026-08-21 08:44:22', '2026-08-21 08:44:22'),
(3, '2026-08-21 12:00:19', 'authentication_result', 'auth', 1, 1, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Umqt9yRwYXXAZp5L9oRKswDu4GuhlitEEGuKfWMg', 'POST', 'http://127.0.0.1:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"admin1@example.com\"}', NULL, NULL, NULL, '2026-08-21 12:00:19', '2026-08-21 12:00:19'),
(4, '2026-08-21 17:35:28', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'to6UhditZnwIpAGYNRQb6Xn7myMcAXKNPYiY51rT', 'POST', 'http://127.0.0.1:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"email\": \"admin1@example.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-21 17:35:28', '2026-08-21 17:35:28'),
(5, '2026-08-21 17:35:55', 'authentication_result', 'auth', 1, 1, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'D1MNcZfaAYrGeqfO8CWzgTVHfYvvskPjMTq7U60N', 'POST', 'http://127.0.0.1:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"admin1@example.com\"}', NULL, NULL, NULL, '2026-08-21 17:35:55', '2026-08-21 17:35:55'),
(6, '2026-08-21 17:36:39', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', '9LKaEXrtRCe8BH0lH4qk7Sy14x7amXKt1inkkyOX', 'POST', 'http://127.0.0.1:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: Sample@Sample.com', '{\"ip\": \"127.0.0.1\", \"email\": \"Sample@Sample.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-21 17:36:39', '2026-08-21 17:36:39'),
(7, '2026-08-21 17:38:55', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', '9LKaEXrtRCe8BH0lH4qk7Sy14x7amXKt1inkkyOX', 'POST', 'http://127.0.0.1:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: Sample@Sample.com', '{\"ip\": \"127.0.0.1\", \"email\": \"Sample@Sample.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-21 17:38:55', '2026-08-21 17:38:55'),
(8, '2026-08-21 17:42:10', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', '9LKaEXrtRCe8BH0lH4qk7Sy14x7amXKt1inkkyOX', 'POST', 'http://127.0.0.1:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: Sample@Sample.com', '{\"ip\": \"127.0.0.1\", \"email\": \"Sample@Sample.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-21 17:42:10', '2026-08-21 17:42:10'),
(9, '2026-08-21 17:44:45', 'authentication_result', 'auth', 1, 7, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'KzeVw1tqtDq3PNt5LzzhZdbHsmg12m2dKkWEfLR5', 'POST', 'http://127.0.0.1:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: yousefi@example.com', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"yousefi@example.com\"}', NULL, NULL, NULL, '2026-08-21 17:44:45', '2026-08-21 17:44:45'),
(10, '2026-08-21 17:44:48', 'session_terminated_by_lock', 'session', 1, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', '1SIGma8rmCZHSK5Y6CdcXMDz3tV9LmtgLCVsHrLe', 'POST', 'http://127.0.0.1:8000/logout', 'logout', 'خاتمه نشست برای کاربر:  توسط user', '{\"reason\": \"manual logout\", \"terminated_by\": \"user\"}', NULL, NULL, NULL, '2026-08-21 17:44:48', '2026-08-21 17:44:48'),
(11, '2026-08-21 17:46:05', 'authentication_result', 'auth', 1, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'V7H3xKbADEW3gHEucFkMxqGkJe9ykwvVUifK4X0K', 'POST', 'http://127.0.0.1:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: rashidi@example.net', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"rashidi@example.net\"}', NULL, NULL, NULL, '2026-08-21 17:46:05', '2026-08-21 17:46:05'),
(12, '2026-08-21 17:46:19', 'data_update', 'data', 1, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'V7H3xKbADEW3gHEucFkMxqGkJe9ykwvVUifK4X0K', 'PATCH', 'http://127.0.0.1:8000/dashboard/my-profile/update-name', 'dashboard.my-profile.update-name', 'به‌روزرسانی رکورد در users', '{\"entity\": \"users\", \"new_data\": {\"new_name\": \"رشید سعیدی\"}, \"old_data\": {\"old_name\": \"سعید رشیدی\"}, \"entity_id\": 10}', NULL, NULL, NULL, '2026-08-21 17:46:19', '2026-08-21 17:46:19'),
(13, '2026-08-21 17:47:57', 'security_attribute_changed', 'security', 1, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'V7H3xKbADEW3gHEucFkMxqGkJe9ykwvVUifK4X0K', 'PATCH', 'http://127.0.0.1:8000/dashboard/my-profile/update-password', 'dashboard.my-profile.update-password', 'تغییر مشخصه امنیتی password برای کاربر rashidi@example.net', '{\"user\": \"rashidi@example.net\", \"attribute\": \"password\", \"new_value\": \"***\", \"old_value\": \"***\"}', NULL, NULL, NULL, '2026-08-21 17:47:57', '2026-08-21 17:47:57'),
(14, '2026-08-21 17:48:39', 'data_delete', 'data', 1, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'V7H3xKbADEW3gHEucFkMxqGkJe9ykwvVUifK4X0K', 'DELETE', 'http://127.0.0.1:8000/dashboard/my-profile/delete-account', 'dashboard.my-profile.delete-account', 'حذف رکورد از users', '{\"data\": {\"name\": \"رشید سعیدی\", \"email\": \"rashidi@example.net\", \"user_id\": 10, \"deleted_by_self\": true}, \"entity\": \"users\", \"entity_id\": 10}', NULL, NULL, NULL, '2026-08-21 17:48:39', '2026-08-21 17:48:39'),
(15, '2026-08-21 18:03:29', 'entity_operation', 'entity', 1, 1, 'مدیر سایت', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'D1MNcZfaAYrGeqfO8CWzgTVHfYvvskPjMTq7U60N', 'POST', 'http://127.0.0.1:8000/dashboard/manage-proposals/8/approve', 'dashboard.manage-proposals.approve', 'درخواست approve_proposal بر روی موجودیت article_proposal', '{\"entity\": \"article_proposal\", \"entity_id\": 8, \"operation\": \"approve_proposal\"}', NULL, NULL, NULL, '2026-08-21 18:03:29', '2026-08-21 18:03:29'),
(16, '2026-08-21 18:03:55', 'data_delete', 'data', 1, 1, 'مدیر سایت', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'D1MNcZfaAYrGeqfO8CWzgTVHfYvvskPjMTq7U60N', 'DELETE', 'http://127.0.0.1:8000/dashboard/manage-proposals/8', 'dashboard.manage-proposals.destroy', 'حذف رکورد از article_proposals', '{\"data\": {\"title\": \"123123\", \"status\": \"approved\", \"user_id\": 1}, \"entity\": \"article_proposals\", \"entity_id\": 8}', NULL, NULL, NULL, '2026-08-21 18:03:55', '2026-08-21 18:03:55'),
(17, '2026-08-28 15:16:42', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'BSmFkV2i89nHSEEzRhEgoXlfbOdNk2ay0kEvPrux', 'POST', 'http://localhost:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: admin@example.com', '{\"ip\": \"127.0.0.1\", \"email\": \"admin@example.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-28 15:16:42', '2026-08-28 15:16:42'),
(18, '2026-08-28 15:18:39', 'authentication_attempt', 'auth', 0, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'BSmFkV2i89nHSEEzRhEgoXlfbOdNk2ay0kEvPrux', 'POST', 'http://localhost:8000/login', NULL, 'تلاش برای احراز هویت با ایمیل: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"email\": \"admin1@example.com\", \"error\": \"invalid credentials\"}', NULL, NULL, NULL, '2026-08-28 15:18:39', '2026-08-28 15:18:39'),
(19, '2026-08-28 15:18:50', 'authentication_result', 'auth', 1, 1, 'مدیر سایت', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'QDmzBc1CgWOPEII3CUyhPvqe2Dh5YbQrIzQOOnSY', 'POST', 'http://localhost:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"admin1@example.com\"}', NULL, NULL, NULL, '2026-08-28 15:18:50', '2026-08-28 15:18:50'),
(20, '2026-08-28 15:19:07', 'administrative_action', 'admin', 1, 1, 'مدیر سایت', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'QDmzBc1CgWOPEII3CUyhPvqe2Dh5YbQrIzQOOnSY', 'POST', 'http://localhost:8000/dashboard/manage-logs/ban-ip', 'dashboard.manage-logs.ban-ip.store', 'عملیات مدیریتی: ban_ip روی 127.0.0.1', '{\"action\": \"ban_ip\", \"target\": \"127.0.0.1\"}', NULL, NULL, NULL, '2026-08-28 15:19:07', '2026-08-28 15:19:07'),
(21, '2026-08-28 16:32:12', 'authentication_result', 'auth', 1, 1, 'مدیر سایت', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', 'Kz2gMNHlKaPlMbM2WQuWHwxCnWGxtb8xFxJRRADA', 'POST', 'http://127.0.0.1:8000/login', NULL, 'نتیجه احراز هویت برای کاربر: admin1@example.com', '{\"ip\": \"127.0.0.1\", \"method\": \"email_password\", \"user_email\": \"admin1@example.com\"}', NULL, NULL, NULL, '2026-08-28 16:32:12', '2026-08-28 16:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED DEFAULT NULL,
  `receiver_role` enum('admin','support','coach','delegate') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('technical','financial','support','content','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `priority` enum('low','medium','high') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','in_progress','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `response` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_sender_id_foreign` (`sender_id`),
  KEY `tickets_receiver_id_foreign` (`receiver_id`),
  KEY `tickets_project_id_foreign` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `sender_id`, `receiver_id`, `receiver_role`, `project_id`, `subject`, `category`, `priority`, `message`, `status`, `response`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 50, 54, NULL, NULL, 'کمک', 'other', 'medium', 'کمک تست', 'closed', 'اوکی', '2025-09-27 19:36:27', '2025-09-28 08:36:08', NULL),
(6, 54, NULL, NULL, NULL, 'تست', 'other', 'medium', 'تست', 'open', 'بررسی شد..', '2025-10-05 08:08:48', '2025-10-06 21:46:37', NULL),
(7, 1, NULL, NULL, NULL, 'نامعتبر', 'other', 'medium', 'این تیکت نامعتبر است. اقدام به حذف آن شود.', 'closed', NULL, '2025-10-06 17:23:12', '2025-10-06 17:25:48', '2025-10-06 17:25:48'),
(8, 1, 13, NULL, NULL, 'نقص مدارک درخواست پیش ارزیابی', 'other', 'medium', 'کاربر گرامی، مدارک ارسالی شما برای درخواست پیش ارزیابی ناقص است.', 'closed', 'اصلاح شد. بررسی نمایید.', '2025-10-06 18:17:17', '2025-10-06 20:18:30', NULL),
(11, 4, 50, NULL, NULL, 'درخواست نامعتبر', 'other', 'medium', 'با سلام. درخواست شما با عنوان پیش ارزیابی محصول با نام hhd نامعتبر است.', 'open', NULL, '2025-10-06 20:33:55', '2025-10-06 20:33:55', NULL),
(12, 1, NULL, NULL, 1, 'تیکت پروژه - 1', 'other', 'medium', 'تیکت پروژه - 1', 'in_progress', 'دریافت شد.', '2025-10-06 21:11:01', '2025-10-06 21:26:44', NULL),
(14, 55, NULL, NULL, NULL, 'kjhasIH', 'other', 'medium', 'ASDFASFD', 'open', NULL, '2026-05-30 12:32:36', '2026-05-30 12:35:16', '2026-05-30 12:35:16'),
(15, 6, 7, NULL, NULL, 'کمک', 'other', 'medium', 'تنذیستیشست', 'closed', NULL, '2026-06-12 14:10:04', '2026-07-17 11:59:42', '2026-07-17 11:59:42'),
(16, 6, 4, NULL, NULL, 'کمک', 'other', 'medium', '123', 'open', NULL, '2026-06-12 14:16:28', '2026-07-17 11:59:39', '2026-07-17 11:59:39'),
(17, 6, 16, NULL, NULL, ';l;', 'other', 'medium', '1234', 'open', NULL, '2026-06-12 14:18:05', '2026-07-17 11:59:36', '2026-07-17 11:59:36'),
(18, 16, 16, NULL, NULL, '123', 'other', 'medium', '123', 'in_progress', NULL, '2026-06-12 14:24:18', '2026-07-17 11:59:33', '2026-07-17 11:59:33'),
(19, 6, 16, NULL, NULL, '123', 'other', 'medium', '123', 'closed', NULL, '2026-06-12 14:25:22', '2026-07-17 11:59:22', '2026-07-17 11:59:22'),
(20, 16, 24, NULL, NULL, '213', 'other', 'medium', '213123', 'open', NULL, '2026-06-12 14:34:58', '2026-07-17 11:59:20', '2026-07-17 11:59:20'),
(21, 6, 4, NULL, NULL, '123213', 'technical', 'high', 'خهزشنتیننرن', 'closed', NULL, '2026-06-12 15:08:42', '2026-06-12 18:44:57', '2026-06-12 18:44:57'),
(22, 6, 16, NULL, NULL, '123123', 'technical', 'medium', '123123', 'open', '231213', '2026-06-12 15:16:44', '2026-06-16 19:12:16', '2026-06-16 19:12:16'),
(23, 16, 16, NULL, NULL, '123', 'financial', 'high', '123123', 'closed', NULL, '2026-06-12 18:35:31', '2026-06-12 18:44:49', '2026-06-12 18:44:49'),
(24, 16, 4, NULL, NULL, '123', 'financial', 'high', 'نذتنتتن', 'open', NULL, '2026-06-12 18:43:48', '2026-06-12 18:44:46', '2026-06-12 18:44:46'),
(25, 1, 16, NULL, NULL, 'قبص', 'technical', 'low', 'ثقصقثصش', 'closed', NULL, '2026-06-12 18:44:09', '2026-06-12 18:44:39', '2026-06-12 18:44:39'),
(26, 1, 24, NULL, NULL, '123123', 'technical', 'low', '123213', 'in_progress', NULL, '2026-07-17 11:34:26', '2026-07-17 11:59:17', '2026-07-17 11:59:17'),
(27, 24, 4, NULL, NULL, '123', 'technical', 'low', '123', 'open', NULL, '2026-07-17 11:40:37', '2026-07-17 11:59:14', '2026-07-17 11:59:14'),
(28, 1, NULL, 'support', NULL, '123', 'financial', 'medium', '123', 'closed', '32123123123123123', '2026-07-17 11:59:53', '2026-07-17 12:07:09', NULL),
(29, 7, NULL, 'delegate', NULL, 'kjhasIH', 'technical', 'medium', '123123', 'closed', 'xyz', '2026-07-17 12:07:54', '2026-07-17 12:41:45', '2026-07-17 12:41:45'),
(30, 1, 26, 'coach', NULL, '123', 'technical', 'medium', '123123', 'closed', '23123123', '2026-07-17 12:42:28', '2026-07-17 12:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topics_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `login_attempts` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_mobile_number_unique` (`mobile_number`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile_number`, `email`, `password`, `avatar`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `login_attempts`, `locked_until`) VALUES
(1, 'مدیر سایت', '09907702002', 'admin1@example.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', '68377a6af26ae.png', NULL, 'cYvniQ0O8q7DBsa63Wlw1g0Ex6A1ut4oqu5VR2lhG1zrMoPGEwQsyAI2vpx0', '2025-05-18 14:48:19', '2026-08-28 15:18:50', NULL, 0, NULL),
(4, 'محسن پشتیبان', '09136066306', 'mohsen@gmail.com', '$2y$10$YqADhs5Xb.cFbTpfkr.Ms.5ypHJCvYkNcFph5d9PXgF27DUsigSiy', '6834289937b43.jpg', NULL, NULL, '2025-05-18 14:56:20', '2025-05-26 08:38:49', NULL, 0, NULL),
(6, 'علی جهانی', '09645917461', 'a.jahani@example.org', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', NULL, '2025-05-18 15:42:59', 'J16t8RdutE', '2025-05-18 15:42:59', '2025-05-18 15:42:59', NULL, 0, NULL),
(7, 'یوسف یوسفی', '09097187376', 'yousefi@example.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', '68333b2c4178f.jpg', '2025-05-18 15:43:49', '4amZJTXjpZxyPH4DDbt47wRwW1IbeR8ml4IRFROQBgcJRWnDPNCC8PEzZBkH', '2025-05-18 15:43:49', '2025-05-25 15:45:48', NULL, 0, NULL),
(8, 'استاد مهناز مؤمنی', '09010210202', 'momeni@example.net', '$2y$10$RccyuAI1AGDTI8oU7N.ZPuX5TQwwm8DJtP0UEl5EgJzEG8oh5aKiq', NULL, '2025-05-18 15:44:07', 'kPMjFCCfYW', '2025-05-18 15:44:08', '2025-05-18 15:44:08', NULL, 0, NULL),
(9, 'شادان زهرایی', '09401479085', 'zahraee@example.net', '$2y$10$0HbRn2xYA7QAS301aa0LnessBP5z.SEylnK6DHu829dSzzd/Q.4Ji', NULL, '2025-05-18 15:44:09', 'U0AOXXzjHF', '2025-05-18 15:44:09', '2025-05-18 15:44:09', NULL, 0, NULL),
(10, 'رشید سعیدی', '09300022546', 'rashidi@example.net', '$2y$10$qTKQn4k.rfGJsQNDKVcRqu.widB7NItLr7F/z3j5qu9rT7DXf4SUa', NULL, '2025-05-18 15:44:10', 'hNyoO9aRrDjcmMfbp9utI59hYv5GeHLbg53si6BwcByyJB8MHj8Biqg0VZYU', '2025-05-18 15:44:11', '2026-08-21 17:48:39', '2026-08-21 17:48:39', 0, NULL),
(11, 'اکبر عظیمی', '09426896827', 'akbar.a@gmail.com', '$2y$10$amRlfJM1FfIoXY6aFexl4e3X5UQotNpZvYFUcSYI8RkBNiNmT6YFS', NULL, '2025-05-18 15:44:12', 'JoMU2UFmcj', '2025-05-18 15:44:12', '2025-05-18 15:44:12', NULL, 0, NULL),
(12, 'دکتر عادله رهنما', '09834667359', 'dr.rahnama@example.net', '$2y$10$UVh3z87clcdV4OaiGo9OhegXPtgghZpTS1T8ohU7XUwYDYbpAPQHm', NULL, '2025-05-18 15:44:13', 'UYaTEb2YNi', '2025-05-18 15:44:13', '2025-05-18 15:44:13', NULL, 0, NULL),
(13, 'مهندس یعقوب سپهریان', '09858808233', 'sepehrian@example.net', '$2y$10$OL1nrETH0ppXVgmMrEo4sOGrq3DGK/9gh7cvrhVbYjvGm/7q34QL2', NULL, '2025-05-18 15:44:14', 'd5JZQdSvRxmKItlCIY1tVyCBsEF5rNGjsK6lvWW7vP47tFQf3hYjzWX2joHW', '2025-05-18 15:44:15', '2025-05-19 14:15:47', NULL, 0, NULL),
(14, 'دکتر هیلدا عبادی', '09692875139', 'ebaadi@example.com', '$2y$10$AUl/LnXaHxJ5AzQz4cTMvew7RDWfThlWD6fuMm5hCtYtXFDh7yycu', NULL, '2025-05-18 15:44:16', 'pANBkP4Wdm', '2025-05-18 15:44:16', '2025-05-18 15:44:16', NULL, 0, NULL),
(15, 'نادر خراسانی', '09142594826', 'nader.khorasani@yahoo.com', '$2y$10$PQUnb5P/10QCGr71aoIBGudbo2VtiFghr3Qg4yr0/skomNaAytoRW', NULL, '2025-05-18 15:44:36', 'PBxOKwRUZy', '2025-05-18 15:44:36', '2025-05-18 15:44:36', NULL, 0, NULL),
(16, 'استاد پیام شجاعی', '09813239768', 'payam.shojaei@example.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', NULL, '2025-05-18 15:44:37', 'QF7Lh6lbiDfxUlcMnX4weXLtJi8GCT2cz9TbQxHfpbg0NRTsqRnkEJ1D4Dka', '2025-05-18 15:44:38', '2025-09-10 15:35:35', NULL, 0, NULL),
(17, 'احمد دهقان', '09954083574', 'dehghan_ahmad@example.org', '$2y$10$EJ.6MZUhGLrP/CSuERPIVu6nmZo/GLxKGX4jUwdlxol7bGdeV8HOG', NULL, '2025-05-18 15:44:39', 'i89kXrqrg7', '2025-05-18 15:44:39', '2025-05-18 15:44:39', NULL, 0, NULL),
(18, 'پریا میرزاده', '09626527563', 'paria_mirzadeh@example.net', '$2y$10$hk6Yuc1WvJGz8TCy1WN2f.6uWPGxE80Yu5tAV.IaPSoGDju2E9yyu', NULL, '2025-05-18 15:44:40', 'FPB3QYltXy', '2025-05-18 15:44:41', '2025-05-18 15:44:41', NULL, 0, NULL),
(19, 'سپیده رفیعی', '09463324325', 'rafiee@example.org', '$2y$10$MjNgdk/e1UdRWgg8npC9WeuTs0owIwHQ/Hp4c3AIaHCL9HRlnqQXO', NULL, '2025-05-18 15:44:42', 'ORcQqr1DJ1', '2025-05-18 15:44:42', '2025-05-18 15:44:42', NULL, 0, NULL),
(20, 'مجید درگاهی', '09213970449', 'majid@example.org', '$2y$10$C/Wx41kNqdLDrIVLW30zlePwCfXJ7OFhzMWgqSsjtMvkAYZhjNUji', NULL, '2025-05-18 15:44:43', 'cR4qb8pmNI', '2025-05-18 15:44:44', '2025-05-18 15:44:44', NULL, 0, NULL),
(21, 'توکا مجتبایی', '09848603366', 'tooka@example.org', '$2y$10$CY8GsgzKFZ5fa1X2x91lNOzcdxpuisI3FUkSSgEJwNWFWm0Ngq54G', NULL, '2025-05-18 15:44:45', 'h4Co40FRMh', '2025-05-18 15:44:45', '2025-05-18 15:44:45', NULL, 0, NULL),
(22, 'پرهام کاکاوند', '09667056015', 'parham@yahoo.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', '68341f15dbefd.jpg', '2025-05-18 15:44:46', 'zn6OgFjgJd4ke432bzLBwvY8BJnNTXkttm10c412EWN1Z1trPLDXQiFIsAcX', '2025-05-18 15:44:47', '2025-05-26 07:58:14', NULL, 0, NULL),
(23, 'کریم نوروزی', '09636487531', 'karim30@example.net', '$2y$10$payoqsYeJ4dgt1QSql1jh.XRwNifq2XE7l3yn6KUwwK3Nmts/0FA2', NULL, '2025-05-18 15:44:48', 'jrVG1tSUmR', '2025-05-18 15:44:48', '2025-05-18 15:44:48', NULL, 0, NULL),
(24, 'خسرو خسروی', '09420122890', 'khosravi@gmail.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', NULL, '2025-05-18 15:44:56', 'mDOBs3waLEP9RrvJAV8OZlI3QBY1p7DpeYYQsFfGVT5kjohsw1Db4ZBzYS9P', '2025-05-18 15:44:56', '2025-09-13 09:28:36', NULL, 0, NULL),
(25, 'مهتاب مدیریان', '09893247857', 'm.modiri@example.org', '$2y$10$7qwH6tcwo/GwNfUKPo4QzeR5BNfn1Iy/.K1G9s6y9XdvlMX3p0JR6', '68342a7cb7537.gif', '2025-05-18 15:44:57', '2IvoWfpLMXEWIwBDIA5KeKNXMnguxbOshYJQwMiOJrZtXavHafExbdItGiZk', '2025-05-18 15:44:57', '2025-05-26 08:46:52', NULL, 0, NULL),
(26, 'بهنام احمدی', '09825170889', 'behnam@example.net', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', NULL, '2025-05-18 15:44:59', 'tfQcOfHGGF', '2025-05-18 15:44:59', '2025-09-10 15:35:05', NULL, 0, NULL),
(27, 'مهبانو علی زاده', '09850795851', 'alizadeh@example.com', '$2y$10$bckD8.GgZ7aNrgUgp0aQNu4URyi3RoJYkq.J8A6cMSDX2fgHkVOL6', NULL, '2025-05-18 15:45:00', 'OzSFe6Nwck', '2025-05-18 15:45:00', '2025-05-18 15:45:00', NULL, 0, NULL),
(29, 'مهندس داریوش زندی', '09914332671', 'dariush.zandi@example.org', '$2y$10$U5mGl/Bc5AV9KvUN/7k9RuereU6ZJLG4vOdTqsc5mE6JPQdwEcmsK', NULL, '2025-05-18 15:45:03', 'ziAa0VCeoSMp5l2zqTPLk1u95S1TKdiWN3ZLAM3ZuVDb6VX8eTMbLDeoDzX2', '2025-05-18 15:45:03', '2025-08-27 07:32:03', NULL, 0, NULL),
(30, 'پرویز خمسه', '09713032423', 'parviz@yahoo.com', '$2y$10$HPOENt9Pbe0bzm258w0kEOSUznfswaqctWReamgtWPZIwtGJDTdu.', NULL, '2025-05-18 15:45:05', 'VkJsQrCvxw', '2025-05-18 15:45:05', '2025-05-18 15:45:05', NULL, 0, NULL),
(31, 'هوتن همت', '09816266528', 'hootan_hemat@gmail.com', '$2y$10$ofOhjr4lwjF4Lmk8nEt1TOR6ngCQfxCMpER8n4gnRxrampAVyW1fS', NULL, '2025-05-18 15:45:06', 'kdiI5tmubN', '2025-05-18 15:45:06', '2025-05-18 15:45:06', NULL, 0, NULL),
(32, 'سیمین رازی', '09147548180', 's.raazi@example.com', '$2y$10$CIfOUAGTeMvnbt674Fv8Y.hN0sGTL08mufjs28V9QlsnbNxXKbljS', NULL, '2025-05-18 15:45:07', '0FzIYGtF2y', '2025-05-18 15:45:07', '2025-06-14 10:14:49', NULL, 0, NULL),
(33, 'فرّخ حائری', '09525782478', 'haeri@example.com', '$2y$10$k3rEW0pMHFnRwmq.GWGvTOwhFoxGyr9YN5I/qM/saEoxbtEKUH7Oi', NULL, '2025-05-18 15:45:09', 'Au1ertCvbLCef2o9XDFFpg0UNqQhnaODcOT3RxvGzBcLXWIhGdoXL2o51483', '2025-05-18 15:45:09', '2025-08-27 07:31:45', NULL, 0, NULL),
(34, 'حمید کارگزار', '09123334444', 'hamid@yahoo.com', '$2y$10$Z9yT6HubAWeV6Z5d3eUWb.ubBI7Po2w5WFGVANOfuY0cp5KEEJ3OO', NULL, NULL, NULL, '2025-05-18 17:56:52', '2025-06-14 10:30:58', NULL, 0, NULL),
(50, 'ali zahedifar', '09931192849', 'alizahedifar1381@gmail.com', '$2y$10$8UZYf00QcBVrGWBLgsamz.qi/MrBjsFOSQ555VIlbvsRJ7NzqUIy6', '68d832a856359.jpg', NULL, '6RqeEVH7vUC18dWxjWMEXhXaHNI0RBHJ6FvZt3M2KtPNG9YOXWOZxW78g4cm', '2025-09-27 18:52:13', '2025-09-28 08:37:03', NULL, 0, NULL),
(51, 'مبینا میرشجاعان', '09023707118', 'missmirshojaan.2003@gmail.com', '$2y$10$PygKVKh6mrucusnad5zEKOMVtK6c.cMPEMM.IyILrQPZHqQ8pcYuS', NULL, NULL, NULL, '2025-10-01 09:38:52', '2025-10-01 09:38:52', NULL, 0, NULL),
(52, 'Amirparsa Sakibaee', '09300207926', 'apshakibaee1382@gmail.com', '$2y$10$ssRmJ5S0TLMKL5etflL6vOtcdO0A7Etf4GUcYl0xFzWrP05nCFN46', NULL, NULL, 'ie4neB3htwSP4GS55LCttAasovkSc21stuYkAbWDIDOkRW7JYJD0TlvajSGK', '2025-10-01 09:41:28', '2025-10-01 09:41:28', NULL, 0, NULL),
(53, 'امیررضا', '09364811757', 'amirrezazohourian01rez@gmail.com', '$2y$10$BkN8UozV/wEerH686QWcxeKQvIz75FcRe3Dd42/yHxWg8hwTseQw.', NULL, NULL, NULL, '2025-10-01 18:04:49', '2025-10-01 18:04:49', NULL, 0, NULL),
(54, 'یگانه شکیب', '09303490856', 'shakibyeganeh@gmail.com', '$2y$10$ezxFZvH3MB/IgsDmVwPELuzW0SLro2IKvUQ4N.WXISA3u1nVcN6ce', NULL, NULL, NULL, '2025-10-04 18:00:38', '2025-10-04 18:00:38', NULL, 0, NULL),
(55, 'asjd', '09353535351', 'sjkadlfasdg@asjdgsaug.dshafgugyf', '$2y$10$j3szb9KyAtDbwF6Npzfq/uK2Xm6z6CJntIPWZsfzX/RmvaOptKOU2', NULL, NULL, NULL, '2026-05-30 12:32:22', '2026-05-30 12:32:22', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_downloads`
--

DROP TABLE IF EXISTS `user_downloads`;
CREATE TABLE IF NOT EXISTS `user_downloads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `downloaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_downloads_user_id_foreign` (`user_id`),
  KEY `user_downloads_article_id_foreign` (`article_id`),
  KEY `user_downloads_order_id_foreign` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_downloads`
--

INSERT INTO `user_downloads` (`id`, `user_id`, `article_id`, `order_id`, `downloaded_at`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 1, '2026-07-31 10:13:29', '2026-07-31 10:10:32', '2026-07-31 10:13:29'),
(2, 6, 9, 2, NULL, '2026-07-31 10:50:01', '2026-07-31 10:50:01');

--
-- Constraints for dumped tables
--

ALTER TABLE `articles`
  ADD CONSTRAINT `articles_price_set_by_foreign` FOREIGN KEY (`price_set_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `article_topic`
  ADD CONSTRAINT `article_topic_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_topic_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

ALTER TABLE `assessment_requests`
  ADD CONSTRAINT `assessment_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `assessment_request_checklists`
  ADD CONSTRAINT `assessment_request_checklists_assessment_request_id_foreign` FOREIGN KEY (`assessment_request_id`) REFERENCES `assessment_requests` (`id`) ON DELETE CASCADE;

ALTER TABLE `category_news`
  ADD CONSTRAINT `category_news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `projects`
  ADD CONSTRAINT `projects_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_assessment_request_id_foreign` FOREIGN KEY (`assessment_request_id`) REFERENCES `assessment_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_primary_coach_id_foreign` FOREIGN KEY (`primary_coach_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_secondary_coach_id_foreign` FOREIGN KEY (`secondary_coach_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;