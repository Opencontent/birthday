{*
    $attribute.content.year - year
    $attribute.content.month - month
    $attribute.content.day - day
    $attribute.content.zodiac - returns the name of the zodiac
    $attribute.content.zodiac_no - returns the number of the zodiac
    $attribute.content.is_valid - returns true, if the date is correct
    $attribute.content.days_on_earth - returns number of days from date to now
*}
{if $attribute.content.is_valid}
    {makedate( $attribute.content.month, $attribute.content.day, 1990)|datetime( 'custom', '%d %F' )} {$attribute.content.year}
{/if}