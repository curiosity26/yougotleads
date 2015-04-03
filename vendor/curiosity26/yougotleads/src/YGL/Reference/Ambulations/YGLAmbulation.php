<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 1:41 PM
 */

namespace YGL\Reference\Ambulations;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLAmbulation extends YGLJsonObject {
    protected $uniqueId = 'ambulationId';

    public function __construct(array $values = array(), YGLClient $client = NULL) {
        $this->_properties = array(
            'ambulation'    => self::stringProperty(255),
            'ambulationId'  => self::integerProperty(),
            'subscriptionId'=> self::integerProperty()
        );

        parent::__construct($values, $client);
    }
}