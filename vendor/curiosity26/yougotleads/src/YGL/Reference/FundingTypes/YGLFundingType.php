<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:36 PM
 */

namespace YGL\Reference\FundingTypes;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLFundingType extends YGLJsonObject {
    protected $uniqueId = 'fundingTypeId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'fundingTypeDesc'   =>  self::stringProperty(255),
            'fundingTypeId'     =>  self::integerProperty(),
            'subscriptionId'    =>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}