<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:50 PM
 */

namespace YGL\Leads\Collection;


use YGL\Collection\YGLCollection;
use YGL\Properties\YGLProperty;

class YGLLeadCollection extends YGLCollection
{
    protected $itemClass = 'YGL\Leads\YGLLead';
    protected $property;

    public function setProperty(YGLProperty $property)
    {
        if ($property !== $this->property) {
            if (!isset($this->client) && ($client = $property->getClient())) {
                $this->setClient($client);
            }
            $this->property = $property;
            foreach ($this->collection as $item) {
                if (method_exists($item, 'setProperty')) {
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