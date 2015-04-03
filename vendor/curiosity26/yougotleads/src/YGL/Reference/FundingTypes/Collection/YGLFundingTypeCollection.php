<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:41 PM
 */

namespace YGL\Reference\FundingTypes\Collection;


use YGL\Collection\YGLCollection;

class YGLFundingTypeCollection extends YGLCollection {
    protected $itemClass = '\YGL\Reference\FundingTypes\YGLFundingType';
}