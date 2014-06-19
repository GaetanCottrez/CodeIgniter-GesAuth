<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper for WebGes
 *
 * Copyright (C) 2014 Gaëtan Cottrez.
 *
 *
 * @package    	WebGes
 * @copyright  	Copyright (c) 2014, Gaëtan Cottrez
 * @license
 * @version    	1.0
 * @author 		Gaëtan Cottrez <gaetan.cottrez@laviedunwebdeveloper.com>
 *
 *
 */




/**
  * Fonction permettant de faire un versioning d'un fichier JS, CSS et m�me image
  * pour forcer le navigateur � rafraichir son cache et � prendre en compte les changements
  * effectu�s dans le fichier
  *
  * @access public
  * @property string $link_file, string $versionning
  * @param string $link_file contient le chemin du fichier
  * @param string $versionning le num�ro de version � appliquer au fichier
  * @return string $link_file_versioning
  */

if ( ! function_exists('versioning_name_files'))
{
	function versioning_name_files($link_file,$versioning='1.0'){
		if($versioning == null || $versioning =='') $versioning='1.0';
		$link_file_versioning = $link_file.'?ver='.$versioning;
		return $link_file_versioning;
	}
}

/**
  * Fonction permettant de convertir en seconde microtime()
  *
  * @access public
  * @property string $date
  * @param string $date contient la date au format anglais
  * @return string $date
  */

if ( ! function_exists('microtime_float'))
{
	function microtime_float(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
}

/**
  * Fonction de convertion des dates anglaise en francais
  *
  * @access public
  * @property string $date
  * @param string $date contient la date au format anglais
  * @return string $date
  */

if ( ! function_exists('datefr'))
{
	function datefr($date) {
	  $order   = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	  $replace = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche', 'janvier', 'f�vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao�t', 'septembre', 'octobre', 'novembre', 'd�cembre');
	  $date = str_replace($order, $replace, $date);

	  return $date;
	}
}
/**
  * Fonction addslashes plus puissantes
  *
  * @access public
  * @property string $string
  * @param string $string contient la date au format anglais
  * @return string
  */

if ( ! function_exists('myaddslashes'))
{
	function myaddslashes($string) {
	  return ( get_magic_quotes_gpc() ) ? $string : addslashes($string);
	}
}
/**
  * Fonction donne l'adresse IP du client
  *
  * @access public
  * @return string
  */

if ( ! function_exists('GetIP'))
{
	function GetIP() {
		if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;

	}
}

/**
  * Fonction permettant de convertir le format d'une date fr (DD/MM/YYYY) en date en (YYYY-MM-DD)
  *
  * @access public
  * @property string $date
  * @param string $date contient la date au format fran�ais
  * @return string $date au format anglais
  */

if ( ! function_exists('ConvertDateFormatFrToEn'))
{
	function ConvertDateFormatFrToEn($date){
		$date = str_replace('/', '-', $date);
		return date('Y-m-d', strtotime($date));
	}
}
/**
  * Fonction permettant de convertir un nombre MySQL en un nombre format� WebGes
  *
  * @access public
  * @property string $number
  * @param string $number contient le nombre MySQL
  * @return string au format nombre WebGes
  */

if ( ! function_exists('ConvertNumberMySQLForWebGes'))
{
	function ConvertNumberMySQLForWebGes($number=0,$decimal=2){
		if($number == '' || $number == NULL) $number = 0;
		return number_format($number,$decimal,',','.');
	}
}
/**
   * Fonction permettant de convertir un nombre format� WebGes en un nombre MySQL
  *
  * @access public
  * @property string $number
  * @param string $number contient le nombre WebGes
  * @return string au format nombre MySQL
  */

if ( ! function_exists('ConvertNumberWebGesForMySQL'))
{
	function ConvertNumberWebGesForMySQL($number){
		return str_replace(',','.',str_replace('.','',myaddslashes(trimUltime($number))));
	}
}
/**
  * Fonction permettant de convertir une date format� fr (DD/MM/YYYY)(MM/YYYY)(YYYY)
  * recherch�e dans une liste pour MySQL
  *
  * @access public
  * @property string $date
  * @param string $date contient la date fr format�e
  * @return string au format nombre MySQL
  */

if ( ! function_exists('ConvertDateSearchForMySQL'))
{
	function ConvertDateSearchForMySQL($date){
		$tmp = explode('/',$date);
		$timestamp = $tmp[count($tmp)-1].'-'.$tmp[count($tmp)-2].'-'.$tmp[count($tmp)-3];

		while(substr($timestamp,strlen($timestamp)-1,strlen($timestamp)) == '-'){
			$timestamp = substr($timestamp,0,strlen($timestamp)-1);
		}
		return $timestamp;
	}
}
/**
  * Fonction permettant de convertir le format d'une date MySQL (YYYY-MM-DD H:i:s) en un autre format de date et par d�faut une date fr (DD/MM/YYYY)
  *
  * @access public
  * @property string $date
  * @param string $date contient la date au format MySQL
  * @param string $param contient le format de date final
  * @return string $date au format anglais
  */

if ( ! function_exists('ConvertDateMySQLToWebGes'))
{
	function ConvertDateMySQLToWebGes($date,$param='d/m/Y'){
		if($date != "" && $date != NULL) return date($param, strtotime($date));
	}
}
/**
  * Fonction permettant de convertir oui/non en un bool�en MySQL
  * recherch�e dans une liste pour MySQL
  *
  * @access public
  * @property string $string
  * @param string $string contient oui/non
  * @return string pour bool�en (1 ou 0)
  */

if ( ! function_exists('ConvertYesOrNoSearchForMySQL'))
{
	function ConvertYesOrNoSearchForMySQL($string){
		switch(strtolower($string)){
			case 'oui':
				$Bool ='1';
				break;

			case 'non':
				$Bool ='0';
				break;

			default:
				$Bool ='-1';

		}
		return $Bool;
	}
}
/**
  * Fonction permettant de nettoyer une recherche universelle qui provient d'une liste
  *
  * @access public
  * @property string $search
  * @param string $search contient la recherche utilisateur
  * @return string $search_clean contient la recherche nettoy�e
  */

if ( ! function_exists('CleanSearchListWebGes'))
{
	function CleanSearchListWebGes($search){
		return trimUltime(myaddslashes(str_replace('"',"",$search)));
	}
}

/**
  * Fonction permettant d'afficher mes nom
  *
  * @access public
  * @property string $date
  * @param string $date contient le timestamp MySQL
  * @return string $date au format fran�ais
  */

if ( ! function_exists('ConvertTimestampMySQLToDateFr'))
{
	function ConvertTimestampMySQLToDateFr($date){
		return date('d/m/Y', strtotime($date));
	}
}

/**
  * Fonction am�lior� du trim
  * @property string $chaine
  * @param string $chaine
  * @access public
  * @return string $chaine
  */

if ( ! function_exists('ConvertTimestampMySQLToDateFr'))
{
	function trimUltime($chaine){
		$chaine = trim($chaine);
		$chaine = str_replace("\t", " ", $chaine);
		$chaine = eregi_replace("[ ]+", " ", $chaine);
		return $chaine;
	}
}

if ( ! function_exists('htmldump'))
{
	function htmldump($variable, $height="250px") {
		echo "<pre style=\"border: 1px solid #000; height: {$height}; overflow: auto; margin: 0.5em;\">";
		var_dump($variable);
		echo "</pre>\n";
	}
}
/* End of file webges_helper.php */
/* Location: ./application/helpers/webges_helper.php */