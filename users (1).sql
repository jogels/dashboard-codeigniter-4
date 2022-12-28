-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2022 at 12:45 PM
-- Server version: 10.3.34-MariaDB-cll-lve
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webopsid_webops_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role_id`) VALUES
(1, 'marisa', 'zaharamarisa@gmail.com', '$2y$10$SQ32.tRnp61UbCKTTwJT1uYoapYxMA76GnzGuMpmcYaHh98X8m1UK', 1),
(2, 'slamet.supriyanto', 'slamet.supriyanto@ipsos.com', '$2y$10$kJvWtrT4PJGj.WPkxht2M.DRdVJ59AmigUTp.xdEGGy1Pv64gfhri', 1),
(3, 'andi sukma', 'andi.sukma@ipsos.com', '$2y$10$7fNYCXxgla7PNOazzbP0T.u9fN/9bYna.cQ2wRP0trUl9biXZpxBi', 1),
(4, 'bayuandikaramadhana', 'bayu.ramadhana@ipsos.com', '$2y$10$JOoCjC5dnZpx2tn/38sYOuTWCjddySfFiZNdErhoID8KDvD0KXxoq', 0),
(5, 'Slamet', 'slamet.supriyanto@ipsos.com', '$2y$10$OB4VOqgbvMlwHK9hdh9E9eQCNqfZl/OSQUMyNNnd5Ayz8FcSQOHk2', 1),
(6, 'rafitrird', 'rafitri.dewi@ipsos.com', '$2y$10$QZ82QlGn2GIpWkoGq.Gsge031rYi71XdwCcaTFsot/bsISDBiFx1q', 0),
(7, 'Diana', 'diana.nurvitasari@ipsos.com', '$2y$10$kR6fsGB2gGFSwJOTWYYy0.g1NDei8p4j2Iyg4T8/qAWj96GW/JKJW', 0),
(19, 'RDP', 'risanthi.purnamasari@ipsos.com', '$2y$10$ZKXVNAtRFgGe6s4J2GU1huHQyeZoim.SPH/g0eJmyrx/Ml0S6bhA6', 0),
(20, 'Palguno', 'palguno.gijono@ipsos.com', '$2y$10$GsObw90pAujzAwLqckP4ZeS9cZPrEyBoMPIf8kMe8OqginRc1nf1u', 0),
(22, 'Heni.Nurkhayati', 'Heni.Nurkhayati@ipsos.com', '$2y$10$Q.tqM00qZkh9qmpeWriTQu4mbrL0YrhKxaExdYD3R5HLreBzGGzrS', 0),
(23, 'pmt.beranda', 'id-pmt-quant-beranda@ipsos.com', '$2y$10$ns7Q6qIpghCpUl4lT2z/SeCEux7KVcNKGhMusxXvkA6ePUTsXXgHa', 0),
(27, 'Rahmawati Marufa', 'rahmawati.marufa@ipsos.com', '$2y$10$6eFPX5LlIroHy/6gYFZsMeUhZOngk3Yx/oMGDcw5jLxYBvZK11aFS', 1),
(28, 'Susan', 'Louisiana.Susan@ipsos.com', '$2y$10$LvjvTkTI2.jhN1XHMlN.su1b7aurXNSiJgKHqwXYdycWHCplxsGXC', 1),
(30, 'endang.kartiningsih', 'endang.kartiningsih@ipsos.com', '$2y$10$dFZkp6X.RjD07esZRaQeV.WRXVQlN5vZpd7uTa.YZY4myanzLW3Ry', 1),
(33, 'okky.hendrawan', 'okky.hendrawan@ffi-group.co.id', '$2y$10$k14SGwYn2XColHv397rIfeQyMHxZoLqWpOJ1vQBJdaoTh6X7YHWFK', 0),
(34, 'Cicilia Sri Mulyaningsih', 'Sri.Mulyaningsih@ipsos.com', '$2y$10$t3ebhXu6zE92UMKLGY0RLOOWD.JYII8xnOUOLMHk7moTFYMsRFiBa', 1),
(35, 'wibisono', 'wibisono.suwito@ipsos.com', '$2y$10$QsjpXWT11SlWbt/8ZdduXuNM5nBzuUT3VaBe27J3vb4N5ytt2nk8y', 1),
(37, 'Tati.Sugiharti', 'Tati.Sugiharti@ipsos.com', '$2y$10$2q7oze48cftQnjsDw269mu61tIjY7l1.9yf2U7fbZoyUqfZufKdy.', 0),
(38, 'innasa.shinta', 'innasa.shinta@ipsos.com', '$2y$10$8hLyYG8/ShmCsaJSypTn9OSENY5Hm.VTcahXIzasSFG6KlKeWRcXe', 0),
(39, 'Anggita', 'anggita.savitri@ipsos.com', '$2y$10$IpCFTwBmvbOLjYi7zhe1BeyE8nPtaT40ROJy5gUMRMUSqzHXV2/PO', 1),
(47, 'Salamatuttanzil', 'Salamatuttanzil.Salamatuttanzil@ipsos.com', '$2y$10$ysbKMk.c8q3eiXxs4.tHmesW4yh9ACxgYL3bRw./4tae/6X0XWFJu', 0),
(48, 'prayuda', 'prayuda.alhakim@ipsos.com', '$2y$10$Ogz.qBeQCkoyR1zCfikO9.WpNoR3YqmX2zPekeFhP/3SrjGNhAxaO', 0),
(49, 'Astridikka', 'astrid.ikka@ipsos.com', '$2y$10$52nezOxnsnZzEx6dHJdg/eOfqLbC0cAwwEsBINvq8fEvY3Xopm4lW', 0),
(50, 'Andi Sukma', 'andi.sukma@ipsos.com', '$2y$10$AV9Vl2scCfjglxAieEGQlOm2qLEvMUeJOb8XmyPIcfg8WWHnpzRE2', 1),
(51, 'danaranad', 'danar.ajiwicaksono@ipsos.com', '$2y$10$Nvg7Xpl..Vzl69Ikfss0ZOVaXw.3J4WcGkaecxGBxJv5QvLFAe1Am', 0),
(62, 'siti.afraghassani', 'siti.afraghassani@ipsos.com', '$2y$10$cG4Fn5mSJkEuz8AvvQZXVOP1kaacYiZUQBVOfiPkcyG4pw79xxO2i', 0),
(64, 'Sukarma', 'sukarma.abad@ipsos.com', '$2y$10$aNvW7b4LU4XwhNQCSstQI.VhkH2Z2m0i0fJPicRoDxLErpikr4tHC', 1),
(67, 'DinaLee', 'dina.lee@ffi-group.co.id', '$2y$10$N8hFFVeFlfebi5qUJ3JAJuM6lszFrrvq2y3qAdPe8uqz5lsxJ2ECe', 0),
(68, 'Muh Yusuf', 'muh.yusuf@ipsos.com', '$2y$10$x23MPJTRfZaQGZDv4x/9Qu6DMbL1FhBvrPEAGUTtFRVEtbofScCUu', 1),
(70, 'Wiwit Siestia', 'wiwit.siestianingtias@ffi-group.co.id', '$2y$10$56dzRVY0UIf4MijD7SipMeKy9Px9CQA1ndMNKRHu1K5IUeT0qSPbe', 0),
(71, 'riza.firdani', 'riza.firdani@ipsos.com', '$2y$10$4sh.qj6T9XicYdaxc1tap.Tf6GmQwYp17WCN5PK.Bi9vReWcxLhmS', 1),
(72, 'rani.nurwita', 'Rani.Nurwita@ipsos.com', '$2y$10$ZOV/HrlcADcpIIu5crcTVeQ95MFbclB9.UB5SZPconFc9mZbhv/6O', 1),
(73, 'rachel', 'Rachel.Irene@ipsos.com', '$2y$10$W3z9tI.D4PZgG8L2Z7hO9eTULhRsQ/emm4r01g84SAiicEB1zS8RG', 1),
(74, 'a.rifai', 'Ahmad.Rifai@ipsos.com', '$2y$10$X0NF5t4egqUUIO3Hg1n9oOj//.7boU3RIg3.hTfL3wvULzUAH5sS2', 1),
(75, 'Slamet.supriyanto', 'slamet.supriyanto@ipsos.com', '$2y$10$4Qtz5jcf8qI5BjfoLma8fOn.JoEIvfJNVRdSf3Sz2.6xBKRETowRG', 1),
(76, 'angga.widagdo', 'angga.widagdo@ffi-group.co.id', '$2y$10$I5MZmSWBb6U5qeJtekZkYOo9CIwMf7IMO48b4VRFJ4n6DKU9YXZnO', 0),
(77, 'rahmi rahmawati', 'rahmi.rahmawati@ipsos.com', '$2y$10$iDzbOkIi1Ifcr.IX1xrjjOF28vmXoxH1ZhozaZCoNpVsGUfoI79oS', 1),
(78, 'Herdy adriana', 'Herdy.adriana@ipsos.com', '$2y$10$9oI3VduDWzGdS/bT6JkFn.6D74k/viawMBZkNqtG4UKHSv7vfMF2O', 0),
(79, 'farhanhaqqfh', 'farhan-firyan@ffi-group.co.id', '$2y$10$XxnqTnCYJrbFNZ4zF5wfueiCZiSZjG7GAD1smVwmBd5G.9GxQYf6.', 0),
(80, 'muh.yusuf', 'muh.yusuf@ipsos.com', '$2y$10$vVc2QxTPsrTcL.ZYLCiP4unSocuoKl.yQtpMi/UVW97U0IGwmvKmG', 1),
(81, 'Ummu.kalsum', 'ummu.kalsum@ipsos.com', '$2y$10$MqCnsmHKW6RyjRDHY7YoMOgIDa1ltXQBMUyYTT0cOk6z0VpvgQ8ue', 1),
(83, 'Abe Rahadian', 'dian.rahadian@ipsos.com', '$2y$10$Tq4c.EkGCgrRKda8HY65dOJtYPku0/OBH0gAQwC4CcVezl6QVQjH6', 0),
(84, 'nenden', 'nenden.rahmawati@ffi-group.co.id', '$2y$10$KxO8N7WoPOddfdTqUuOsU.4vbBzpg8I2IAaT6KzPXmteXEHfA70gS', 0),
(85, 'delpero', 'Delpero@ffi-group.co.id', '$2y$10$5pRQu7ZFrE8xKwQTTbYwKeJf8JXAokdUNKyT2hF/mgiLoqrX9i0qG', 0),
(86, 'soehartyoso', 'soehartyoso@ffi-group.co.id', '$2y$10$2gE9Wwexd4aK8F9az.qld.gKkMT4xngqq3MLATmtmu3xwvxGpmxYC', 1),
(88, 'fitri.oktavia', 'fitri.oktavia@ipsos.com', '$2y$10$I4Hf0t9bp/RD4fPFTPQYaeAjumATDbn8pKH2kL32qWVpRCPMi.9XG', 0),
(89, 'pmt.rubicon', 'id-pmt-quant-beranda@ipsos.com', '$2y$10$n8qkSJOjkuaWGG8mHSsFQubef5oRzg3mg2tmWkrr0MCt6PDurN.A6', 0),
(90, 'Adriana Sharadhea', 'adriana.sharadhea@ipsos.com', '$2y$10$YIPJYim6XuN0bZH.u8THJuaqqEeX7hwsp31nH5WTD7ZaN0MgjnqRW', 0),
(92, 'ID-PMT-QUANT', 'id-pmt-quant@ipsos.com', '$2y$10$I0Cqbo0ncjX6t4Cu9gc2J.Uc6rWGmWGH1y1EggTcVLiX2V5dpLIbm', 1),
(93, 'Zaenudin', 'Zaenudin.misar@ipsos.com', '$2y$10$l6c66m/Yx.xOBK1YTWaVjevYOMbKqDu/uGBc1ME0XqMGOvSa4Q/US', 0),
(94, 'rdarmawan', 'raditya.darmawan@ipsos.com', '$2y$10$eAui/PE3JRn6HXZVG2j/N.EmY25Btuvjo5BnnbdUAOB1ug1lIdvWa', 0),
(95, 'Nadia', 'nadia.prameswary@ipsos.com', '$2y$10$mpx9bIDsyIgf7M83lWAEHezlj6EP6Os8ijQloavnQv6YfyAQyn9.q', 0),
(96, 'Ambrosius', 'ambrosius.kenny@ipsos.com', '$2y$10$HTnqAw.dCnYWl8G2STYSt.19a3VVm6IGvoe1mCpQNc8c/8M1CIjjW', 0),
(98, 'Rhezaleta.Sutrisna', 'rhezaleta.sutrisna@ipsos.com', '$2y$10$/iwNhcSehPl52pgJT0MRXOg1P7Fg5K2PKKNXeuPBBQB0Vi0QP2rWq', 0),
(99, 'sandra.monica', 'sandra.monica@ipsos.com', '$2y$10$E.XumR1Hq/Ti3UELTeZn1uW/SnyFHe9O7/IgjsOujAum/OLGjjGO2', 0),
(100, 'putrinuzulil', 'putri.nuzulilyati@ipsos.com', '$2y$10$frwndm7jm1NH1rzgIYAP0eYyuobZBD2t.89FnEyMQPjERftzu/Pqm', 0),
(101, 'Hamima.Anindani', 'hamima.anindani@ipsos.com', '$2y$10$QmZ5oo8Y74XezfNw2K0z/.gKZ5WmrSmpocHLxpBA30e0qXQLOPW1S', 0),
(102, 'adeabid', 'ade.subhan@ffi-group.co.id', '$2y$10$voRuksbnairsJg.QcwELju7dNGKtLm3PfVX/7UjnX7j6Likqxe0t.', 0),
(103, 'dss_khairulu', 'khairul.umam@ffi-group.co.id', '$2y$10$hsqOyCy10VM/c.Cjmx6Tw.QhBgv8WUZTrb3r1OlyL3AYRwRr4hynW', 0),
(104, 'Andi Sukma', 'andi.sukma@ipsos.com', '$2y$10$pYEPcEXr7jFaHCi6hY4stuf5v6YEO2th3rmEbtHhuoaYLcvhoEq8O', 1),
(106, 'Meika Narvianti', 'meika.narvianti@ipsos.com', '$2y$10$AmBIbCxwo41dKR1KpALaMewNxFqWqiWHquWI2c1YnYO6xthtQF/ri', 0),
(107, 'Ade sukmana', 'ade.sukmana@ipsos.com', '$2y$10$y5x3JDv3f/6L3NLlxtBVmuEsi/eAAX3MTJqtAlHbPrQwhICe6UgU6', 0),
(108, 'Endang.kartiningsih@ipsos.com', 'Endang.kartiningsih@ipsos.com', '$2y$10$gXwZUGe1P8ufxwR3kW6sDeS5srY3P.RRoJZkuPCMm1UUcVbGCtjRG', 1),
(111, 'Imelia-OBV', 'imelia.dewi@ipsos.com', '$2y$10$Osf0zzI8G6LZ05pwufj71.crpYYi/aZyYXUjHIgNezShlUwvwyhQm', 0),
(112, 'annisarafina', 'annisa.rafina@ipsos.com', '$2y$10$Z7B5hpqP3jWJBARf6Vj2DOstITgK5yognd/ZR8e38OzlCK9NZ8Tya', 0),
(113, 'Puja.aulya', 'puja.dwiaulya@ipsos.com', '$2y$10$0TRABQDQOHU.ruNWz9o/delrPT.hTpNVsIY0IEYaM2lc/867lBoqC', 1),
(117, 'pmt.chassis', 'id-pmt-quant-chassis@ipsos.com', '$2y$10$x2IF4Hz3WXrZzdBLEn2f/uxkumVHkQ1tndu724wXRhQzf9ao28gsa', 0),
(118, 'Heni.Nataliasari', 'Heni.Nataliasari@ipsos.com', '$2y$10$fkVTxrlcTTYyxqCPPex8S.a62Yfya/.A5i7hjlislvFIIKC9hcx2W', 0),
(119, 'iqbal', 'iqbal.ffisurabaya@gmail.com', '$2y$10$pS/YEsUtKtvx6o0qno/7E.JskO27zUFpL26VQVPCdGrfzukRq63Ey', 0),
(120, 'Endang.kartiningsih@ipsos.com', 'Endang.kartiningsih@ipsos.com', '$2y$10$lp1TqKUAau0ELFZwFEHkVu7qUkNJpacFaseYA9rOrSb6vyBYUEph.', 1),
(121, 'Siti hasanah', 'siti.hasanah@ipsos.com', '$2y$10$aL.p.9hC1mduV8.MY0ft4egx6PtCEgV9pIrhrOnqtKgiaSw3Th.1.', 0),
(122, 'vio.gaulana', 'Vio.Gaulana@ipsos.com', '$2y$10$XOHdK/e5HPFIiUalAijH5ugHCR/d0gnAZoXQRXtOc02xiG3So9Z3S', 0),
(125, 'Putri.Nastiti', 'Putri.Nastiti@ipsos.com', '$2y$10$PDuA4p5Ws2za3hZbQer8Je91mKSCUJJhhnnBBptJQ2gZ57PYm0ZDy', 0),
(126, 'hendro.wibowo', 'hendro.wibowo@ipsos.com', '$2y$10$/oqfMiEgdgG4OSdtxL8hqucLVZCLrBgYVyVSYDR4IbZZbuv9bS7Tm', 0),
(127, 'hendro.wibowo@ipsos.com', 'hendro.wibowo@ipsos.com', '$2y$10$JaRli./Wf8AYI0j1M6s96.j1HHdBSc4N9KRfTr7DlFj/.pv2GTWyG', 0),
(128, 'supriatno', 'supriatno.kapsir@ipsos.com', '$2y$10$ea4BGPbuJUVzgFSghrmG9uQmNCfgMpi9uYngCwHIADHjErG2BkQQa', 0),
(129, 'sugiyono', 'Sugiyono.Djoyodiharjo@ipsos.com', '$2y$10$Cq2jBmC33kQI.8y9D42ezuX.GIYSvHlGf2FdvQl.hkiy1kC6q42Yi', 1),
(133, 'Yunita.Yunita', 'Yunita.Yunita@ipsos.com', '$2y$10$CBvVOEvceHvrOq.lndk4oOi8J0B5FNT5vOWahqvaFHIsogOSIO1r6', 0),
(134, 'Yura Muhamad', 'yuramuhamad8@gmail.com', '$2y$10$y7OoVZAdSq1YzElMitIQ7ecYVaShCQuL/xY/tVfh/4EM1XJfwqmlG', 0),
(135, 'alvinwilbert', 'ID-PMT-Quant-Aikidio@ipsos.com', '$2y$10$3O8iM70i5154jjO507EhjeORkFlBrX1QqNZVhrczRCKjRkENBIjc6', 0),
(136, 'arbani.pribowo', 'arbani.pribowo@ffi-group.co.id', '$2y$10$Xfbfi6JI6jX6ojrDyM9mN.y0KL9nchagJ6NpLSXGWn9VnLoOii4.K', 0),
(137, 'Sharmila', 'louis.sharmila@ipsos.com', '$2y$10$v/olXn5Z9SDyiJogmrgGJugCrOh6U64yye7ewbUv8/.RMpymo.Qwa', 1),
(138, 'Rachel', 'rachel.irene@ipsos.com', '$2y$10$ZCUMFnbqeLaEMGWNekAGleWd2n2nM7RcTE9geEGLCS7w9pD31LiI2', 1),
(139, 'rachel.irene', 'rachel.irene@ipsos.com', '$2y$10$yPCWFkQQGKIoRX1WT2W1G.1uL.9fjC2ckvrI.OaGYP6VHkxlFOybW', 1),
(141, 'ErzaMazde', 'erza01mazde@gmail.com', '$2y$10$KokpDv02RNUaM3BLGGLcUuVft9PohRb3N9AP25eGZvHhm8ONTxr/S', 0),
(142, 'yuliaftkh', 'yulia.utami@ffi-group.co.id', '$2y$10$JJLdFsjatdaalFUmGqN4NeFxQZvKpxDpA53gZKvONOgR0YBKcmKkW', 0),
(143, 'mellinianf', 'mellinia.fortuna@ffi-group.co.id', '$2y$10$Z96FthlyCVd.OYZl2Ir9yutx5vKArz6KyqGi/cyrMuRVRDeIYvVES', 0),
(145, 'hapsariayu', 'ayu.utami@ffi-group.co.id', '$2y$10$/QEJsfZAgfY05g9TehkA7u1uoSCeCvj5iPl53WmY8JzpPBcxsBoGW', 0),
(146, 'Nur.kholik', 'nur.kholik@ffi-group.co.id', '$2y$10$ODaIUBD.rniBCCyKP8mr8eVc6.JmWQm6iCxkVvSwP3OTabzlJ3Nai', 0),
(149, 'awie hamzah', 'nurhayati.hamzah@ffi-group.co.id', '$2y$10$F2jWKJHY1JeubBmBGVzG/.JlxIfoNLjAh5smfeQ5Zqm9HueIdp2lm', 0),
(150, 'Diah Yustiana', 'diah.yustiana@ffi-group.co.id', '$2y$10$AfOfe8d8loPzCJiY4u7IAOxPBqYploLiQdA3IJT1Gdye7sr4IKeKe', 0),
(152, 'aanggraeny', 'anggun.anggraeny@ipsos.com', '$2y$10$iG.jEmUgnkWpacLl0Yq9vONZlX251zQ6tJFUEvwYdKLE5DEWAR47G', 1),
(153, 'anggun', 'anggun.anggraeny@ipsos.com', '$2y$10$8YcrSVOZ/b5yxr4PhzJ14OKfEEcjRGeccStjlcgzRgFcZqYBdVuLW', 1),
(154, 'bariza.astari', 'bariza.astari@ipsos.com', '$2y$10$XWHhJP6UwTMLUgRAFsQh0uuEq0jegdOxS/tfPd0R0ZclVyrTQwfyu', 0),
(156, 'Annura', 'Annura.Gayatri@ipsos.com', '$2y$10$cTYAxxcj3hEtBdvGFGOzRuuOXKmpxHz1r7WW.fPTPuitb.gnkqWT.', 0),
(157, 'ID-PMT-Seta', 'ID-PMT-Seta@ipsos.com', '$2y$10$KEsLX01IIlE6scyQuz.RWeLfawO/6LYIeyAu5DZw7Dgg9ZyyEl6V.', 1),
(158, 'rahmatjaelani', 'rahmat.jaelani@ffi-group.co.id', '$2y$10$d.XnsiciYQAm71JDlD5X4uyq6ajAw5adIKE3drHTqEB8qC6iGBMkm', 0),
(159, 'Myrna', 'mirnasary.mirnasary@ipsos.com', '$2y$10$zKhWf1h50k0jS6OYOXoTa.1B2yTpgqQOBsmNBj0y0BVZfRvTfuT.a', 0),
(160, 'juni.ningrum', 'juni.ningrum@ffi-group.co.id', '$2y$10$y5wduyb2jbOui33uHIx9/uLMB870RhZ2r6VSK6eH5x.pHNK7y.Xqe', 0),
(161, 'alihakim932', 'alihakim932@gmail.com', '$2y$10$lQIhmUVFALfiisdEcjxW2.y.goz0AxOhkfxcqMOGqVYS6JQ/G0IGW', 0),
(162, 'indri hendriyanti', 'indri.hendriyanti@ffi-group.co.id', '$2y$10$nqr21fAsS0J6Nv.eY.D1uOxJnHMkJvosycXJqZCfwwKE5GM1WTJRu', 0),
(163, 'Harish.Bahfen', 'harish.bahfen@ipsos.com', '$2y$10$Cry/4NUHaz0DVIF.jGM4nuPYPqNMmVB2xd9tseoxQ7Fa9THTZK/1K', 1),
(164, 'harishbahfen', 'harish.bahfen@ipsos.com', '$2y$10$b25eGhl3HpwM3Z.PZKEzauMpQ8w49ffEEVgPRKo9axD.fLbhR8eZq', 1),
(165, 'aris.setiadi', 'id-pmt-quant@ipsos.com', '$2y$10$Gjx8JUM9RMQspgKWIoW0nOUTm7B7FB1VCdU8vcwsdN.W0nskZbVe.', 0),
(166, 'pujadwiaul', 'puja.dwiaulya@ipsos.com', '$2y$10$8A52Q81bv3RIKd7BERUBqOOKQY.e0BJYzUG88VM35//pqwxd9pdMa', 1),
(167, 'ipsos_ops', 'slamet.supriyanto@ipsos.com', '$2y$10$FkScWvg.3ihFC7yvwb9RmOULUAKS4eu1OywTo969A6YYz6tBGNIFK', 0),
(168, 'peri.peri2', 'peri.soleh@ipsos.com', '$2y$10$/jneeDckkK4vwQQ0A5L2f.dEXZhVdO6VFYuunJr0KJEbHIWuZv6Y6', 1),
(169, 'peri.peri2', 'peri.soleh@ipsos.com', '$2y$10$K4gYvRL5hQWPUDyblgV/deckt55kUm3SKUknndu1eoiMQLUXRffb.', 1),
(170, 'harish.bahfen', 'harish.bahfen@ipsos.com', '$2y$10$AB2dn0RTi.BMSpIcjO77H.SwjrLx82eDMvHr/eXZn96T6Zbi1ogoO', 1),
(171, 'yudistiro.prasetio', 'yudistiro.prasetio@ffi-group.co.id', '$2y$10$aUtYY4bkoKpXrvBbyz2iEeB2L6G/Ogj0waaanhJj875Y4MsGlVgwq', 0),
(174, 'rojudin.rojudin', 'rojudin.rojudin@ipsos.com', '$2y$10$zEg3QG8tffOCqoWxW12QvuYo9TBooq6edZ/TwnOFxhqR2wAd35mea', 0),
(178, 'Erza', 'erza@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0),
(179, 'Erza1', 'erza01mazde@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
