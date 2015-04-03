<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:26 PM
 */

namespace YGL\Reference\MemoryLosses\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLMemoryLossesRequest extends YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\MemoryLosses\Collection\YGLMemoryLossCollection';

    public function refreshFunction() {
        return $this->setFunction('memorylosses');
    }
}