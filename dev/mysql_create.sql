-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2012 at 07:37 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `creditors_drazobnik`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formatted` text,
  `familyName` text,
  `givenName` text,
  `honorificPrefix` text,
  `honorificSuffix` text,
  `middleName` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact_addresses`
--

CREATE TABLE IF NOT EXISTS `contact_addresses` (
  `entityId` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `primary` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`entityId`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_emails`
--

CREATE TABLE IF NOT EXISTS `contact_emails` (
  `entityId` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT '',
  `primary` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`entityId`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_identity`
--

CREATE TABLE IF NOT EXISTS `contact_identity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactId` int(11) NOT NULL DEFAULT '0',
  `identityId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact_phonenumbers`
--

CREATE TABLE IF NOT EXISTS `contact_phonenumbers` (
  `entityId` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `primary` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`entityId`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `identity`
--

CREATE TABLE IF NOT EXISTS `identity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `ownerId` int(11) DEFAULT NULL,
  `roleId` text,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `identity_auth_credential`
--

CREATE TABLE IF NOT EXISTS `identity_auth_credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `passwordHash` text,
  `identityId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `identity_registration`
--

CREATE TABLE IF NOT EXISTS `identity_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identityId` int(11) DEFAULT NULL,
  `data` text,
  `requestIp` varchar(32) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `location_address`
--

CREATE TABLE IF NOT EXISTS `location_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building` text,
  `country` text,
  `floor` text,
  `latitude` text,
  `longitude` text,
  `locality` text,
  `postalCode` text,
  `region` text,
  `streetAddress` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
