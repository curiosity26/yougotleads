<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 4:24 PM
 */

namespace YGL\Reference\CareLevels;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLCareLevel extends YGLJsonObject {
    protected $uniqueId = 'careLevelId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'active'        =>  self::booleanProperty(),
            'careLevel'     =>  self::stringProperty(255),
            'careLevelId'   =>  self::integerProperty(),
            'careOrder'     =>  self::integerProperty(),
            'subscriptionId'=>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}