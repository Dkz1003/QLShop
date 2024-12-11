-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th5 09, 2024 lúc 11:55 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlda`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `AdUserName` varchar(30) NOT NULL,
  `AdPassWord` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`AdUserName`, `AdPassWord`) VALUES
('admin1', '123'),
('admin2', '123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authors`
--

CREATE TABLE `authors` (
  `AuID` int(11) NOT NULL,
  `AuName` text NOT NULL,
  `AuDes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `authors`
--

INSERT INTO `authors` (`AuID`, `AuName`, `AuDes`) VALUES
(1, 'Tác giả A', 'Mô tả về tác giả A, đẹp trai, nhà giàu'),
(2, 'Tác giả BaBa', 'Mô tả về tác giả B, đẹp trai nhưng nhà nghèo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `CateID` int(11) NOT NULL,
  `CateName` tinytext NOT NULL,
  `CateStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`CateID`, `CateName`, `CateStatus`) VALUES
(1, 'Thể loại ABC', 1),
(2, 'Thể loại B', 1),
(14, 'Thể loại 1123', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter`
--

CREATE TABLE `chapter` (
  `ChapID` int(11) NOT NULL,
  `ChapName` text NOT NULL,
  `ChapStatus` tinyint(4) NOT NULL,
  `ChapView` int(11) NOT NULL,
  `ChapContend` text NOT NULL,
  `ChapDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `StoryID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chapter`
--

INSERT INTO `chapter` (`ChapID`, `ChapName`, `ChapStatus`, `ChapView`, `ChapContend`, `ChapDate`, `StoryID`) VALUES
(0, 'Chương 1', 1, 1000, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-04-26 03:26:24', 2),
(1, 'Chương 2', 1, 100, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-04-26 03:56:11', 2),
(2, 'Chương 3', 1, 123, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-04-26 03:56:16', 2),
(3, 'Chương 1', 1, 300, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:08:27', 3),
(4, 'Chương 2', 1, 200, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:08:32', 3),
(5, 'Chương 3', 1, 100, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:08:37', 3),
(6, 'Chương 4', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 2),
(9, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 1),
(10, 'Chương 3', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 1),
(11, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 4),
(12, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 4),
(13, 'Chương 3', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 4),
(14, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 5),
(15, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 5),
(16, 'Chương 3', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 5),
(17, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 6),
(18, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 6),
(19, 'Chương 3', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 6),
(20, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 7),
(21, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 7),
(22, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 8),
(23, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 8),
(24, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 9),
(25, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 9),
(26, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 10),
(27, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 06:04:49', 11),
(28, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 11),
(29, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 12),
(30, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 13),
(31, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 14),
(32, 'Chương 1', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 15),
(33, 'Chương 2', 1, 1, '[\"1.jpg\",\"2.jpg\",\"3.jpg\",\"4.jpg\",\"5.jpg\"]', '2024-05-09 07:57:56', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `ComID` int(11) NOT NULL,
  `ComDate` datetime NOT NULL DEFAULT current_timestamp(),
  `ComContent` text NOT NULL,
  `StoryID` int(11) DEFAULT NULL,
  `MemID` int(11) DEFAULT NULL,
  `ComStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`ComID`, `ComDate`, `ComContent`, `StoryID`, `MemID`, `ComStatus`) VALUES
(1, '2024-04-03 11:00:00', 'main quá bá', 1, 1, 1),
(2, '2024-04-03 11:15:00', 'main quá ngu', 1, 2, 1),
(4, '2024-05-02 15:57:49', '123', 8, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `member`
--

CREATE TABLE `member` (
  `MemID` int(11) NOT NULL,
  `MemName` tinytext NOT NULL,
  `MemPassword` varchar(32) NOT NULL,
  `MemEmail` varchar(30) NOT NULL,
  `MemStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `member`
--

INSERT INTO `member` (`MemID`, `MemName`, `MemPassword`, `MemEmail`, `MemStatus`) VALUES
(1, 'Duy K', '123', 'hehehe', -1),
(2, 'Nam', 'hahaha', '123', -1),
(3, 'Hương', '123', 'huong@gmail.com', -1),
(4, 'Hương', '123', 'huong@gmail.com', 1),
(5, 'Nam', '123', 'nam@gmail.com', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `report`
--

CREATE TABLE `report` (
  `ReID` int(11) NOT NULL,
  `ChapID` int(11) NOT NULL,
  `Message` text NOT NULL,
  `ReDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `report`
--

INSERT INTO `report` (`ReID`, `ChapID`, `Message`, `ReDate`) VALUES
(1, 0, '123', '2024-05-09 09:07:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stories`
--

CREATE TABLE `stories` (
  `StoryID` int(11) NOT NULL,
  `StoryName` text NOT NULL,
  `StoryDes` text NOT NULL,
  `StoryImage` text NOT NULL,
  `StoryView` int(11) NOT NULL,
  `StoryStatus` tinyint(4) NOT NULL,
  `StoryDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CateID` int(11) DEFAULT NULL,
  `AuID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `stories`
--

INSERT INTO `stories` (`StoryID`, `StoryName`, `StoryDes`, `StoryImage`, `StoryView`, `StoryStatus`, `StoryDate`, `CateID`, `AuID`) VALUES
(1, 'Chuyển sinh thành smile', 'Câu chuyện bắt đầu với anh chàng Mikami Satoru, một nhân viên 37 tuổi sống cuộc sống chán chường và không vui vẻ gì. Trong một lần gặp cướp, anh đã bị mất mạng. Tưởng chừng cuộc sống chán ngắt ấy đã kết thúc... Nhưng không! Ấy lại chính là sự khởi đầu của một cuộc sống mới. Mikami thức dậy, thấy mình đang ở trong một thế giới kì lạ. Và điều quái dị là anh không còn hình dạng con người nữa mà đã trở thành quái vật Slime dẻo quẹo và không có mắt. Khi dần quen với hình dáng mới này, anh bắt đầu khám phá thế giới mới với cái tên Rimuru Tempest, cùng với những quái vật khác xây dựng quốc gia riêng và bắt đầu công cuộc thay đổi thế giới mới.', '00001.jpg', 1000, 1, '2024-04-08 16:40:21', 1, 1),
(2, 'Hảo vị hầm ngục', 'Sau khi em gái bị nuốt bởi một con rồng và mất tất cả các nguồn cung cấp trong một cuộc đột kích dungeon thất bại, Laois và nhóm của mình quyết tâm cứu em gái mình trước khi cô bị tiêu hóa. Hoàn toàn bị phá sản và phải ăn những con quái vật làm thức ăn, họ gặp một người lùn sẽ giới thiệu họ đến với thế giới của dungeon meshi – món ăn được làm từ các thành phần như thịt của con dơi khổng lồ, nấm biết đi, thậm chí là những củ sâm biết nói…', '00002.jpg', 2000, 1, '2024-05-09 07:51:42', 2, 2),
(3, 'One Piece', 'Mô tả về truyện 1', '00003.jpg', 1000, 1, '2024-05-09 05:59:40', 1, 1),
(4, 'Solo Leveling', '123', '00004.jpg', 0, 1, '2024-04-08 16:39:04', 1, 1),
(5, 'Naruto', 'def', '00005.jpg', 0, 1, '2024-04-08 16:53:28', 1, 1),
(6, 'Jujutsu Kaisen', '123', '00006.jpg', 1, 1, '2024-04-08 16:46:03', 14, 1),
(7, 'Bách luyện thành thần', 'Cảnh giới: Luyện nhục cảnh, Luyện cốt cảnh, Luyện tạng cảnh....\r\nLa Chính vì gái mà bị đày làm nô bộc. La Bái Nhiên tham vọng đầy mình :))\r\nLa Chính lại vì gái mà đâm đầu tu luyện :))\r\nLa Gia trong phủ nước sôi lửa bỏng, tranh giành kịch liệt... thôi thì đọc tiếp sẽ biết :)\r\n1 thanh niên dại gái tu luyện võ công =))', 'bach-luyen-thanh-than.jpg', 10000, 1, '2024-04-27 12:04:39', 1, 1),
(8, 'Chung cực đấu la', 'Câu chuyện này là phần 4 nối tiếp với chuỗi câu chuyện trong tác phẩm Đấu La Đại Lục của tác giả\r\nNội dung truyện được diễn ra sau một vạn năm, khi đó mọi thứ đều bị băng hóa.\r\nMở đầu là việc đội khảo sát khoa học của Liên bang Đấu La trong lúc khảo thí ở Cực Bắc Chi Địa đã phát hiện một quả trứng có hoa văn hai màu vàng bạc, sau khi dùng dụng cụ kiểm tra thì phát hiện bên trong có sinh mạng đang phát triển nên đã nhanh chóng mang về sở nghiên cứu tiến hành ấp trứng. Sau khi trứng nở ra thì không ngờ lại nở ra một đứa trẻ không khác gì trẻ con loài người, một quả trứng nở ra trẻ con.', 'chung-cuc-dau-la.jpg', 10000, 1, '2024-04-27 12:24:19', 1, 2),
(9, 'Tân tinh tái thế', 'COMING SOON!!!\r\nHành trình từ một phàm nhân và trở thành thực thể sáng ngang với các vị thần, \"Twilight of gods\" -  Hoàng hôn của chư thần.\r\nSau khi truyền bá danh xưng của mình như một ác thần. Anh ta đã mất tất cả, từ ngai vàng, đức tin cho tới địa vị.... Thần tính của anh ta bị đứt gãy và quyền năng của thần cũng biến mất.\r\n\"Ta muốn ngươi đồng hành cùng ta.\" Thanatos, người cai quản Địa Ngục, đã giúp đỡ một người như vậy…\r\n‘Hoàng hôn của chư thần’ đã nhận lấy sự giúp đỡ của vị thần ấy và tái thế dưới thân phận là \'Lee Chang-Son\'. Để bóp nát cổ của các vị thần đã đẩy anh ta xuống vực thẳm!\r\n\"Ta thực sự đã trở lại.\"', 'tan-tinh-tai-the.jpg', 10000, 1, '2024-04-27 12:25:28', 2, 2),
(10, 'Thăng cấp cùng thần', '123213', 'thang-cap-cung-than.jpg', 10000, 1, '2024-04-27 12:38:33', 1, 2),
(11, 'Người chơi không thể thăng cấp', 'Không thăng cấp', 'nguoi-choi-khong-the-thang-cap.jpg', 10000, 1, '2024-04-27 12:39:14', 1, 1),
(12, 'real', 'real', 'real.jpg', 10000, 1, '2024-04-27 12:39:46', 14, 1),
(13, 'Đại chu tiên lại', 'dai-chu-tien-lai', 'dai-chu-tien-lai.jpg', 10000, 1, '2024-04-27 12:40:23', 14, 2),
(14, 'Sao Lại Ám Ảnh Cô Vợ Giả Mạo Quá Vậy?', 'Sao Lại Ám Ảnh Cô Vợ Giả Mạo Quá Vậy?', 'sao-lai-am-anh-co-vo-gia-mao-qua-vay.jpg', 10000, 1, '2024-04-27 12:52:44', 14, 1),
(15, 'Thực ra tôi mới là thật', 'Để có được tình yêu thương của cha , Keira đã làm mọi thứ để sống một cuộc sống hoàn hảo , ngoan ngoãn . Nhưng một ngày , Cosette Xuất hiện , nhận là đứa con gái thật sự của ông và Keirg bị kết tội giả mạo. Vào những giây phút Cuối cùng của cuộc đời cô , Cosette thì thầm với Keirg : Thực ra , người mới là thật . Keira , nhớ lại lời nói đó , trọng sinh về quá khứ . Mặc dù trở thù quan trọng , nhưng còn vấn đề gì thật giả giả thì sao ? Giờ , khi đã được ban cho một cuộc sống mới , tôi sẽ sống thật tự do !', 'thuc-ra-toi-moi-la-that.jpg', 10000, 1, '2024-04-28 07:07:56', 14, 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdUserName`);

--
-- Chỉ mục cho bảng `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`AuID`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CateID`);

--
-- Chỉ mục cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`ChapID`),
  ADD KEY `chapter_ibfk_1` (`StoryID`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ComID`),
  ADD KEY `ID` (`StoryID`),
  ADD KEY `MemID` (`MemID`);

--
-- Chỉ mục cho bảng `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`MemID`);

--
-- Chỉ mục cho bảng `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReID`),
  ADD KEY `report_ibfk_1` (`ChapID`);

--
-- Chỉ mục cho bảng `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`StoryID`),
  ADD KEY `stories_ibfk_1` (`CateID`),
  ADD KEY `stories_ibfk_2` (`AuID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `CateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `ComID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `member`
--
ALTER TABLE `member`
  MODIFY `MemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `report`
--
ALTER TABLE `report`
  MODIFY `ReID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `stories`
--
ALTER TABLE `stories`
  MODIFY `StoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`StoryID`) REFERENCES `stories` (`StoryID`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`StoryID`) REFERENCES `stories` (`StoryID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`MemID`) REFERENCES `member` (`MemID`);

--
-- Các ràng buộc cho bảng `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`ChapID`) REFERENCES `chapter` (`ChapID`);

--
-- Các ràng buộc cho bảng `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`CateID`) REFERENCES `categories` (`CateID`),
  ADD CONSTRAINT `stories_ibfk_2` FOREIGN KEY (`AuID`) REFERENCES `authors` (`AuID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
