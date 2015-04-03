<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 2:15 PM
 */

namespace YGL\Reference\Amenities;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLAmenity extends YGLJsonObject {
    protected $uniqueId = 'amenityId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'amenity'       => self::stringProperty(255),
            'amenityId'     => self::integerProperty(),
            'subscriptionId'=> self::integerProperty()
        );
        parent::__construct($values, $client);
    }
}