-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2012 at 11:28 a.m.
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `estimulos`
--
DROP DATABASE estimulos;
CREATE DATABASE IF NOT EXISTS estimulos;
USE estimulos;
-- --------------------------------------------------------

--
-- Table structure for table `acuse`
--

CREATE TABLE IF NOT EXISTS `acuse` (
  `folio` int(10) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `RFC` varchar(10) NOT NULL DEFAULT '',
  `idempleado` varchar(6) DEFAULT NULL,
  `programa_educativo` varchar(255) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`folio`),
  KEY `RFC` (`RFC`),
  KEY `anio` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acuse`
--


-- --------------------------------------------------------

--
-- Table structure for table `asignacion_indicador`
--

CREATE TABLE IF NOT EXISTS `asignacion_indicador` (
  `id_asignacionindicador` int(11) NOT NULL,
  `id_categoriaindicador` int(11) DEFAULT NULL,
  `RFC_docente` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  `doc_evidencia` varchar(50) DEFAULT NULL, 
  PRIMARY KEY (`id_asignacionindicador`),
  KEY `index_catindicador` (`id_categoriaindicador`),
  KEY `index_anio5` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asignacion_indicador`
--


-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  KEY `index_anio1` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripcion`, `anio`) VALUES
(1, 'Formación Académica', NULL),
(2, 'Evaluación del Desempeño Docente', NULL),
(3, 'Atención a estudiantes', NULL),
(4, 'Producción académica', NULL),
(5, 'Vinculación academica', NULL),
(6, 'Participación Institucional', NULL),
(7, 'Actualización y superación académica ', NULL),
(8, 'Participación en Cuerpos Colegiados ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categoria_indicador`
--

