<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 10:55 AM
 */

namespace YGL\Tasks\Collection;


use YGL\Collection\YGLCollection;
use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;

class YGLTaskCollection extends YGLCollection
{
    protected $itemClass = 'YGL\Tasks\YGLTask';
    protected $property;
    protected $lead;

    public function setProperty(YGLProperty $property)
    {
        if ($property !== $this->property) { // Don't waste clock cycles
            // Prefer this client if set, otherwise use the property's client if possible
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

    public function setLead(YGLLead $lead)
    {
        // TaskCollections can have tasks from different leads.
        // Setting the lead on the collection will override any leads currently set
        // on individual tasks.
        if ($lead !== $this->lead) {
            if ($property = $lead->getProperty()) {
                $this->setProperty($property);
            }

            // Prefer the task from the property before the lead,
            // they're the same if it's set on the lead
            if (isset($this->client)) {
                $lead->setClient($this->client);
            } elseif ($client = $lead->getClient()) {
                $this->setClient($client);
            }
            $this->lead = $lead;
            foreach ($this->collection as $item) {
                if (method_exists($item, 'setLead')) {
                    $item->setLead($lead);
                }
            }
            reset($this->collection);
        }

        return $this;
    }

    public function getLead()
    {
        return $this->lead;
    }
}