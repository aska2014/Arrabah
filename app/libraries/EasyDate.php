<?php

class EasyDate {

	/**
	 * Calculate age from the given birthDate.
	 *
	 * @param  Datetime $birthDate
	 * @return DateInterval
	 */
	public static function calculateAge( Datetime $birthDate )
	{
		$now = new DateTime();

	    return $now->diff($birthDate);
	}

	/**
	 * Get arabic date from the given format and date.
	 *
	 * @param  string $format
	 * @param  string $date
	 * @return string
	 */
	public static function arabic( $format, $date )
	{
		if(!static::valid( $date )) return '';
		
		$dateTime = strtotime( $date );

		$Ar = new arabic\ArabicDate('Date');
		  
		$fix = $Ar->dateCorrection (time());
		  
		$Ar->setMode(3);

		return $Ar->date($format, $dateTime, $fix); 
	}

	/**
	 * Get sql date format.
	 *
	 * @param  string $date
	 * @return string
	 */
	public static function sql( $date )
	{
		return date('Y-m-d H:i:s', strtotime($date));
	}

	/**
	 * Return true if the given date is valid (!= 1970/01/01)
	 *
	 * @return bool
	 */
	public static function valid( $date )
	{
		return strtotime($date) != strtotime('01/01/1970');
	}

}