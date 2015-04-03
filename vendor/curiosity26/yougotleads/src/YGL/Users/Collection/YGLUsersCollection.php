<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 10:58 AM
 */

namespace YGL\Users\Collection;


use YGL\Collection\YGLCollection;
use YGL\Properties\YGLProperty;
use YGL\Users\YGLUser;

class YGLUsersCollection extends YGLCollection
{
    protected $itemClass = 'YGL\Users\YGLUser';
    protected $property;

    public function setProperty(YGLProperty $property)
    {
        if ($property !== $this->property) {
            $this->property = $property;
            foreach ($this->collection as $item) {
                if ($item instanceof YGLUser) {
                    $item->setProperty($property);
                }
            }
            reset($this->collection);
        }

        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }
}