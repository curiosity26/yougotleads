<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\Leads\ReferralSource;


use YGL\YGLJsonObject;

class YGLReferralSource extends YGLJsonObject
{
    protected $uniqueId = 'leadSourceId';

    public function __construct($values = null)
    {
        $this->_properties = array(
            'leadSourceId' => self::integerProperty(),
            'leadSourceName' => self::stringProperty(),
            'leadSourceRank' => self::integerProperty()
        );

        parent::__construct((array)$values);
    }
} 