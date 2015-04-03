<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:52 PM
 */

namespace YGL\Leads\Resident;


use YGL\YGLJsonObject;

class YGLLeadResident extends YGLJsonObject
{
    public function __construct($values = null)
    {
        $this->_properties = array(
            'age' => self::integerProperty(),
            'bathing' => self::integerProperty(),
            'careLevel' => self::integerProperty(),
            'currentLivingSituation' => self::integerProperty(),
            'dateOfBirth' => self::datetimeProperty(),
            'dressing' => self::integerProperty(),
            'driving' => self::integerProperty(),
            'eating' => self::integerProperty(),
            'estimatedAdmitDate' => self::datetimeProperty(),
            'hair' => self::integerProperty(),
            'hotButtons' => self::stringProperty(1000),
            'isDiabetic' => self::booleanProperty(),
            'laundry' => self::integerProperty(),
            'maritalStatus' => self::stringProperty(1),
            'meals' => self::integerProperty(),
            'medication' => self::integerProperty(),
            'memoryLoss' => self::integerProperty(),
            'physicial' => self::stringProperty(75),
            'pref' => self::stringProperty(255),
            'timeFrames' => self::integerProperty(),
            'toileting' => self::integerProperty(),
            'unitTypeId' => self::stringProperty(100),
            'walking' => self::integerProperty()

        );

        parent::__construct((array)$values);
    }

} 