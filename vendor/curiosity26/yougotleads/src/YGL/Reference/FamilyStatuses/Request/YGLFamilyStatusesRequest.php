<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:32 PM
 */

namespace YGL\Reference\FamilyStatuses\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLFamilyStatusesRequest extends YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\FamilyStatuses\Collection\YGLFamilyStatusCollection';

    public function refreshFunction() {
        return $this->setFunction('familystatuses');
    }
}