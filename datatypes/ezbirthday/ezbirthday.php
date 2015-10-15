<?php

class eZBirthday
{
    function eZBirthday( $birthday = array() )
    {
        if ( is_array( $birthday ) and count( $birthday ) > 0 )
        {
            $this->Day = $birthday["day"];
            $this->Month = $birthday["month"];
            $this->Year = $birthday["year"];

            if ( checkdate( $this->Month, $this->Day, $this->Year ) !== false )
            {
                $zodiac = eZBirthday::get_zodiac_sign( $this->Month, $this->Day );

                if ( is_array( $zodiac ) and count( $zodiac ) > 0 )
                {
                    $this->Zodiac_Nr = $zodiac["Number"];
                    $this->Zodiac_No = $this->Zodiac_Nr;
                    $this->Zodiac_Name = $zodiac["Name"];
                }

                $this->Days_On_Earth = abs( eZBirthday::gregorianToJD( $this->Month,
                                                                       $this->Day,
                                                                       $this->Year ) -
                                                                       eZBirthday::gregorianToJD(
                                                                         date( "m" ),
                                                                         date( "d" ),
                                                                         date( "Y" ) ) );
            }
        }
    }

    function gregorianToJD( $month,$day,$year )
    {
        if ( $month > 2 )
            $month = $month - 3;
        else
        {
            $month = $month + 9;
            $year = $year - 1;
        }

        $c = floor( $year / 100 );
        $ya = $year - ( 100 * $c );
        $j = floor( ( 146097 * $c ) / 4 );
        $j += floor( ( 1461 * $ya ) / 4 );
        $j += floor( ( ( 153 * $month ) + 2 ) / 5 );
        $j += $day + 1721119;

        return $j;
    }

    function attributes()
    {
        return array( 'day',
                      'month',
                      'year',
                      'is_valid',
                      'zodiac_nr',
                      'zodiac_no',
                      'zodiac_name',
                      'days_on_earth',
                      'has_content' );
    }

    function hasAttribute( $name )
    {
        $attributes = eZBirthday::attributes();
        if ( in_array( $name, $attributes ) )
            return true;
        else
            return false;
    }

    function get_zodiac_sign( $month, $day )
    {
        // Check arguments for validity
        if ( $month < 1 || $month > 12 || $day < 1 || $day > 31 )
            return array();

        // List of zodiac signs with start day (start month is array-index + 1)
        $signs = array(
                   array( "20" =>  "11" ),
                   array( "19" =>  "12" ),
                   array( "21" =>  "1" ),
                   array( "20" =>  "2" ),
                   array( "21" =>  "3" ),
                   array( "22" =>  "4" ),
                   array( "23" =>  "5" ),
                   array( "23" =>  "6" ),
                   array( "23" =>  "7" ),
                   array( "24" =>  "8" ),
                   array( "22" =>  "9" ),
                   array( "22" =>  "10" )
                   );

        $name = array(  1 =>  ezi18n( 'kernel/classes/datatypes', 'Aries' ),
                        2 =>  ezi18n( 'kernel/classes/datatypes', 'Taurus' ),
                        3 =>  ezi18n( 'kernel/classes/datatypes', 'Gemini' ),
                        4 =>  ezi18n( 'kernel/classes/datatypes', 'Cancer' ),
                        5 =>  ezi18n( 'kernel/classes/datatypes', 'Leo' ),
                        6 =>  ezi18n( 'kernel/classes/datatypes', 'Virgio' ),
                        7 =>  ezi18n( 'kernel/classes/datatypes', 'Libra' ),
                        8 =>  ezi18n( 'kernel/classes/datatypes', 'Scorpio' ),
                        9 =>  ezi18n( 'kernel/classes/datatypes', 'Sagittarius' ),
                        10 => ezi18n( 'kernel/classes/datatypes', 'Capricorn' ),
                        11 => ezi18n( 'kernel/classes/datatypes', 'Aquarius' ),
                        12 => ezi18n( 'kernel/classes/datatypes', 'Pisces' ),
                    );

        list( $sign_start, $sign_name ) = each( $signs[(int)$month-1] );
        if ( $day < $sign_start )
            list( $sign_start, $sign_name ) = each( $signs[( $month -2 < 0 ) ? $month = 11: $month -= 2] );
        return array( "Number" => $sign_name, "Name" => $name[$sign_name] );
    }

   function attribute( $name )
    {
        switch ( $name )
        {
            case "day":
            {
                return $this->Day;
            }break;

            case "month":
            {
                return $this->Month;
            }break;

            case "year":
            {
                return $this->Year;
            }break;

            case "has_content":
            case "is_valid":
            {
                return checkdate( $this->Month, $this->Day, $this->Year );
            }break;

            case "zodiac_no":
            case "zodiac_nr":
            {
                return $this->Zodiac_No;
            }break;

            case "zodiac_name":
            {
                return $this->Zodiac_Name;
            }break;

            case "days_on_earth" :
            {
                return $this->Days_On_Earth;
            }break;
        }
    }

    var $Day;
    var $Month;
    var $Year;
    var $Zodiac_Nr;
    var $Zodiac_No;
    var $Zodiac_Name;
    var $Days_On_Earth;
}
?>
