<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:10 PM
 */

namespace YGL\Reference\CurrentLivingSituations;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLCurrentLivingSituation extends YGLJsonObject {
    protected $uniqueId = 'currentCareId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'currentCare'   =>  self::stringProperty(255),
            'currentCareId' =>  self::integerProperty(),
            'displayOrder'  =>  self::integerProperty(),
            'subscriptionId'=>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}