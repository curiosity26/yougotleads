<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:53 PM
 */

namespace YGL\Leads\Contact;


use YGL\YGLJsonObject;

class YGLContact extends YGLJsonObject
{
    protected $uniqueId = 'contactId';

    public function __construct($values = null)
    {
        $this->_properties = array(
            'contactId' => self::integerProperty(),
            'addressId' => self::integerProperty(),
            'address' => self::addressProperty(),
            'allowContact' => self::booleanProperty(),
            'dateOfBirth' => self::datetimeProperty(),
            'firstName' => self::stringProperty(45),
            'lastName' => self::stringProperty(45),
            'gender' => self::stringProperty(1),
            'isInquirer' => self::booleanProperty(),
            'maritalStatus' => self::stringProperty(1),
            'relationToResident' => self::integerProperty()
        );

        parent::__construct((array)$values);
    }
} 