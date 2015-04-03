<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\Leads\ReferralSource\Collection;


use YGL\Collection\YGLCollection;

class YGLReferralSourceCollection extends YGLCollection
{
    protected $itemValue = 'YGL\Leads\ReferralSource\YGLReferralSource';

    public function __construct(array $values = NULL) {
        if (!isset($values)) {
            $values = array();
        }
        parent::__construct(NULL, $values);
    }
} 