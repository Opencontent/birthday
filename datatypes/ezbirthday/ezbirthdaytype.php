<?php
//
// Definition of eZDateType class
//
// Created on: <26-Apr-2002 16:53:04 bf>
//
// Copyright (C) 1999-2004 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

//!! eZKernel
//! The class eZDateType
/*!
*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "extension/birthday/datatypes/ezbirthday/ezbirthday.php" );

define( "EZ_DATATYPESTRING_BIRTHDAY", "ezbirthday" );
define( 'EZ_DATATYPESTRING_BIRTHDAY_DEFAULT', 'data_text1' );
define( 'EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_EMTPY', 0 );
define( 'EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_CURRENT_DATE', 1 );

class eZBirthdayType extends eZDataType
{
    function eZBirthdayType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_BIRTHDAY, ezi18n( 'kernel/classes/datatypes', "Birthday", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );

    }

    function addZero( $value )
    {
        return sprintf("%02d", $value);
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $year = $day = $month = '';

        if ( $http->hasPostVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $year = $http->postVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) );
            $month = $http->postVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) );
            $day = $http->postVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) );
        }

        $classAttribute = $contentObjectAttribute->contentClassAttribute();

        if ( ( ( $classAttribute->attribute( "is_required" ) == false ) and
             $year == '' and $month == '' and $day == '' ) or
             $classAttribute->attribute( 'is_information_collector' ) )
        {
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        }

        if ( $classAttribute->attribute( "is_required" ) and
             $year == '' or $month == '' or $day == '' )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                 'Missing date input.' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }

        $datetime = checkdate( $month, $day, $year );
        if ( $datetime !== false )
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;

        return EZ_INPUT_VALIDATOR_STATE_INVALID;
    }

    /*!
     Validates the InformationCollection input and returns true if the input was
     valid for this datatype.
    */
    function validateCollectionAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $year = $day = $month = '';
        if ( $http->hasPostVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $year = $http->postVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) );
            $month = $http->postVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) );
            $day = $http->postVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) );
        }

        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        if ( ( $classAttribute->attribute( "is_required" ) == false ) and
             $year == '' and $month == '' and $day == '' )
        {
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        }
        if ( $classAttribute->attribute( "is_required" ) and
             $year == '' or $month == '' or $day == '' )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                 'Missing date input.' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }

        $datetime = checkdate( $month, $day, $year );

        if ( $datetime !== false )
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;

        return EZ_INPUT_VALIDATOR_STATE_INVALID;
    }

    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $year = $day = $month = '';
        if ( $http->hasPostVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) ) and
             $http->hasPostVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $year = $http->postVariable( $base . "_birthday_year_" . $contentObjectAttribute->attribute( "id" ) );
            $month = $http->postVariable( $base . "_birthday_month_" . $contentObjectAttribute->attribute( "id" ) );
            $day = $http->postVariable( $base . "_birthday_day_" . $contentObjectAttribute->attribute( "id" ) );
        }

        if ( $year == '' or $month == '' or $day == '' )
        {
            $date = null;
        }
        else
            $date = $year . '-'.eZBirthdayType::addZero( $month ) . '-'. eZBirthdayType::addZero( $day );

        $contentObjectAttribute->setAttribute( "data_text", $date );
        return true;
    }

    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( &$collection, &$collectionAttribute, &$http, $base, &$contentObjectAttribute )
    {
        $year = $day = $month = '';
        if ( $http->hasPostVariable( $base . '_birthday_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_birthday_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_birthday_day_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {

            $year  = $http->postVariable( $base . '_birthday_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month = $http->postVariable( $base . '_birthday_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day   = $http->postVariable( $base . '_birthday_day_' . $contentObjectAttribute->attribute( 'id' ) );
            //$date = new eZDate();
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();

            if ( $year == '' or $month == '' or $day == '' )
                $date = NULL;
            else
                $date = $year . '-'.eZBirthdayType::addZero( $month ) . '-'. eZBirthdayType::addZero( $day );

            $collectionAttribute->setAttribute( 'data_text', $date );
            return true;
        }
        return false;
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        $dateStr = $contentObjectAttribute->attribute( 'data_text' );
        if ( ereg( "([0-9]{4})-([0-9]{2})-([0-9]{2})", $dateStr, $valueArray ) )
        {
            $year = $valueArray[1];
            $month =  $valueArray[2];
            $day = $valueArray[3] ;
            $birthday = new eZBirthday( array ("year" => $year, "month" => $month, "day" => $day ) );
        }
        else
            $birthday = new eZBirthday();
        return $birthday;
    }

    /*!
     Set class attribute value for template version
    */
    function initializeClassAttribute( &$classAttribute )
    {
        if ( $classAttribute->attribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT ) == null )
            $classAttribute->setAttribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT, 0 );
        $classAttribute->store();
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( &$contentObjectAttribute, $currentVersion, &$originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataText = $originalContentObjectAttribute->attribute( "data_text" );
            $contentObjectAttribute->setAttribute( "data_text", $dataText );
        }
        else
        {
            $contentClassAttribute =& $contentObjectAttribute->contentClassAttribute();
            $defaultType = $contentClassAttribute->attribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT );
            if ( $defaultType == 1 )
            {
                $day = eZBirthdayType::addZero( date( 'd' ) );
                $month = eZBirthdayType::addZero( date( 'm' ) );
                $year = date('Y');
                $contentObjectAttribute->setAttribute( "data_text", $year . "-" . $month . "-" . $day );
            }
        }
    }

    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $default = $base . "_ezbirthday_default_" . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $default ) )
        {
            $defaultValue = $http->postVariable( $default );
            $classAttribute->setAttribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT,  $defaultValue );
        }
        return true;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    /*!
     Returns the date.
    */
    function title( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }

    function hasObjectAttributeContent( &$contentObjectAttribute )
    {
        return ( strlen( $contentObjectAttribute->attribute( "data_text" ) ) > 0 );
    }

    /*!
     \reimp
    */
    function sortKey( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    function sortKeyType()
    {
        return 'string';
    }

    /*!
     \reimp
    */
    function serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $defaultValue = $classAttribute->attribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT );
        switch ( $defaultValue )
        {
            case EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_EMTPY:
            {
                $attributeParametersNode->appendChild( eZDOMDocument::createElementNode( 'default-value',
                                                                                         array( 'type' => 'empty' ) ) );
            } break;
            case EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_CURRENT_DATE:
            {
                $attributeParametersNode->appendChild( eZDOMDocument::createElementNode( 'default-value',
                                                                                         array( 'type' => 'current-date' ) ) );
            } break;
        }
    }

    /*!
     \reimp
    */
    function unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $defaultNode =& $attributeParametersNode->elementByName( 'default-value' );
        $defaultValue = strtolower( $defaultNode->attributeValue( 'type' ) );
        switch ( $defaultValue )
        {
            case 'empty':
            {
                $classAttribute->setAttribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT, EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_EMTPY );
            } break;
            case 'current-date':
            {
                $classAttribute->setAttribute( EZ_DATATYPESTRING_BIRTHDAY_DEFAULT, EZ_DATATYPESTRING_BIRTHDAY_DEFAULT_CURRENT_DATE );
            } break;
        }
    }

    /*!
     \return the collect information action if enabled
    */
    function contentActionList( &$classAttribute )
    {
        if ( $classAttribute->attribute( 'is_information_collector' ) == true )
        {
            return array( array( 'name' => 'Send',
                                 'action' => 'ActionCollectInformation'
                                 ) );
        }
        else
            return array();
    }

    function isIndexable()
    {
        return true;
    }

    /*!
     \reimp
    */
    function isInformationCollector()
    {
        return true;
    }

}

eZDataType::register( EZ_DATATYPESTRING_BIRTHDAY, "ezbirthdaytype" );

?>
