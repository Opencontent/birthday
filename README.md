# Unofficial GitHub version of http://projects.ez.no/birthday

## Birthday Datatype

Brithday datatype from Georg Franz handed over to eZ and now into the projects.

In eZP 3 and 4 it's not possible to store dates before 1970 because the ezdate and ezdatetime datatype stores the dates in a unix-timestamp.
This datatype stores the date in the format of YYYY-MM-DD in the data_text field.

Version 1.0 is compatible with 3.9x and 3.10.x

Current trunk is compatible with 4.x

Special features:
-----------------
It's possible to show the zodiac of the given date as name or as number.
Joe's zodiac is
{$node.data_map.birthday.content.zodiac_name|wash} (Number
{$node.data_map.birthday.content.zodiac_nr|wash})
It's possible to show the number of days from the given date till now:
e.g.: Joe is
{$node.data_map.birthday.content.days_on_earth|number} days old ...
A german translation file is also available.
Comments / suggestions : gwf@verlagfranz.com
