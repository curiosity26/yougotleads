<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:46 PM
 */

namespace YGL\Reference\LeadPriortities;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLLeadPriority extends YGLJsonObject {
    protected $uniqueId = 'priorityId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'priority'      =>  self::stringProperty(255),
            'priorityDesc'  =>  self::stringProperty(255),
            'priorityId'    =>  self::integerProperty(),
            'subscriptionId'=>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}