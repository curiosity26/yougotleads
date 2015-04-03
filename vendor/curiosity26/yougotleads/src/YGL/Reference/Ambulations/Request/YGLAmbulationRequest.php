<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 1:50 PM
 */

namespace YGL\Reference\Ambulations\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLAmbulationRequest extends YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\Ambulations\Collection\YGLAmbulationCollection';

    public function refreshFunction() {
        return $this->setFunction('ambulations');
    }
}