<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:43 PM
 */

namespace YGL\Reference\FundingTypes\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLFundingTypesRequest extends YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\FundingTypes\Collection\YGLFundingTypeCollection';

    public function refreshFunction() {
        return $this->setFunction('fundingtypes');
    }
}