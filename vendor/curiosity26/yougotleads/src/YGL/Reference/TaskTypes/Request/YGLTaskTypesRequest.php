<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:38 PM
 */

namespace YGL\Reference\TaskTypes\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLTaskTypesRequest extends  YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\TaskTypes\Collection\YGLTaskTypeCollection';

    public function refreshFunction() {
        return $this->setFunction('tasktypes');
    }
}