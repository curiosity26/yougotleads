<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 4:59 PM
 */

namespace YGL\Reference\ContactTimePreferences;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLContactTimePreference extends YGLJsonObject {
    protected $uniqueId = 'contactTimeId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'contactTimeId'     =>  self::integerProperty(),
            'contactTimeName'   =>  self::stringProperty(255)
        );

        parent::__construct($values, $client);
    }
}