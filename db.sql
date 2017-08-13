-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2017 at 05:37 ညနေ
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+06:30";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediumy`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `author_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `reactions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `feature` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `reactions` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `hash`, `title`, `body`, `feature`, `user_id`, `created_at`, `modified_at`, `status`, `reactions`) VALUES
(1, '9025f11', 'Mediumy - မြန်မာဘာသာဆောင်းပါးများ', '<p>ကျွန်တော့်အနေနဲ့.. စာရေးရတာကို ဝါသနာပါတဲ့အတွက်ကြောင့် တစ်ချိန်တုံးက ဘလော့ဂ်တွေ ဘာတွေ ရေးဖြစ်ခဲ့ပါတယ်။ နောက်ပိုင်းတော့ ဆိုရှယ်မီဒီယာခေတ်ကိုပြောင်းသွားလို့ အများနည်းတူ ဖေ့စ်ဘုတ်ပေါ် ရောက်သွားပြီး ဆက်မရေးဖြစ်တော့ပါဘူး။ အရင်က ဘလော့ဂ်ပုံမှန်ရေးနေသူ အများစုလည်း ဒီလိုပဲ၊ ဖေ့စ်ဘုတ်ပေါ်ရောက်ကုန်ပြီး ဘလော့ဂ်တွေ မရေးကြတော့လို့ ဘလော့ဂ်ခေတ် ကုန်သွားပြီလို့တောင် ဆိုရမလို ဖြစ်သွားပါတယ်။ ဖေ့စ်ဘုတ်ပေါ်မှာကတော့ သိတဲ့အတိုင်းပဲ လေးလေးနက်နက် ရှည်ရှည်ဝေးဝေးထက် အတိုအစလေးတွေက ပိုများပါတယ်။</p><p>ဒါပေမယ့် အခုနောက်ပိုင်းမှာ <a href="https://medium.com/">Medium</a> ဆိုတဲ့နည်းပညာ အထူးထင်ရှားလာခြင်းနဲ့အတူ အရင်ဘလော့ခေတ်ကလို အရည်အသွေးမြင့် ဆောင်းပါးရှည်တွေ အတော်လေးပြန်တွေ့လာရပါတယ်။ ဘလော့ဂ်ခေတ်တုံးက အကြောင်းအရာကောင်းတွေဟာ Blogger လိုနေရာမျိုးကနေလာကြတာ များပြီး ကနေ့ခေတ်မှာတော့ Medium ကနေလာတာများပါတယ်။ အဲ့ဒါနဲ့ ကိုယ်လည်းပဲ Medium ပေါ်မှာ စာလေးဘာလေး ရေးမလား စိတ်ကူးမိတယ်။</p><div class="medium-insert-images"><div class="figure">\n    <img src="http://localhost/mediumy/media/post/a15c92ecda38237add44ecd43bf93f28.jpg" alt="" /><div class="figcaption">Beacon - One of the Opera Browser Wallpaper</div></div></div><p>တစ်ကယ်တမ်းရေးဖို့ကြိုးစားကြည့်တော့ အခက်အခဲတွေ တွေ့လာရတယ်။ Medium က ရိုးစင်း ရှင်းလင်းခြင်းကို အသားပေးတဲ့နေရာဆိုတော့ စာရေးတဲ့အခါ Option တွေ ရှုပ်ရှက်ခက်နေအောင် ရွေးဖို့ပေးမထားဘူး။ အကောင်းဆုံးဖြစ်မယ့် အနေအထားကို တစ််ခါတည်း အသင့်ရွေးပြီး ပေးထားတယ်။ ပေးထားတဲ့အတိုင်းပဲ သုံးရတယ်။ ဖွန့်တွေဘာတွေလည်း ရွေးလို့မရဘူး။ သတ်မှတ်ပေးထားတဲ့ဖွန့်ကိုပဲ သုံးရတယ်။ Medium ရဲ့ အိုင်ဒီယာက အင်္ဂလိပ်ဘာသာနဲ့ ရေးမယ့်သူတွေအတွက် ကောင်းပေမယ့် မြန်မာဘာသာနဲ့ ရေးဖို့အတွက်ကျတော့ အဆင်မပြေဘူး။ အသုံးပြုလိုတဲ့ မြန်မာဖွန့်ကို ရွေးလို့မရတော့ မြန်မာစာဖော်ပြပုံ မမှန်တော့ဘူး။</p><p>Medium ရဲ့ ဒီဇိုင်းနဲ့ လုပ်ဆောင်ချက်တွေကို အလွန်ကြိုက်ပေမယ့် ဒီလိုအခက်အခဲကဖြစ်လာတော့ အားမလိုအားမရဖြစ်မိတယ်။ အထူးသဖြင့်သူရဲ့ စာရေးတဲ့ Editor သိပ်မိုက်တယ်။ ဒါကြောင့် ကိုယ်တိုင် အဲ့ဒီလို Editor လေးတစ်ခု လုပ်ကြည့်ဦးမယ်လို့ စိတ်ကူးပေါက်ရာကနေ ဒီ Mediumy ကို စလုပ်ဖြစ်ခဲ့တာပါ။ အစကတော့ Editor လေးလောက်လုပ်ပြီး ကိုယ်ဟာကိုယ် သုံးမလိုပါပဲ။ နောက်တော့ Editor က အသင့်ရှိနေပြီး လုပ်စရာမလိုတော့တာနဲ့ မထူးဘူးဆိုပြီး လိုအပ်ချက်အစုံပါတဲ့ အွန်လိုင်းစာရေးစနစ် တစ်ခုထိဖြစ်အောက် ဆက်လုပ်ဖြစ်သွားတာပါ။</p><p>ဘယ်လိုနည်းပညာတွေသုံးပြီးလုပ်ဖြစ်ခဲ့တယ်ဆိုတာကို နောက်ဆောင်းပါးမှာ ဆက်လက်ဖော်ပြ ပေးပါမယ်။</p>', 'http://localhost/mediumy/media/post/a15c92ecda38237add44ecd43bf93f28.jpg', 1, '2017-08-13 21:20:14', '2017-08-13 22:01:04', 0, 0),
(2, 'bf84083', 'Mediumy - နည်းပညာပိုင်းဆိုင်ရာအကြောင်းအရာ', '<p><a href="http://medium.com/">Medium</a> ရဲ့ သိပ်မိုက်တဲ့ Editor ကိုနမူနာယူပြီး ကိုယ်တိုင်တစ်ခုလောက် လုပ်ကြည့်ဦးမယ်လို့ တွေးမိတဲ့အချိန်က <a href="https://facebook.github.io/react/">ReactJS</a> ကို လေ့လာနေတဲ့အချိန်ပါ။ ဒါကြောင့်မို့လို့ React နဲ့လက်ဆော့ချင်နေတာနဲ့ အတော်ပဲ ဆိုပြီး React Project တစ်ခုအနေနဲ့ အစပြုခဲ့တာပါ။</p><div class="medium-insert-images"><div class="figure">\n    <img src="http://localhost/mediumy/media/post/fee7377c20d6fa201731561527b0c0f3.jpg" alt="" /><div class="figcaption">Communicate - One of the Opera Browser Wallpaper</div></div></div><p>ဒါပေမယ့် နောက်တော့မှ <a href="https://yabwe.github.io/medium-editor/">MediumEditor</a> ဆိုတဲ့ အသင့်ရှိနေတဲ့ JavaScript Package တစ်ခုကို သွားတွေ့တယ်။ MediumEditor React ဆိုပြီး အဲ့ဒီ Package ကို React Component အနေနဲ့ သုံးလို့ရအောင် လုပ်ထားပေးတာလည်း ရှိပေမယ့် မူရင်းလောက် အဆင်မပြေဘူး။ အဲ့ဒီတော့ စဉ်းစားစရာဖြစ်လာတယ်။ မူလအစီအစဉ်အတိုင်း အလားတူတစ်ခု React နဲ့ ကိုယ့်ဟာကိုယ်လုပ်မလား၊ ရှိနေတဲ့ Package ကို သုံးမလား။ MediumEditor ရဲ့ ပြည့်စုံလှတဲ့ လုပ်ဆောင်ချက်တွေနဲ့ ဖြည့်စွက် Plugin တွေကို တွေ့မြင်ပြီး နောက်မှာတော့ ဒီလောက်ကောင်းတဲ့ဟာ သူပဲသုံးတော့မယ်လို့ ဆုံးဖြတ်ချက် ချလိုက်ပါတယ်။</p><p>အဲ့ဒီမှာထပ်တွေ့ရတာက MediumEditor Package မှာ ပုံတွေဘာတွေ ထည့်လို့ရတဲ့ လုပ်ဆောင်ချက် မပါပဲ၊ အဲ့ဒီလုပ်ဆောင်ချက်ရဖို့ <a href="http://linkesch.com/medium-editor-insert-plugin/">Medium Editor Insert Plugin</a> ဆိုတဲ့ Package နဲ့တွဲသုံးရတယ်။ Insert Plugin က jQuery ကိုအသုံးပြုထားတော့ အဲ့ဒီ Plugin ကို သုံးမယ်ဆိုရင် ကိုယ်ကလည်း <a href="http://jquery.com">jQuery</a> လိုက်သုံးမှ သဘာဝကျမယ်။ ပြဿနာတော့ မရှိဘူး။ ခေတ်နောက်ကျနေပြီလို့ ဆိုရမယ့် နည်းပညာဆိုပေမယ့် ကိုယ်တိုင်က jQuery ကို ကျွမ်းကျင်ပြီးသားမို့ လုပ်ရင်ဖြစ်နိုင်တာကို မြင်တဲ့အတွက် jQuery နဲ့ပဲ လိုအပ်နေတဲ့ လုပ်ဆောင်ချက်တွေကို ထပ်ဖြည့်ဖို့ ဆုံးဖြတ်ခဲ့ပြန်ပါတယ်။ Insert Plugin က Handlebars လို့ခေါ်တဲ့ Template Engine တစ်ခုကိုလည်း သုံးထားသေးတယ်။ ကိုယ့်သဘောအရဆို Ejs ကို ပိုကြိုက်ပေမယ့် စနစ်တစ်ခုထဲမှာ Engine နှစ်ခုဖြစ်နေမှာစိုးလို့ Handlebars ကိုပဲ Template လိုတဲ့နေရာတွေမှာ ဆက်သုံးထားပါတယ်။</p><div class="medium-insert-images"><div class="figure">\n    <img src="http://localhost/mediumy/media/post/f7652131e2bb326eebbc232009949f4f.jpg" alt="" /></div></div><p>အစပိုင်းမှာ ဆောင်းပါးလေးတွေ ရေးလို့ တင်လို့ရရင် တော်ပါပြီး၊ Comment မှတ်ချက်တွေ၊ Multi-user လုပ်ဆောင်ချက်တွေ ထည့်မနေတော့ပါဘူး တွေးပေမယ့် လုပ်ရင်းလုပ်ရင်းနဲ့ မထူးပါဘူးဆိုပြီး ထပ်ထပ် ထည့်လိုက်တော့ တစ်ဖြည်းဖြည်းနဲ့  Code Base က ကြီးလာတယ်။ ကောင်းတာက ဒီလိုအခြေအနေ ရောက်လာတဲ့အခါ BackboneJS လို M-V-C Framework တစ်ခုရဲ့ အကူအညီကို ယူရမှာ။ ဒီတော့မှ ပြုပြင်ထိမ်းသိမ်းရလွယ်မယ်။ ဒါပေမယ့် ကျစ်ကျစ်လစ်လစ် ရှင်းရှင်းလင်းလင်းဖြစ်ချင်တာနဲ့ သိပ်ကြီးကြီးကျယ်ကျယ်တွေ လုပ်မနေတော့ပဲ jQuery နဲ့ပဲ ကြိုးစားပြီး ပြုပြင်ထိမ်းသိမ်းရလွယ်အောင်၊ ရှင်းအောင် ရေးထားပါတယ်။ စာမျက်နှာတစ်ခုနဲ့တစ်ခုအကူး Routing လုပ်ဆောင်ချက်ကိုတော့ ကိုယ်တိုင်လုပ်မယ်ဆိုရင် စီမံရသိပ်ခက်သွားမှာစိုးလို့ <a href="http://sammyjs.org/">Sammy.js</a> ကို သုံးထားပါတယ်။</p><p>User Interface ပိုင်းကတော့ လုံးဝအစအဆုံး ကိုယ်တိုင်ပဲ Plain CSS နဲ့ ရေးထားပါတယ်။ Medium ရဲ့ လုပ်ဆောင်ချက်တွေကို ထပ်တူပြုယူတဲ့အခါ အသေးစိတ် အနုစိတ်ကအစ လိုက်သတ်မှတ်ရမှာမို့ ဒီနေရာမှာ Bootstrap တို့ဘာတို့လို Framework တွေနဲ့ သိပ်အဆင်မပြေတော့ဘူး။ မိုဘိုင်းဖုန်းတွေနဲ့ အဆင်ပြေစေဖို့ Responsive Web Design ဖြစ်အောင်လည်း ကိုယ်တိုင်ပဲ ရေးသားထားပါတယ်။</p><p> Back-end API အတွက်လည်း Pure PHP နဲ့ပဲ ရေးထားပါတယ်။ jQuery ကို အဓိကအားပြုပြီး ရေးထားတဲ့စနစ်ဆိုတော့ Back-end ပိုင်းလုပ်ဆောင်ချက် သိပ်အများကြီး မရှိပါဘူး။ ဒေတာသိမ်းပေးယုံလောက် ဆိုတော့ Framework တွေဘာတွေ လုပ်မနေတော့ပဲ ကိုယ်တိုင်အစအဆုံးပဲ ရေးလိုက်တာပါ။ ဒီတော့ ကောင်းတာရှိသလို ဆိုးတာလည်း ရှိပါတယ်။ ကောင်းတာကတော့ အပိုအလိုမပါတော့ အလွန်ပေါ့ပါး လျင်မြန်ပါတယ်။ ဆိုးတာကတော့ Framework တွေကို ကြေညက်အောင် စမ်းထားပြီးသား မဟုတ်တော့ မျှော်မှန်းမထားတဲ့ အမှားတွေ အစပိုင်းမှာ နည်းနည်း များနိုင်ပါတယ်။</p><p>ဒါကြောင့် ဝိုင်းစမ်းပေးကြမယ်ဆိုရင် ကျေးဇူးတင်မိမှာပါပဲ။ <a href="https://github.com/eimg/mediumy">Github</a> မှာ Source Code တင်ထားပေးလို့ ဒေါင်းပြီးစမ်းလို့လည်း ရပါတယ်။ ဒီမှာ အကောင့်ဆောက်ပြီး စမ်းလို့လည်း ရပါတယ်။ အမှားတွေ တွေ့မိတဲ့အခါ Github Issue မှာလာထည့်ပြီး ဆွေးနွေးလို့ရပါတယ်။</p>', 'http://localhost/mediumy/media/post/fee7377c20d6fa201731561527b0c0f3.jpg', 1, '2017-08-13 21:46:17', '2017-08-13 21:46:17', 0, 0),
(3, '449914f', 'Mediumy - ပါဝင်သည့်လုပ်ဆောင်ချက်များ', '<div class="medium-insert-images"><div class="figure">\n    <img src="http://localhost/mediumy/media/post/bef889b3b613fb94994cb5c8048f5840.jpg" alt="" /></div></div><p>လောလောဆယ်မှာ ပါဝင်တဲ့လုပ်ဆောင်ချက်တွေကတော့ အများကြီးမဟုတ်သေးပါဘူး -</p><ul><li>အကောင့်ဆောက်လို့ရပါတယ်၊ မလိုအပ်ရင် ဒီလုပ်ဆောင်ချက်ကို ပိတ်ထားလို့လည်းရပါတယ်။</li><li>လော့ဂ်အင်ဝင်ပြီးနောက် ကိုယ်ရေးအကျဉ်းထည့်လို့ရပါတယ်။ Profile Photo ထည့်လို့ရပါတယ်။</li><li>ပက်စ်ဝပ်ပြင်လို့ရပါတယ်။ ဒါပေမယ့် Forgot Password လုပ်ဆောင်ချက် မပါသေးပါဘူး။</li><li>ပို့စ်စာရင်းကို အကုန်ကြည့်လို့ရသလို Search လုပ်ဆောင်ချက်နဲ့ ရှာကြည့်လို့လဲ ရပါတယ်။</li><li>Paging လုပ်ဆောင်ချက် ထည့်မထားပါဘူး။ ပို့စ်စာရင်းအတွက် Continues Loading လိုလုပ်ဆောင်ချက်မျိုးထည့်ဖို့ ရည်ရွယ်ထားပေမယ့် မပါသေးပါဘူး။</li><li>ပို့စ်အသစ်တွေတင်တဲ့လုပ်ဆောင်ချက်နဲ့ တင်ထားတဲ့ပို့စ်တွေကို ပြင်တဲ့လုပ်ဆောင်ချက်ကို ကွဲပြားခြင်းမရှိ အမြင်အတိုင်း အရှိအတိုင်း ရေးသားနိုင်အောင် ပြင်ဆင်နိုင်အောင် စီစဉ်ထားပါတယ်။ စမ်းကြည့်ပါ၊ အမှားတစ်ချို့ ရှိနေသေးပေမယ့် ကြိုက်သွားမှာပါ။</li><li>ပို့စ်တွေရေးတဲ့အခါ အခြေခံ Formatting လုပ်ဆောင်ချက်တွေအပြင် လင့်တွေ ပုံတွေလည်း ထည့်လို့ရပါတယ်။ Section ထည့်လို့ရအောင် ဆက်လုပ်နေပါတယ်။</li><li>ဗွီဒီယိုအပါအဝင် မီဒီယာ Embed လုပ်ဆောင်ချက်ပါဝင်ပေမယ့် မကြိုက်သေးပါဘူး။ ပြင်ဦးမှာပါ။</li><li>ပုံတွေကိုဖော်ပြတဲ့အခါ ချက်ခြင်းမပြပဲ လိုအပ်မှယူပြတဲ့ Lazy Loading လုပ်ဆောင်ချက် မပါသေးပါဘူး။ ထပ်ထည့်မှာပါ။</li><li>ပို့စ်ရဲ့ပထမဆုံးပုံကို ရွေးပြီး Feature Image အဖြစ် အလိုအလျှောက် သတ်မှတ်ပေးပါတယ်။</li><li>မှတ်ချက်တွေပေးလို့ရသလို၊ ပို့စ်တွေကို Favorite လည်းလုပ်ပေးလို့ ရပါတယ်။<br /></li><li>Draft နဲ့ Autosave လုပ်ဆောင်ချက် မပါသေးပါဘူး။ ဦးစားပေးအနေနဲ့ ထပ်ထည့်ဖို့ ရည်ရွယ်ထားပါတယ်။</li></ul><p>အကြံပြုချင်တာရှိရင် ကျွန်တော့် အီးလ်မေးလိပ်စာ eimg@fairwayweb.com ကို ဆက်သွယ် အကြံပြုနိုင်ပါတယ်။</p>', 'http://localhost/mediumy/media/post/bef889b3b613fb94994cb5c8048f5840.jpg', 1, '2017-08-13 21:57:53', '2017-08-13 22:00:41', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `author`, `email`, `description`, `password`, `created_at`, `photo`, `token`) VALUES
(1, 'အိမောင်', 'eimg@fairwayweb.com', 'Fairway Technology ၏ မန်နေဂျင်းပါတနာ၊ Professional Web Developer စာအုပ်၏ စာရေးသူ', '$2y$10$BXbnuG1V/MbkVLfPw3.bnuZ/qNMJAVP0pC/RfWxkqjpHR2a7m87lS', '2017-08-13 20:41:03', '7c1cc68bd768c869658946f21ae1065f.jpg', '$2y$10$KKOW/xrjeSEslrCDHbIJbev/JEcI/435lyOj0AIztaRQEEgKEY1MO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
