<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 4:32 PM
 */

namespace YGL\Reference\CareLevels\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Reference\YGLReferenceRequest;
use YGL\YGLClient;

class YGLCareLevelsRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\CareLevels\Collection\YGLCareLevelCollection';

    public function refreshFunction() {
        return $this->setFunction('carelevels');
    }
}