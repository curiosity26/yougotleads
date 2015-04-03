<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:35 PM
 */

namespace YGL\Reference\TaskTypes;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLTaskType extends YGLJsonObject {
    protected $uniqueId = 'taskTypeId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'taskType'      =>  self::stringProperty(255),
            'taskTypeId'    =>  self::integerProperty(),
            'subscriptionId'=>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}