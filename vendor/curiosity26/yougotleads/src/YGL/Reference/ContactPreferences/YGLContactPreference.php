<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 4:35 PM
 */

namespace YGL\Reference\ContactPreferences;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLContactPreference extends YGLJsonObject {
    protected $uniqueId = 'contactPreferenceId';

    public function __construct(array $values = array(), YGLClient $client = NULL)
    {
        $this->_properties = array(
            'contactPreferenceId'   =>  self::integerProperty(),
            'contactPreferenceName' =>  self::stringProperty(255)
        );
        parent::__construct($values, $client);
    }
}