<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:28 PM
 */

namespace YGL\Reference\RelationsToResident;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLRelationToResident extends YGLJsonObject {
    protected $uniqueId = 'relationId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'relation'      =>  self::stringProperty(255),
            'relationId'    =>  self::integerProperty(),
            'sortOrder'     =>  self::integerProperty(),
            'subscriptionId'=>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}