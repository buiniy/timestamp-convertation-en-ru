<?php
/*
 * @TimeCorrector
 */
class TimeCorrector 
{
	
	/*
	 * Static Time int's
	 */
	public static int $year_sec = 31536000;
	public static int $month_sec = 2592000;
	public static int $week_sec = 604800;
	public static int $day_sec = 86400;
	public static int $hour_sec = 3600;
	public static int $min_sec = 60;
	
	/*
	 * Static correct ru:Words
	 */
	public static array $ru_words = 
	[
		'year' => ['год', 'года', 'лет'],
		'month' => ['месяц', 'месяца', 'месяцев'],
		'week' => ['неделя', 'недели', 'недель'],
		'day' => ['день', 'дня', 'дней'],
		'hour' => ['час', 'часа', 'часов'],
		'min' => ['минута,', 'минуты,', 'минут,'],
		'sec' => ['секунда', 'секунды', 'секунд'],
	];
	
	/*
	 * Set default Timezone
	 */
	public static function setTimezone(string $TimeZone = "Europe/Moscow") : void 
	{
		date_default_timezone_set($TimeZone);
	}
	
	/*
	 * Get current date, 0 - Unix Time, other - Human visibility
	 */
	public function getCorrentDate($type = 0) : int 
	{
		if(!date_default_timezone_get("Europe/Moscow")) {
			self::setTimezone("Europe/Moscow");
		}
		return ($type == 0) ? date() : date("Y.m.d H:i:s"); 
	}
	
	/*
	 * Convert unixtime format to en:Word
	 */
	public function getConvertFormat(int $sec, $ago = 0) : string
	{
		$result = "";
		
		if($sec === 0 || $sec < 1) {
			return "Сейчас";
		}
		
        if (intval($sec / self::$year_sec) > 0) {
            $year = intval($sec / self::$year_sec);
            $sec = $sec - $year * self::$year_sec;
            $result = $this->CorrectString($year, 'year');
        }
        if (intval($sec / self::$month_sec) > 0) {
            $month = intval($sec / self::$month_sec);
            $sec = $sec - $month * self::$month_sec;
            $result .= $this->CorrectString($month, 'month');
        }
        if (intval($sec / self::$week_sec) > 0) {
            $week = intval($sec / self::$week_sec);
            $sec = $sec - $week * self::$week_sec;
            $result .= $this->CorrectString($week, 'week');
        }
        if (intval($sec / self::$day_sec) > 0) {
            $day = intval($sec / self::$day_sec);
            $sec = $sec - $day * self::$day_sec;
            $result .= $this->CorrectString($day, 'day');
        }
        if (intval($sec / self::$hour_sec) > 0) {
            $hour = intval($sec / self::$hour_sec);
            $sec = $sec - $hour * self::$hour_sec;
            $result .= $this->CorrectString($hour, 'hour');
        }
        if (intval($sec / self::$min_sec) > 0) {
            $min = intval($sec / self::$min_sec);
            $sec = $sec - $min * self::$min_sec;
            $result .= $this->CorrectString($min, 'min');
        }
        if ($sec > 0) {
            $result .= $this->CorrectString($sec, 'sec');
        }
		
		if($ago != 0) {
			$post = ($ago === 1) ? " назад" : "";
			return $result . $post;
		} else {
			return $result ;
		}
    }
	
	/*
	 * Get corrent ru:Words
	 */
	public function correctString($number, $type) {
		
		$number = (string) $number;
		
		if (strlen($number) > 1) {
            if ($number[strlen($number) - 2] . $number[strlen($number) - 1] == '11') {
                $LastNum = '10';
            } else {
                $LastNum = $number[strlen($number) - 1];
            }
        } else {
            $LastNum = $number[strlen($number) - 1];
        }
		switch($LastNum) {
			 case 1: $str = 0; break;
			 case 2:
			 case 3:
			 case 4: $str = 1; break;
			default: $str = 2; break;
		}
        return $number . " " . self::$ru_words[$type][$str] . " ";
	}
	
}
