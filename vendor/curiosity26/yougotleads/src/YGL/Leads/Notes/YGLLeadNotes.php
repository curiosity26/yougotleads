<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:52 PM
 */

namespace YGL\Leads\Notes;


use YGL\YGLJsonObject;

class YGLLeadNotes extends YGLJsonObject
{

    public function __construct($values = null)
    {
        $this->_properties = array(
            'notes' => self::stringProperty(255),
            'updatedBy' => self::stringProperty(),
            'updatedOn' => self::datetimeProperty()
        );

        parent::__construct((array)$values);
    }
} 