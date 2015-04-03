<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:26 PM
 */

namespace YGL\Reference\FamilyStatuses;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLFamilyStatus extends YGLJsonObject {
    protected $uniqueId = 'familyStatusId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'familyStatus'      =>  self::stringProperty(255),
            'familyStatusId'    =>  self::integerProperty(),
            'subscriptionId'    =>  self::integerProperty()
        );

        parent::__construct($values, $client);
    }
}