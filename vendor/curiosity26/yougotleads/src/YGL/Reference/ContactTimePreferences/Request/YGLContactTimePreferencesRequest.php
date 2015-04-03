<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 5:09 PM
 */

namespace YGL\Reference\ContactTimePreferences\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLContactTimePreferencesRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\ContactTimePreferences\Collection\YGLContactTimePreferenceCollection';

    public function refreshFunction() {
        return $this->setFunction('contacttimepreferences');
    }
}