<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:48 PM
 */

namespace YGL\Reference\ApartmentTypes\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLApartmentTypeRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\ApartmentTypes\Collection\YGLApartmentTypeCollection';

    public function refreshFunction() {
        return $this->setFunction('apartmenttypes');
    }
}