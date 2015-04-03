<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 10:49 AM
 */

namespace YGL\Users\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLCollectionRequest;

class YGLUserRequest extends YGLCollectionRequest
{
    protected $collectionClass = 'YGL\Users\Collection\YGLUsersCollection';
    protected $property;
    protected $id;

    public function __construct(
        $clientToken = false,
        YGLProperty $property = null,
        $id = null,
        ODataResourceInterface $query = null
    ) {
        parent::__construct($clientToken, $query);
        if (isset($property)) {
            $this->setProperty($property);
            $this->id($id);
        }
    }

    public function setProperty(YGLProperty $property)
    {
        $this->property = $property;
        $this->refreshFunction();

        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function refreshFunction()
    {
        if ($property = $this->getProperty()) {
            $function = 'properties/' . $property->id . '/users';
            if (isset($this->id)) {
                $function .= '/' . $this->id;
            }
            $this->setFunction($function);
        }

        return $this;
    }

    public function send()
    {
        $response = parent::send();
        if (isset($this->property) && method_exists($response, 'setProperty')) {
            $response->setProperty($this->getProperty());
        }

        return $response;

    }
}