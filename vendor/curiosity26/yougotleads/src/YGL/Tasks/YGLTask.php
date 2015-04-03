<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 10:05 PM
 */

namespace YGL\Tasks;


use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\YGLJsonObject;

class YGLTask extends YGLJsonObject
{
    protected $property;
    protected $lead;
    protected $uniqueId = 'taskId';

    public function __construct($values = null)
    {

        $this->_properties = array(
            'taskId' => self::integerProperty(),
            'propertyId' => self::integerProperty(),
            'leadId' => self::integerProperty(),
            'contactId' => self::integerProperty(),
            'priorityId' => self::integerProperty(),
            'followupDate' => self::datetimeProperty(),
            'taskTitle' => self::stringProperty(35),
            'status' => self::booleanProperty(),
            'taskTypeId' => self::integerProperty(),
            'taskType' => self::stringProperty(),
            'createdOn' => self::datetimeProperty(),
            'createdBy' => self::stringProperty(10),
            'childTaskTypeId' => self::integerProperty(),
            'childTaskType' => self::stringProperty(),
            'isGroupTask' => self::booleanProperty(),
            'completedDate' => self::datetimeProperty(),
            'madeContactMode' => self::stringProperty(),
            'updatedOn' => self::datetimeProperty(),
            'updatedBy' => self::stringProperty(10),
            'isAllDay' => self::booleanProperty(),
            'duration' => self::integerProperty(),
            'timeZoneId' => self::stringProperty(32),
            'ownerId' => self::integerProperty(),
            'ownderUsername' => self::stringProperty(10)
        );

        parent::__construct((array)$values);
    }

    public function setProperty(YGLProperty $property)
    {
        $this->property = null;
        // All items should share the same client
        if (isset($this->client)) {
            $property->setClient($this->client);
        } elseif ($client = $property->getClient()) {
            $this->setClient($client);
        }
        $this->property = $property;
        $this->propertyId = $property->id;

        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setLead(YGLLead $lead)
    {
        $this->lead = null;
        // All items should share the same client
        if (isset($this->client)) {
            $lead->setClient($this->client);
        } elseif ($client = $lead->getClient()) {
            $this->setClient($client);
        }

        if ($property = $lead->getProperty()) {
            // It's more important the Task gets the same property as the lead
            $this->setProperty($property);
        }
        $this->lead = $lead;
        $this->leadId = $lead->id;

        return $this;
    }

    public function getLead()
    {
        return $this->lead;
    }
} 