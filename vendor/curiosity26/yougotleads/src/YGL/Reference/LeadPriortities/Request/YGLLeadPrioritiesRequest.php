<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:51 PM
 */

namespace YGL\Reference\LeadPriortities\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLLeadPrioritiesRequest extends YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\LeadPriortities\Collection\YGLLeadPriorityCollection';

    public function refreshFunction() {
        return $this->setFunction('leadpriorities');
    }
}