CREATE TABLE IF NOT EXISTS `categoria_indicador` (
  `id_categoriaindicador` int(11) NOT NULL,
  `id_indicador` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_categoriaindicador`),
  KEY `fk_categoria` (`id_categoria`),
  KEY `fk_indicador` (`id_indicador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria_indicador`
--

INSERT INTO `categoria_indicador` (`id_categoriaindicador`, `id_indicador`, `id_categoria`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 2),
(6, 6, 2),
(7, 7, 3),
(8, 8, 3),
(9, 9, 3),
(10, 10, 3),
(11, 11, 4),
(12, 12, 4),
(13, 13, 4),
(14, 14, 5),
(15, 15, 5),
(16, 16, 6),
(17, 17, 6),
(18, 18, 6),
(19, 19, 6),
(20, 20, 6),
(21, 21, 6),
(22, 22, 6),
(23, 23, 7),
(24, 24, 7),
(25, 25, 7),
(26, 26, 7),
(27, 27, 7),
(28, 28, 7),
(29, 29, 7),
(30, 30, 8),
(31, 31, 8),
(32, 32, 8),
(33, 33, 8);

-- --------------------------------------------------------

--
-- Table structure for table `evaluacion`
--

CREATE TABLE IF NOT EXISTS `evaluacion` (
  `anio` int(4) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_captura` date DEFAULT NULL,
  `fecha_limite_captura` date DEFAULT NULL,
  `fecha_evaluacion` date DEFAULT NULL,
  `fecha_limite_evaluacion` date DEFAULT NULL,
  PRIMARY KEY (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `evaluacion_indicador`
--

CREATE TABLE IF NOT EXISTS `evaluacion_indicador` (
  `id_evaluacionindicador` int(11) NOT NULL,
  `id_categoriaindicador` int(11) DEFAULT NULL,
  `RFC_docente` varchar(10) DEFAULT NULL,
  `id_porcentajeindicador` int(11) DEFAULT NULL,
  `cal_porcentaje` int(11) DEFAULT NULL,
  `RFC_evaluador` varchar(10) DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_evaluacionindicador`),
  KEY `index_categoriaindicad` (`id_categoriaindicador`),
  KEY `index_porcentaje` (`id_porcentajeindicador`),
  KEY `index_anio3` (`anio`),
  KEY `index_evaluadorr` (`RFC_evaluador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluacion_indicador`
--


-- --------------------------------------------------------

--
-- Table structure for table `evaluador`
--

CREATE TABLE IF NOT EXISTS `evaluador` (
  `RFC_evaluador` varchar(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`RFC_evaluador`),
  KEY `index_anio6` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluador`
--


-- --------------------------------------------------------

--
-- Table structure for table `indicador`
--

CREATE TABLE IF NOT EXISTS `indicador` (
  `id_indicador` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_indicador`),
  KEY `index_anio2` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indicador`
--

INSERT INTO `indicador` (`id_indicador`, `descripcion`, `anio`) VALUES
(0, NULL, NULL),
(1, 'Posgrado en el área técnica de adscripción', NULL),
(2, 'Certificación (en área del conocimiento que desarrolla).', NULL),
(3, 'Certificación en competencias laborales.', NULL),
(4, 'Certificación en idioma extranjero.', NULL),
(5, 'Evaluación por los estudiantes. ', NULL),
(6, 'Evaluación por el director del Programa Educativo', NULL),
(7, 'Evaluación al Tutor por los estudiantes', NULL),
(8, 'Asesoría académica extraclase que contribuye a la disminución de indicadores de reprobación y deserción.', NULL),
(9, 'Asesoría académica para estudiantes que participen en concursos académicos (emprendedores, leamos la ciencia para todos, innovación tecnológica, entre otros).', NULL),
(10, 'Impartir talleres culturales y actividades deportivas y conferencias afines a una formación integral.', NULL),
(11, 'Elaboración  y aplicación de material didáctico de apoyo a la docencia.', NULL),
(12, 'Publicaciones.', NULL),
(13, 'Participación en desarrollo de proyectos de investigación y/o aplicación del conocimiento (prototipos y proyectos).', NULL),
(14, 'Diseño e impartición de Cursos de educación continua.', NULL),
(15, 'Participación en servicios tecnológicos; los cuales generen preferentemente recursos a la institución.', NULL),
(16, 'Organización de eventos académicos del Programa Educativo o Institucionales.', NULL),
(17, 'Desarrollo o elaboración de Proyectos/Programas académicos (POA, PIFI, PIDE, Autoevaluaciones, Acreditación, Tres por Uno, PADES, entre otros).', NULL),
(18, 'Auditor interno del Sistema de Gestión de Calidad.', NULL),
(19, 'Coolaboración/Desempeño en los diferentes Programas Institucionales  (Valores, Sustentabilidad,  entre otros).', NULL),
(20, 'Desempeño como Tutor, Asesor académico o de Idiomas para Movilidad estudiantil.', NULL),
(21, 'Gestión y colaboración en convenios que contribuyan al logro de la misión institucional.', NULL),
(22, 'Actividades o estrategias que contribuyan a la mejora de los estándares institucionales como: Eficiencia terminal, Índice de Aprobación, EGETSU', NULL),
(23, 'Realiza estudios de Posgrado en el área técnica de su adscripción.', NULL),
(24, 'Asistencia y acreditación de la capacitación técnica a la que asiste.', NULL),
(25, 'Asistencia y acreditación de la capacitación didáctico – pedagógica ', NULL),
(26, 'Presentación de conferencias ó curso – taller en eventos académicos de la institución.', NULL),
(27, 'Presentación de ponencias o trabajos en congresos o eventos académicos nacionales.', NULL),
(28, 'Presentación de ponencias o trabajos en congresos o eventos académicos internacionales.', NULL),
(29, 'Premio o reconocimiento en evento académico regional, estatal o nacional.', NULL),
(30, 'Integrante de Comisiones Institucionales (Dictaminadora, Disciplinaria, entre otras).', NULL),
(31, 'Par evaluador (PIFI, CIEES, COPAES, entre otros)', NULL),
(32, 'Redes de colaboración con otros CA ', NULL),
(33, 'Reconocimiento a perfil deseable de PROMEP', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

CREATE TABLE IF NOT EXISTS `participantes` (
  `RFC` varchar(10) NOT NULL DEFAULT '',
  `fecha` datetime DEFAULT NULL,
  `estado` enum('0','1') NOT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`RFC`),
  KEY `RFC` (`RFC`),
  KEY `anio` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participantes`
--


-- --------------------------------------------------------

--
-- Table structure for table `permisos_especiales`
--

CREATE TABLE IF NOT EXISTS `permisos_especiales` (
  `RFC` varchar(10) NOT NULL DEFAULT '',
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`RFC`),
  KEY `RFC` (`RFC`),
  KEY `anio` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permisos_especiales`
--


-- --------------------------------------------------------

--
-- Table structure for table `porcentaje_indicador`
--

CREATE TABLE IF NOT EXISTS `porcentaje_indicador` (
  `id_porcentajeindicador` int(11) NOT NULL,
  `id_categoriaindicador` int(11) DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_porcentajeindicador`),
  KEY `index_categoriaindicador` (`id_categoriaindicador`),
  KEY `index_anio4` (`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `porcentaje_indicador`
--

INSERT INTO `porcentaje_indicador` (`id_porcentajeindicador`, `id_categoriaindicador`, `porcentaje`, `descripcion`, `anio`) VALUES
(1, 1, 3, 'Puntuación máxima', NULL),
(2, 2, 2, 'Puntuación máxima', NULL),
(3, 3, 2, 'Puntuación máxima', NULL),
(4, 4, 2, 'Puntuación máxima', NULL),
(5, 5, 5, 'Aceptable', NULL),
(6, 6, 5, 'Aceptable', NULL),
(7, 7, 5, 'Aceptable', NULL),
(8, 8, 2, 'Puntuación máxima', NULL),
(9, 9, 2, 'Puntuación máxima', NULL),
(10, 10, 2, 'Puntuación máxima', NULL),
(11, 11, 5, 'Puntuación máxima', NULL),
(12, 12, 7, 'Revista arbitrada y no arbitrada ', NULL),
(13, 13, 5, 'Puntuación máxima', NULL),
(14, 14, 3, 'Puntuación máxima', NULL),
(15, 15, 5, 'Puntuación máxima', NULL),
(16, 16, 2, 'Puntuación máxima', NULL),
(17, 17, 3, 'Puntuación máxima', NULL),
(18, 18, 2, 'Puntuación máxima', NULL),
(19, 19, 3, 'Puntuación máxima', NULL),
(20, 20, 3, 'Puntuación máxima', NULL),
(21, 21, 2, 'Puntuación máxima', NULL),
(22, 20, 3, 'Puntuación máxima', NULL),
(23, 23, 3, 'Puntuación máxima', NULL),
(24, 24, 3, 'Puntuación máxima', NULL),
(25, 25, 3, 'Puntuación máxima', NULL),
(26, 26, 3, 'Puntuación máxima', NULL),
(27, 27, 3, 'Puntuación máxima', NULL),
(28, 28, 3, 'Puntuación máxima', NULL),
(29, 29, 3, 'Puntuación máxima', NULL),
(30, 30, 3, 'Puntuación máxima', NULL),
(31, 31, 3, 'Puntuación máxima', NULL),
(32, 32, 3, 'Puntuación máxima', NULL),
(33, 33, 3, 'Puntuación máxima', NULL),
(34, 5, 4, 'Satisfactorio', NULL),
(35, 6, 4, 'Satisfactorio', NULL),
(36, 7, 4, 'Satisfactorio', NULL),
(37, 12, 2, 'Revista no arbitrada ', NULL),
(38, 12, 5, 'Revista no arbitrada', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reportes`
--

CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(100) DEFAULT NULL,
  `path` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_reporte`),
  KEY `index_rfc` (`id_reporte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportes`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `acuse`
--
ALTER TABLE `acuse`
  ADD CONSTRAINT `fk_acuse_participantes` FOREIGN KEY (`anio`) REFERENCES `participantes` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `asignacion_indicador`
--
ALTER TABLE `asignacion_indicador`
  ADD CONSTRAINT `fk_anio5` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_catindicador` FOREIGN KEY (`id_categoriaindicador`) REFERENCES `categoria_indicador` (`id_categoriaindicador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_anio1` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `categoria_indicador`
--
ALTER TABLE `categoria_indicador`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_indicador` FOREIGN KEY (`id_indicador`) REFERENCES `indicador` (`id_indicador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluacion_indicador`
--
ALTER TABLE `evaluacion_indicador`
  ADD CONSTRAINT `fk_anio3` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categoriaind` FOREIGN KEY (`id_categoriaindicador`) REFERENCES `categoria_indicador` (`id_categoriaindicador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evaluador` FOREIGN KEY (`RFC_evaluador`) REFERENCES `evaluador` (`RFC_evaluador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_porcentaje` FOREIGN KEY (`id_porcentajeindicador`) REFERENCES `porcentaje_indicador` (`id_porcentajeindicador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluador`
--
ALTER TABLE `evaluador`
  ADD CONSTRAINT `fk_anio6` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `indicador`
--
ALTER TABLE `indicador`
  ADD CONSTRAINT `fk_anio2` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `fk_evaluacion_participantes` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permisos_especiales`
--
ALTER TABLE `permisos_especiales`
  ADD CONSTRAINT `fk_evaluacion_permisos` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `porcentaje_indicador`
--
ALTER TABLE `porcentaje_indicador`
  ADD CONSTRAINT `fk_anio4` FOREIGN KEY (`anio`) REFERENCES `evaluacion` (`anio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categoriaindicador` FOREIGN KEY (`id_categoriaindicador`) REFERENCES `categoria_indicador` (`id_categoriaindicador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
