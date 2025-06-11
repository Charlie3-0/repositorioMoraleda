-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-06-2025 a las 22:44:28
-- Versión del servidor: 8.0.34-0ubuntu0.22.04.1
-- Versión de PHP: 8.3.3-1+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `TestPlayMVC`
--
CREATE DATABASE IF NOT EXISTS `TestPlayMVC` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `TestPlayMVC`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(3, 'Estrategia'),
(4, 'Rol'),
(5, 'Puzles'),
(6, 'Supervivencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int NOT NULL,
  `idVideojuego` int NOT NULL,
  `idUsuario` int NOT NULL,
  `comentario` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_comentario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `idVideojuego`, `idUsuario`, `comentario`, `fecha_comentario`) VALUES
(105, 5, 1, 'Buen ritmo desde el inicio, te atrapa rápido.', '2024-03-05 11:31:00'),
(107, 5, 3, 'Pude probar varias armas, están muy bien equilibradas.', '2023-07-15 06:56:00'),
(110, 5, 4, 'El tiempo de prueba fue justo para engancharme.', '2023-11-28 20:47:00'),
(115, 5, 5, 'Las mecánicas están bien pensadas y se disfrutan.', '2024-09-26 17:01:00'),
(117, 5, 2, 'Perfecto para sesiones cortas como las que permite la plataforma.', '2024-12-23 07:34:00'),
(119, 6, 1, 'Definitivamente lo recomendaría para quienes disfrutan el género.', '2024-06-26 07:08:00'),
(122, 6, 3, 'Quería más tiempo, el mundo es enorme.', '2023-05-27 04:19:00'),
(125, 6, 4, 'Las mecánicas están bien pensadas y se disfrutan.', '2025-05-19 03:31:00'),
(128, 6, 5, 'Buena interfaz, aunque algunos controles son mejorables.', '2024-10-29 09:15:00'),
(131, 6, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2025-05-06 18:39:00'),
(134, 7, 1, 'Los personajes están muy bien escritos y tienen carisma.', '2025-03-02 17:52:00'),
(137, 7, 3, 'Perfecto para sesiones cortas como las que permite la plataforma.', '2024-10-13 01:30:00'),
(140, 7, 4, 'Funciona bien con teclado y ratón, cosa que valoro.', '2025-01-22 02:48:00'),
(143, 7, 5, 'Ideal para tener una idea clara antes de comprarlo.', '2023-11-25 02:51:00'),
(146, 7, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2024-05-25 23:24:00'),
(149, 8, 1, 'Los personajes están muy bien escritos y tienen carisma.', '2024-03-23 22:25:00'),
(152, 8, 3, 'Pude probarlo y creo que lo jugaría completo.', '2024-01-31 22:55:00'),
(155, 8, 4, 'Te deja justo en el punto de querer seguir jugando.', '2024-02-01 23:04:00'),
(158, 8, 5, 'Muy fluido en mi PC, sin bugs ni fallos graves.', '2024-08-04 05:10:00'),
(161, 8, 2, 'No tuve problemas de rendimiento, todo muy pulido.', '2025-02-23 01:04:00'),
(164, 9, 1, 'Perfecto para experimentar antes de decidir.', '2024-11-14 12:13:00'),
(167, 9, 3, 'Buen ritmo desde el inicio, te atrapa rápido.', '2024-02-13 20:45:00'),
(170, 9, 4, 'Pude probarlo y creo que lo jugaría completo.', '2025-04-05 19:44:00'),
(173, 9, 5, 'Los gráficos no son lo mejor, pero lo compensa con gameplay.', '2023-11-06 07:14:00'),
(176, 9, 2, 'Gráficos impresionantes y muy buena jugabilidad.', '2024-10-05 18:43:00'),
(179, 10, 1, 'El tiempo de prueba fue justo para engancharme.', '2024-12-27 10:45:00'),
(182, 10, 3, 'Perfecto para sesiones cortas como las que permite la plataforma.', '2024-03-06 11:58:00'),
(185, 10, 4, 'Pude probar varias armas, están muy bien equilibradas.', '2023-09-19 01:01:00'),
(188, 10, 5, 'Las mecánicas están bien pensadas y se disfrutan.', '2024-01-19 13:39:00'),
(191, 10, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2024-08-02 16:08:00'),
(194, 11, 1, 'No tuve problemas de rendimiento, todo muy pulido.', '2024-02-24 07:46:00'),
(197, 11, 3, 'Ideal para tener una idea clara antes de comprarlo.', '2023-09-02 20:09:00'),
(200, 11, 4, 'Buena interfaz, aunque algunos controles son mejorables.', '2025-03-21 19:56:00'),
(203, 11, 5, 'Muy divertido en las 2 horas que jugué.', '2023-06-29 23:44:00'),
(206, 11, 2, 'Los gráficos no son lo mejor, pero lo compensa con gameplay.', '2024-03-23 19:30:00'),
(209, 12, 1, 'Te deja justo en el punto de querer seguir jugando.', '2024-03-20 19:15:00'),
(212, 12, 3, 'Buen ritmo desde el inicio, te atrapa rápido.', '2025-02-02 22:14:00'),
(215, 12, 4, 'Pude probarlo y creo que lo jugaría completo.', '2024-11-09 23:58:00'),
(218, 12, 5, 'Ideal para tener una idea clara antes de comprarlo.', '2024-08-09 01:01:00'),
(221, 12, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2023-08-05 08:12:00'),
(224, 13, 1, 'Me recordó a otros clásicos del género.', '2023-07-12 14:51:00'),
(227, 13, 3, 'Los personajes están muy bien escritos y tienen carisma.', '2024-05-10 18:19:00'),
(230, 13, 4, 'Te deja justo en el punto de querer seguir jugando.', '2023-12-25 14:29:00'),
(233, 13, 5, 'Gráficos impresionantes y muy buena jugabilidad.', '2024-03-20 12:58:00'),
(236, 13, 2, 'Pude probarlo y creo que lo jugaría completo.', '2024-07-30 16:26:00'),
(239, 14, 1, 'Definitivamente lo recomendaría para quienes disfrutan el género.', '2024-04-17 20:31:00'),
(242, 14, 3, 'No tuve problemas de rendimiento, todo muy pulido.', '2023-06-01 11:42:00'),
(245, 14, 4, 'Pude probar varias armas, están muy bien equilibradas.', '2025-01-20 10:50:00'),
(248, 14, 5, 'La música y el sonido están muy logrados.', '2024-08-06 20:14:00'),
(251, 14, 2, 'Perfecto para sesiones cortas como las que permite la plataforma.', '2023-05-27 00:50:00'),
(254, 15, 1, 'Funciona bien con teclado y ratón, cosa que valoro.', '2024-01-12 17:35:00'),
(257, 15, 3, 'Definitivamente lo recomendaría para quienes disfrutan el género.', '2024-05-18 15:07:00'),
(260, 15, 4, 'Te deja justo en el punto de querer seguir jugando.', '2024-07-02 17:19:00'),
(263, 15, 5, 'Gráficos impresionantes y muy buena jugabilidad.', '2024-12-18 12:24:00'),
(266, 15, 2, 'Ideal para tener una idea clara antes de comprarlo.', '2023-05-26 03:21:00'),
(269, 16, 1, 'Gráficos impresionantes y muy buena jugabilidad.', '2024-11-06 22:26:00'),
(272, 16, 3, 'No me esperaba que me gustara tanto, sorprendente.', '2024-12-25 15:39:00'),
(275, 16, 4, 'Buen ritmo desde el inicio, te atrapa rápido.', '2025-01-10 13:06:00'),
(278, 16, 5, 'Pude probar varias armas, están muy bien equilibradas.', '2025-05-21 01:15:00'),
(281, 16, 2, 'Perfecto para experimentar antes de decidir.', '2024-04-22 03:47:00'),
(284, 17, 1, 'La música y el sonido están muy logrados.', '2024-02-05 15:55:00'),
(287, 17, 3, 'El diseño de niveles es muy inteligente y retador.', '2024-02-09 22:14:00'),
(290, 17, 4, 'Muy buen equilibrio entre dificultad y recompensa.', '2024-11-22 17:15:00'),
(293, 17, 5, 'Me encantó la ambientación y la historia que cuenta.', '2024-05-09 20:33:00'),
(296, 17, 2, 'No tuve problemas de rendimiento, todo muy pulido.', '2025-04-20 05:47:00'),
(299, 18, 1, 'Perfecto para experimentar antes de decidir.', '2023-08-01 17:56:00'),
(302, 18, 3, 'Muy divertido en las 2 horas que jugué.', '2025-04-16 07:37:00'),
(305, 18, 4, 'Gráficos impresionantes y muy buena jugabilidad.', '2025-03-01 23:49:00'),
(308, 18, 5, 'Ideal para tener una idea clara antes de comprarlo.', '2024-03-30 13:20:00'),
(311, 18, 2, 'Me recordó a otros clásicos del género.', '2024-05-05 18:36:00'),
(314, 19, 1, 'No tuve problemas de rendimiento, todo muy pulido.', '2024-07-07 17:21:00'),
(317, 19, 3, 'Pude probarlo y creo que lo jugaría completo.', '2024-12-03 02:12:00'),
(321, 19, 4, 'Los personajes están muy bien escritos y tienen carisma.', '2023-10-08 11:34:00'),
(323, 19, 5, 'Funciona bien con teclado y ratón, cosa que valoro.', '2024-02-03 08:08:00'),
(326, 19, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2024-02-10 03:46:00'),
(329, 20, 1, 'Las mecánicas están bien pensadas y se disfrutan.', '2024-06-16 13:07:00'),
(332, 20, 3, 'Me recordó a otros clásicos del género.', '2024-12-28 16:22:00'),
(335, 20, 4, 'Muy divertido en las 2 horas que jugué.', '2024-07-12 10:44:00'),
(338, 20, 5, 'No me esperaba que me gustara tanto, sorprendente.', '2025-03-11 23:35:00'),
(341, 20, 2, 'Definitivamente lo recomendaría para quienes disfrutan el género.', '2025-02-23 11:43:00'),
(344, 21, 1, 'Los puzles se sienten muy bien y son divertidos.', '2023-07-25 03:05:00'),
(347, 21, 3, 'Ideal para tener una idea clara antes de comprarlo.', '2024-02-24 16:24:00'),
(350, 21, 4, 'No tuve problemas de rendimiento, todo muy pulido.', '2024-08-30 17:54:00'),
(353, 21, 5, 'Gráficos impresionantes y muy buena jugabilidad.', '2023-06-13 00:30:00'),
(356, 21, 2, 'Quería más tiempo, el mundo es enorme.', '2023-09-09 01:56:00'),
(359, 22, 1, 'Te deja justo en el punto de querer seguir jugando.', '2024-07-01 20:36:00'),
(362, 22, 3, 'Los gráficos no son lo mejor, pero lo compensa con gameplay.', '2023-08-11 06:20:00'),
(365, 22, 4, 'Muy buen equilibrio entre dificultad y recompensa.', '2024-12-11 05:02:00'),
(368, 22, 5, 'En las 2 horas de prueba lo pasé genial.', '2024-10-29 05:27:00'),
(371, 22, 2, 'Probé el juego durante un rato y me dejó con ganas de más.', '2023-06-28 00:12:00'),
(374, 23, 1, 'Muy fluido en mi PC, sin bugs ni fallos graves.', '2024-10-21 17:43:00'),
(377, 23, 3, 'Las mecánicas están bien pensadas y se disfrutan.', '2025-01-21 12:35:00'),
(380, 23, 4, 'Los gráficos no son lo mejor, pero lo compensa con gameplay.', '2024-03-26 02:26:00'),
(383, 23, 5, 'Perfecto para experimentar antes de decidir.', '2024-05-30 16:22:00'),
(386, 23, 2, 'Quería más tiempo, el mundo es enorme.', '2024-09-28 08:58:00'),
(389, 24, 1, 'En la prueba pude explorar bastante, está bien optimizado.', '2025-01-06 21:57:00'),
(392, 24, 3, 'No me esperaba que me gustara tanto, sorprendente.', '2024-07-05 00:53:00'),
(395, 24, 4, 'Muy fluido en mi PC, sin bugs ni fallos graves.', '2024-11-04 15:15:00'),
(398, 24, 5, 'Buen ritmo desde el inicio, te atrapa rápido.', '2023-07-11 06:12:00'),
(401, 24, 2, 'Funciona bien con teclado y ratón, cosa que valoro.', '2024-07-06 10:14:00'),
(404, 25, 1, 'Perfecto para sesiones cortas como las que permite la plataforma.', '2024-12-08 09:08:00'),
(407, 25, 3, 'Ideal para tener una idea clara antes de comprarlo.', '2023-12-11 18:55:00'),
(410, 25, 4, 'Una gran sorpresa, pensé que sería más simple.', '2025-03-12 06:42:00'),
(413, 25, 5, 'El diseño de niveles es muy inteligente y retador.', '2023-07-25 19:16:00'),
(416, 25, 2, 'Las mecánicas están bien pensadas y se disfrutan.', '2025-03-15 18:41:00'),
(421, 6, 6, 'Gracias por vuestros comentarios.\n\nPronto traeremos m&aacute;s juegos similares para probar.', '2025-05-22 02:25:33'),
(423, 5, 6, 'Nos alegra ver que este juego ha tenido buena acogida. Estamos buscando otros títulos similares para incluir.', '2025-04-12 15:45:00'),
(424, 9, 6, 'Pronto añadiremos más juegos de este género. ¡Gracias por probarlos en nuestra plataforma!', '2024-07-21 09:50:00'),
(425, 10, 6, 'Os animamos a seguir comentando vuestras experiencias. Son muy útiles para decidir qué juegos ampliar en el futuro.', '2023-11-15 13:30:00'),
(426, 12, 6, 'Estamos atentos a vuestras sugerencias. No dudéis en proponer géneros o sagas que os gustaría probar.', '2025-03-30 17:15:00'),
(427, 14, 6, 'Gracias por vuestra participación. Nos alegra ver cómo la comunidad crece con buen ambiente.', '2023-09-08 10:05:00'),
(428, 18, 6, 'Este juego ha sido muy solicitado. Esperamos que lo estéis disfrutando durante el periodo de prueba.', '2025-01-25 16:00:00'),
(429, 21, 6, 'Os recordamos que el tiempo de prueba es de 2 horas. Esperamos que os ayude a conocer bien el juego.', '2024-10-01 12:40:00'),
(430, 23, 6, 'En breve realizaremos mantenimiento para mejorar la estabilidad de la plataforma. Gracias por vuestra comprensión.', '2024-06-17 18:35:00'),
(431, 25, 6, 'Habrá nuevos títulos disponibles muy pronto. Estad atentos a las próximas incorporaciones.', '2025-05-14 20:10:00'),
(447, 26, 4, 'Me ha gustado mucho la construcción de campamentos.', '2025-05-31 21:06:57'),
(461, 20, 6, 'Nos alegra que lo disfrut&eacute;is.', '2025-06-06 18:14:36'),
(463, 2, 5, 'Est&aacute; genial todo el armamento que puedes obtener.', '2025-06-07 00:22:53'),
(464, 3, 5, 'Que gr&aacute;ficos tan buenos.', '2025-06-07 00:23:06'),
(465, 4, 5, 'El parry es genial, se siente muy bien al jugar.', '2025-06-07 00:23:30'),
(467, 1, 5, 'Hola me ha gustado mucho este juego desde que lo jugué hace tiempo en la play 2 y ahora con todo el cambio que ha tenido espero que cambie la dinámica de acción del juego pero que también le de un soplo de aire fresco a los juegos de accion ya que no tiene tanto movimiento aunque es mas tosco y estable. Tiene otras cosas distintas pero me sigue gustando mucho y espero mucho más de esta franquicia y de Santa Monica Studios.', '2025-06-07 22:14:28'),
(468, 1, 6, 'Nos alegra que a los usuarios os guste, trataremos de traer m&aacute;s juegos de este estilo.', '2025-06-08 00:34:55'),
(484, 1, 4, 'Espero que sigan trayendo más juegos de esta modalidad.', '2025-06-08 01:27:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int NOT NULL,
  `fecha_prestamo` datetime NOT NULL,
  `devuelto` tinyint(1) NOT NULL,
  `idUsuario` int NOT NULL,
  `idVideojuego` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `fecha_prestamo`, `devuelto`, `idUsuario`, `idVideojuego`) VALUES
(1, '2025-03-09 16:11:10', 1, 1, 2),
(2, '2025-03-09 11:07:07', 1, 1, 1),
(3, '2025-03-17 18:42:24', 1, 1, 15),
(4, '2025-03-17 19:18:14', 1, 3, 14),
(5, '2025-03-18 10:08:06', 1, 4, 8),
(6, '2025-04-06 20:37:53', 1, 1, 4),
(7, '2025-04-06 15:14:12', 0, 1, 4),
(8, '2025-04-18 13:27:26', 1, 1, 1),
(9, '2025-04-19 23:33:11', 1, 1, 1),
(10, '2025-04-19 14:19:34', 1, 2, 3),
(11, '2025-04-20 19:22:51', 0, 2, 12),
(12, '2025-05-29 18:23:19', 1, 3, 16),
(13, '2025-05-29 19:07:24', 1, 2, 16),
(14, '2025-05-29 20:50:57', 1, 5, 11),
(15, '2025-05-29 20:57:36', 1, 2, 17),
(16, '2025-05-29 21:19:36', 1, 1, 20),
(17, '2025-05-31 20:45:38', 1, 2, 16),
(18, '2025-06-01 00:58:40', 1, 3, 16),
(20, '2025-06-02 01:28:57', 0, 3, 5),
(21, '2025-06-04 01:24:22', 0, 4, 17),
(22, '2025-06-04 01:25:28', 0, 3, 19),
(23, '2025-06-08 15:08:24', 0, 1, 1),
(24, '2025-06-08 15:39:46', 0, 3, 2),
(25, '2025-06-08 15:48:58', 0, 2, 9),
(26, '2025-06-10 21:54:07', 0, 2, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones`
--

CREATE TABLE `puntuaciones` (
  `id` int NOT NULL,
  `puntuacion` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idVideojuego` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `puntuaciones`
--

INSERT INTO `puntuaciones` (`id`, `puntuacion`, `idUsuario`, `idVideojuego`) VALUES
(1, 8, 1, 1),
(2, 7, 1, 4),
(3, 7, 1, 6),
(4, 5, 1, 2),
(5, 6, 5, 7),
(6, 9, 5, 1),
(7, 6, 1, 5),
(8, 7, 5, 5),
(9, 7, 4, 19),
(10, 5, 4, 20),
(11, 7, 4, 26),
(13, 8, 4, 23),
(14, 8, 5, 2),
(16, 6, 5, 4),
(17, 9, 5, 16),
(18, 8, 5, 18),
(19, 6, 5, 17),
(20, 9, 5, 20),
(21, 5, 5, 19),
(22, 8, 5, 21),
(23, 7, 5, 22),
(24, 6, 5, 23),
(25, 6, 5, 24),
(26, 10, 5, 25),
(27, 6, 5, 26),
(28, 5, 5, 27),
(29, 9, 5, 28),
(30, 7, 5, 29),
(31, 7, 5, 30),
(32, 8, 5, 11),
(33, 7, 5, 12),
(34, 8, 5, 13),
(35, 5, 5, 14),
(36, 8, 5, 15),
(37, 7, 5, 9),
(38, 9, 5, 10),
(39, 5, 5, 8),
(40, 9, 5, 3),
(41, 7, 4, 2),
(42, 9, 4, 1),
(43, 10, 4, 16),
(45, 8, 2, 24),
(46, 10, 1, 3),
(47, 6, 1, 7),
(48, 5, 1, 11),
(49, 6, 1, 13),
(50, 5, 1, 8),
(51, 7, 1, 23),
(52, 8, 1, 16),
(53, 6, 1, 27),
(54, 4, 1, 30),
(55, 8, 1, 10),
(56, 5, 1, 24),
(57, 8, 1, 21),
(58, 9, 1, 25),
(59, 6, 1, 15),
(60, 7, 1, 17),
(61, 6, 1, 14),
(62, 5, 1, 9),
(63, 7, 1, 12),
(64, 9, 1, 18),
(65, 5, 1, 19),
(66, 9, 1, 20),
(67, 6, 1, 22),
(68, 8, 1, 28),
(69, 6, 1, 26),
(70, 6, 1, 29),
(71, 7, 3, 22),
(72, 9, 3, 25),
(73, 7, 3, 26),
(74, 5, 3, 27),
(75, 6, 3, 28),
(76, 8, 3, 29),
(77, 7, 3, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int NOT NULL,
  `fecha_reserva` datetime NOT NULL,
  `idUsuario` int NOT NULL,
  `idVideojuego` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `fecha_reserva`, `idUsuario`, `idVideojuego`) VALUES
(7, '2025-05-11 17:52:56', 1, 19),
(9, '2025-05-12 17:53:31', 1, 11),
(10, '2025-05-13 15:53:51', 4, 3),
(11, '2025-05-13 17:54:23', 5, 6),
(19, '2025-05-13 17:55:29', 1, 15),
(22, '2025-05-13 17:55:36', 1, 23),
(29, '2025-05-13 17:55:48', 3, 8),
(30, '2025-05-13 17:55:57', 2, 18),
(36, '2025-05-14 15:56:10', 2, 9),
(37, '2025-05-25 23:01:38', 5, 16),
(55, '2025-06-01 22:09:39', 4, 26),
(67, '2025-06-07 18:49:45', 5, 2),
(72, '2025-06-08 15:07:05', 1, 1),
(74, '2025-06-08 15:38:48', 5, 4),
(75, '2025-06-08 22:27:15', 2, 24),
(77, '2025-06-10 22:21:16', 2, 13),
(78, '2025-06-11 17:01:21', 3, 22),
(79, '2025-06-11 17:01:52', 3, 25),
(80, '2025-06-11 17:25:10', 3, 27),
(82, '2025-06-11 17:25:33', 3, 28),
(83, '2025-06-11 17:26:08', 3, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `rol` varchar(1) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `rol`) VALUES
(1, 'carlos@gmail.com', '$2y$10$khwHeTLdk7zQqIpjIxVg5uwyP3H1jr3hq/S.NoonK04LlMcHkaMQ2', 'U'),
(2, 'paco@gmail.com', '$2y$10$NH9t9De0GTacbzacvY6W5eFW4jTkFLOHt726GEu3mpyZfuXbRMaoW', 'U'),
(3, 'jose@gmail.com', '$2y$10$JE4SfH2wwkl7ZatMnZ2UfedqJGrBAk06iJs8eBxmsi7OKE1ZDHlfi', 'U'),
(4, 'pepe@gmail.com', '$2y$10$KN9pWkwAPdA2hLAo6GiNDOys704SeS1W1F3j2mcs5kdSouSNTqOK6', 'U'),
(5, 'juan@gmail.com', '$2y$10$h5WW0M9I06OoUSRkbYq9yed4P/5Rl9ab07zFVrPK0NvRXdzAjSPzu', 'U'),
(6, 'admin@gmail.com', '$2y$10$khwHeTLdk7zQqIpjIxVg5uwyP3H1jr3hq/S.NoonK04LlMcHkaMQ2', 'A'),
(8, 'charlie3-0@testplay.com', '$2y$10$QOjP/URsXndtm4Um7/817OGwbHuqWy4dCeteWViVFYxYALRqfl2r6', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuegos`
--

CREATE TABLE `videojuegos` (
  `id` int NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `desarrollador` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `foto` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idCategoria` int NOT NULL,
  `fecha_lanzamiento` date NOT NULL,
  `trailer` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`id`, `titulo`, `desarrollador`, `descripcion`, `foto`, `idCategoria`, `fecha_lanzamiento`, `trailer`) VALUES
(1, 'God of War', 'Santa Monica Studio', 'Kratos, el dios de la guerra, se enfrenta a su pasado en un mundo nórdico junto a su hijo Atreus. Una aventura épica llena de combate y emociones.', 'god_of_war_2018.jpg', 1, '2022-01-14', 'https://www.youtube.com/embed/HqQMh_tij0c?si=dQm7fLlhxcNFS5cx'),
(2, 'DOOM Eternal', 'id Software', 'El Doom Slayer regresa para exterminar hordas demoníacas con velocidad brutal y armamento devastador en esta secuela frenética.', 'doom_eternal.avif', 1, '2020-03-20', 'https://www.youtube.com/embed/IZtW3iI1RX0?si=b_eCG5qhCKhynmND'),
(3, 'Red Dead Redemption 2', 'Rockstar Games', 'Sigue la historia de Arthur Morgan en el salvaje oeste en este mundo abierto lleno de acción, narrativa intensa y exploración.', 'red_dead_2.jpg', 1, '2019-11-05', 'https://www.youtube.com/embed/SXvQ1nK4oxk?si=r-TloYu9Io_GvXIk'),
(4, 'Sekiro: Shadows Die Twice', 'FromSoftware', 'Un guerrero solitario emprende una misión para rescatar a su maestro y vengarse en un Japón feudal lleno de enemigos letales.', 'sekiro.webp', 1, '2019-03-22', 'https://www.youtube.com/embed/rXMX4YJ7Lks?si=v9QrlO9hydtubftd'),
(5, 'Resident Evil 4 Remake', 'Capcom', 'Una reinvención moderna del clásico de horror y acción donde Leon S. Kennedy debe rescatar a la hija del presidente en un pueblo infestado.', 'resident_evil_4.jpg', 1, '2023-03-24', 'https://www.youtube.com/embed/O75Ip4o1bs8?si=XSoXLKOOZYy6GwE4'),
(6, 'Alan Wake 2', 'Remedy Entertainment', 'El escritor Alan Wake y la agente del FBI Saga Anderson se enfrentan a horrores sobrenaturales en una oscura historia de misterio y supervivencia.', 'alan_wake2.jpg', 2, '2023-10-27', 'https://www.youtube.com/embed/dlQ3FeNu5Yw?si=PxXBTHE9nb7zHJeH'),
(7, 'A Plague Tale: Requiem', 'Asobo Studio', 'Amicia y Hugo continúan su viaje en un mundo devastado por la peste, enfrentándose a soldados y hordas de ratas en esta emotiva historia de aventura.', 'a_plage_tale.f27cfe2b-b8b2-47f3-a92e-0eebe096efa2', 2, '2022-10-18', 'https://www.youtube.com/embed/qIbzwb8vzNI?si=5R5L0QnNp1not64m'),
(8, 'Life is Strange: True Colors', 'Deck Nine', 'Alex Chen explora sus poderes empáticos para descubrir la verdad sobre la muerte de su hermano en este drama interactivo lleno de decisiones.', 'life_is_strange_true_colors.jpg', 2, '2021-09-10', 'https://www.youtube.com/embed/kA0KmeARFdQ?si=S-ku2plZUfgKPl8m'),
(9, 'Stray', 'BlueTwelve Studio', 'Controla a un gato callejero en una ciudad cibernética postapocalíptica, resolviendo acertijos y evitando enemigos en esta original aventura.', 'stray.jpg', 2, '2022-07-19', 'https://www.youtube.com/embed/_rkopP_9qis?si=HCvrQF0B5zr9cizw'),
(10, 'Uncharted: Legacy of Thieves Collection', 'Naughty Dog / Iron Galaxy', 'Dos aventuras cargadas de acción y exploración con Nathan Drake y Chloe Frazer llegan por primera vez a PC en esta remasterización.', 'uncharted_LTC.jpg', 2, '2022-10-19', 'https://www.youtube.com/embed/xeMA3O9pfiY?si=mngQ5TGBdnQImQAn'),
(11, 'Age of Empires IV', 'Relic Entertainment / World’s Edge', 'Revive la historia con batallas épicas y civilizaciones legendarias en esta nueva entrega del clásico de estrategia en tiempo real.', 'age-of-empires-iv-deluxe-edition.webp', 3, '2021-10-28', 'https://www.youtube.com/embed/3P_7gvUvDXY?si=jQlBmYX3iUlbWC36'),
(12, 'Total War: WARHAMMER III', 'Creative Assembly', 'Un épico conflicto entre los dioses del Caos y los reinos mortales en esta combinación de estrategia por turnos y batallas en tiempo real.', 'Total_War_Warhammer_3.webp', 3, '2022-02-17', 'https://www.youtube.com/embed/F3rXKKGsfpk?si=vI0EZbjsoz51mB89'),
(13, 'Crusader Kings III', 'Paradox Development Studio', 'Construye una dinastía medieval mediante la diplomacia, la guerra y los matrimonios políticos en este profundo juego de estrategia y rol.', 'crusader3king.jpeg', 3, '2020-09-01', 'https://www.youtube.com/embed/Demi3MfHHYw?si=itvzMsL6D1VHPmWf'),
(14, 'Company of Heroes 3', 'Relic Entertainment', 'Comanda tus tropas durante la Segunda Guerra Mundial en intensos combates tácticos en tiempo real en escenarios del Mediterráneo.', 'company_of_heroes3.jpg', 3, '2023-02-23', 'https://www.youtube.com/embed/mrfhmDtGPrk?si=dJpjmXQgnN9cyeW7'),
(15, 'Frostpunk', '11 bit studios', 'Gestiona una ciudad en un mundo congelado, tomando decisiones morales y estratégicas para asegurar la supervivencia de la humanidad.', 'frostpunk.jpg', 3, '2018-04-24', 'https://www.youtube.com/embed/qqEpSOFDXGA?si=vM1i0LJd06KSLdPV'),
(16, 'Baldur\'s Gate 3', 'Larian Studios', 'Un RPG épico basado en Dungeons &amp; Dragons con combate por turnos, decisiones narrativas y un enorme mundo lleno de posibilidades.', 'baldurs_gate3.jpg', 4, '2023-08-03', 'https://www.youtube.com/embed/okFSR8CCOPY?si=CxydrrmpldrUDHIm'),
(17, 'Cyberpunk 2077', 'CD Projekt RED', 'Explora Night City como V, un mercenario en busca de inmortalidad en este RPG de mundo abierto cargado de narrativa y acción.', 'cyberpunk-2077.webp', 4, '2020-12-10', 'https://www.youtube.com/embed/8X2kIfS6fb8?si=nseEin89I4-Lo5OF'),
(18, 'The Witcher 3: Wild Hunt', 'CD Projekt RED', 'Acompaña a Geralt de Rivia en una aventura épica por un mundo abierto lleno de monstruos, magia y decisiones morales.', 'Witcher_3.jpg', 4, '2015-05-19', 'https://www.youtube.com/embed/TWOkT7l0yWQ?si=4dREV-GxKBWe-d0p'),
(19, 'Starfield', 'Bethesda Game Studios', 'Explora el universo en este RPG de ciencia ficción con cientos de planetas, combates espaciales y profundas decisiones de personaje.', 'Starfield.jpg', 4, '2023-09-06', 'https://www.youtube.com/embed/kfYEiTdsyas?si=ax0olSwRqelAE6X-'),
(20, 'Elden Ring', 'FromSoftware', 'Una aventura de rol y acción en un mundo abierto creado junto a George R. R. Martin, donde cada decisión y combate cuenta.', 'elden.jpg', 4, '2022-02-25', 'https://www.youtube.com/embed/CptaXqVY6-E?si=tHZvqOv_Ng31z4hP'),
(21, 'The Talos Principle 2', 'Croteam', 'Una aventura filosófica de ciencia ficción con desafiantes rompecabezas en entornos impresionantes que exploran la conciencia y la humanidad.', 'The_Talos_Principle_2.jpg', 5, '2023-11-02', 'https://www.youtube.com/embed/6slinvkF0Rs?si=6uv1Hab10d5vzKR5'),
(22, 'The Witness', 'Jonathan Blow / Thekla, Inc.', 'Explora una isla misteriosa resolviendo cientos de acertijos visuales que estimulan la lógica, la percepción y la memoria.', 'the_witness.webp', 5, '2016-01-26', 'https://www.youtube.com/embed/ul7kNFD6noU?si=yln12si8puCotDVP'),
(23, 'Humanity', 'tha / Enhance', 'Controla a un perro luminoso que guía multitudes humanas a través de intrincados rompecabezas con elementos de estrategia y sincronización.', 'humanity.jpg', 5, '2023-05-16', 'https://www.youtube.com/embed/62Yjl5rTXSY?si=abFy7NDq71w8Rxl8'),
(24, 'Superliminal', 'Pillow Castle', 'Un juego de puzles en primera persona donde la perspectiva lo es todo: los objetos cambian de tamaño y forma según cómo los mires.', 'super_liminal.jpg', 5, '2019-11-12', 'https://www.youtube.com/embed/_SX8XMwMw6Y?si=WMbvCVHdptGw3cvf'),
(25, 'Portal 2', 'Valve', 'Una obra maestra de lógica y narrativa donde debes resolver ingeniosos acertijos usando portales de teletransportación en un laboratorio de pruebas.', 'portal2.jpg', 5, '2011-04-19', 'https://www.youtube.com/embed/tax4e4hBBZc?si=rDwhdWlHiu3AL7EE'),
(26, 'Sons of the Forest', 'Endnight Games', 'Una intensa experiencia de supervivencia en una isla misteriosa llena de criaturas caníbales, donde deberás construir, explorar y luchar por tu vida.', 'Sons_of_the_Forest.jpg', 6, '2023-02-23', 'https://www.youtube.com/embed/IwvhH3islZw?si=LnJfFXL1PTqb4aIh'),
(27, 'Green Hell', 'Creepy Jar', 'Sobrevive en la implacable selva amazónica gestionando salud física y mental mientras enfrentas peligros naturales y humanos.', 'green_hell.avif', 6, '2019-09-05', 'https://www.youtube.com/embed/bBXIJ1XCGAM?si=SS7UOKyBeSLqLwQC'),
(28, 'Subnautica: Below Zero', 'Unknown Worlds Entertainment', 'Explora y sobrevive en un océano alienígena congelado lleno de criaturas peligrosas, recursos escasos y misterios científicos.', 'subnautica-below-zero.webp', 6, '2021-05-14', 'https://www.youtube.com/embed/rdix1XxaZyU?si=fph0EbNzEJSWIz37'),
(29, 'Valheim', 'Iron Gate Studio', 'Un juego de supervivencia cooperativa ambientado en la mitología vikinga donde debes explorar, construir y conquistar enemigos en un mundo generado proceduralmente.', 'valheim.jpg', 6, '2021-02-02', 'https://www.youtube.com/embed/liQLtCLq3tc?si=sKMN1Tqa1nK0R4Dv'),
(30, 'The Long Dark', 'Hinterland Studio', 'Una experiencia inmersiva de supervivencia en solitario en un frío desierto canadiense tras un desastre geomagnético, sin zombis, solo tú contra la naturaleza.', 'The_Long_Dark.webp', 6, '2017-08-01', 'https://www.youtube.com/embed/PAKw7yokYFg?si=LAIhpMgKmnir5C2d');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuegos_probados`
--

CREATE TABLE `videojuegos_probados` (
  `id` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idVideojuego` int NOT NULL,
  `fecha_probado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `videojuegos_probados`
--

INSERT INTO `videojuegos_probados` (`id`, `idUsuario`, `idVideojuego`, `fecha_probado`) VALUES
(2, 1, 3, '2025-04-06 15:49:58'),
(3, 1, 4, '2025-04-06 16:29:45'),
(16, 1, 5, '2025-04-06 18:11:43'),
(20, 1, 6, '2025-04-06 18:13:24'),
(22, 1, 14, '2025-04-06 18:15:02'),
(29, 1, 15, '2025-04-06 18:31:01'),
(85, 1, 2, '2025-04-06 20:55:51'),
(86, 1, 9, '2025-04-06 20:57:36'),
(89, 5, 4, '2025-04-06 20:59:01'),
(92, 5, 3, '2025-04-06 21:05:33'),
(93, 5, 19, '2025-04-13 19:56:18'),
(113, 5, 10, '2025-04-14 15:11:54'),
(114, 5, 9, '2025-04-14 15:12:02'),
(150, 1, 18, '2025-04-14 19:28:18'),
(152, 1, 11, '2025-04-15 00:00:13'),
(175, 1, 23, '2025-04-15 00:21:10'),
(177, 1, 19, '2025-04-15 00:22:45'),
(181, 1, 20, '2025-04-15 00:29:08'),
(182, 1, 21, '2025-04-15 00:29:16'),
(191, 3, 1, '2025-04-15 15:02:21'),
(204, 4, 21, '2025-04-15 15:11:18'),
(206, 3, 4, '2025-04-15 15:14:53'),
(207, 3, 3, '2025-04-15 15:25:28'),
(214, 3, 5, '2025-04-15 15:32:35'),
(216, 3, 6, '2025-04-15 15:32:56'),
(235, 3, 8, '2025-04-15 17:45:40'),
(238, 3, 24, '2025-04-15 17:49:23'),
(239, 3, 18, '2025-04-15 18:16:31'),
(241, 3, 14, '2025-04-15 18:18:01'),
(242, 5, 8, '2025-04-16 00:22:14'),
(248, 2, 1, '2025-04-19 17:08:30'),
(249, 2, 15, '2025-04-19 17:11:18'),
(250, 2, 18, '2025-04-19 17:11:55'),
(251, 2, 9, '2025-04-19 17:12:34'),
(260, 4, 19, '2025-05-23 00:43:18'),
(270, 4, 26, '2025-05-29 17:48:13'),
(279, 4, 23, '2025-06-01 22:04:56'),
(284, 1, 1, '2025-06-06 23:37:18'),
(286, 4, 2, '2025-06-07 16:33:31'),
(311, 5, 2, '2025-06-07 18:49:18'),
(322, 4, 1, '2025-06-07 23:37:17'),
(326, 5, 1, '2025-06-08 14:43:20'),
(327, 2, 24, '2025-06-08 22:27:03'),
(328, 2, 13, '2025-06-10 22:21:12'),
(329, 3, 22, '2025-06-11 17:01:24'),
(330, 3, 25, '2025-06-11 17:01:51'),
(332, 3, 26, '2025-06-11 17:24:50'),
(333, 3, 27, '2025-06-11 17:25:12'),
(334, 3, 28, '2025-06-11 17:25:27'),
(335, 3, 29, '2025-06-11 17:25:46'),
(336, 3, 30, '2025-06-11 17:26:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPelicula` (`idVideojuego`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idPelicula` (`idVideojuego`);

--
-- Indices de la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idVideojuego` (`idVideojuego`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idPelicula` (`idVideojuego`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `videojuegos_probados`
--
ALTER TABLE `videojuegos_probados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idPelicula` (`idVideojuego`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=488;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `videojuegos_probados`
--
ALTER TABLE `videojuegos_probados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idVideojuego`) REFERENCES `videojuegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`idVideojuego`) REFERENCES `videojuegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD CONSTRAINT `puntuaciones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `puntuaciones_ibfk_2` FOREIGN KEY (`idVideojuego`) REFERENCES `videojuegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`idVideojuego`) REFERENCES `videojuegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  ADD CONSTRAINT `videojuegos_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videojuegos_probados`
--
ALTER TABLE `videojuegos_probados`
  ADD CONSTRAINT `videojuegos_probados_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videojuegos_probados_ibfk_2` FOREIGN KEY (`idVideojuego`) REFERENCES `videojuegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
