<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 11:01 AM
 */

namespace YGL\Leads\Request;


use ODataQuery\ODataResourceInterface;
use ODataQuery\Pager\ODataQueryPager;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLCollectionRequest;

class YGLLeadRequest extends YGLCollectionRequest
{
    protected $collectionClass = 'YGL\Leads\Collection\YGLLeadCollection';
    protected $property;
    protected $id;

    public function __construct($clientToken = null,
                                YGLProperty $property = null, $id = null,
                                $limit = 20,
                                $page = 0, ODataResourceInterface $query = null)
    {
        if (isset($property)) {
            $this->setProperty($property);
        }
        parent::__construct($clientToken, $id, $query);
        $this->pager(new ODataQueryPager($limit, $page));
    }

    public function id($id = null)
    {
        $this->id = $id;
        $this->refreshFunction();

        return $this;
    }

    public function refreshFunction()
    {
        if (isset($this->property)) {
            $function = isset($this->id)
                ? 'properties/' . $this->property->id . '/leads/' . $this->id
                : 'properties/' . $this->property->id . '/leads';
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

    public function send()
    {
        $response = parent::send();
        if (isset($this->property) && method_exists($response, 'setProperty')) {
            $response->setProperty($this->getProperty());
        }

        return $response;
    }
} 