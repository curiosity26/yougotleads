<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:41 PM
 */

namespace YGL\Reference\ApartmentTypes;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLApartmentType extends YGLJsonObject {
    protected $uniqueId = 'aptId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'propertyId'        =>  self::integerProperty(),
            'aptId'             =>  self::integerProperty(),
            'aptDescrip'        =>  self::stringProperty(255),
            'subscriptionId'    =>  self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}