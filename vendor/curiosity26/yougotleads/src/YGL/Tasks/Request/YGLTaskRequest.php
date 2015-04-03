<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 10:40 AM
 */

namespace YGL\Tasks\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLCollectionRequest;

class YGLTaskRequest extends YGLCollectionRequest
{
    protected $collectionClass = 'YGL\Tasks\Collection\YGLTaskCollection';
    protected $property;
    protected $lead;
    protected $id;

    public function __construct(
        $clientToken = false,
        YGLProperty $property = null,
        YGLLead $lead = null,
        $id = null,
        ODataResourceInterface $query = null
    ) {
        if (isset($property)) {
            $this->setProperty($property);
        }
        if (isset($lead)) {
            $this->setLead($lead);
        }
        parent::__construct($clientToken, $id, $query);
    }

    public function refreshFunction()
    {
        if (isset($this->property)) {
            $function = 'properties/' . $this->property->id;
            if (isset($this->lead)) {
                $function .= '/leads/' . $this->lead->id;
            }
            $function .= '/tasks';
            if (isset($this->id)) {
                $function .= '/' . $this->id;
            }
            $this->setFunction($function);
        }

        return $this;
    }

    public function setProperty(YGLProperty $property)
    {
        $this->property = $property;

        return $this->refreshFunction();
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setLead(YGLLead $lead)
    {
        $this->lead = $lead;

        return $this->refreshFunction();
    }

    public function getLead()
    {
        return $this->lead;
    }

    public function send()
    {
        $response = parent::send();
        if (isset($this->lead) && method_exists($response, 'setLead')) {
            $response->setLead($this->getLead());
        } elseif (isset($this->property) && method_exists($response, 'setProperty')) {
            $response->setProperty($this->getProperty());
        }

        if (method_exists($response, 'rewind')) {
            $response->rewind();
        }

        return $response;
    }
}