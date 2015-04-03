<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:22 PM
 */

namespace YGL\Reference\MemoryLosses;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLMemoryLoss extends YGLJsonObject {
    protected $uniqueId = 'memoryLossId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'displayOrder'      =>  self::integerProperty(),
            'memoryLoss'        =>  self::stringProperty(255),
            'memoryLossId'      =>  self::integerProperty(),
            'subscriptionId'    =>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}