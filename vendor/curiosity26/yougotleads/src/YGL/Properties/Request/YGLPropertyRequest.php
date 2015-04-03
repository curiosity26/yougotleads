<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 11:27 PM
 */

namespace YGL\Properties\Request;

use ODataQuery\ODataResourceInterface;
use ODataQuery\Pager\ODataQueryPager;
use YGL\Request\YGLCollectionRequest;

class YGLPropertyRequest extends YGLCollectionRequest
{
    protected $collectionClass = '\YGL\Properties\Collection\YGLPropertyCollection';
    protected $id;

    public function __construct(
        $clientToken = null,
        $id = null,
        $limit = 20,
        $page = 0,
        ODataResourceInterface $query = null
    ) {
        parent::__construct($clientToken, $id, $query);
        $this->pager(new ODataQueryPager($limit, $page));
    }

    public function refreshFunction()
    {
        return $this->setFunction(isset($this->id) ? 'properties/' . $this->id : 'properties');
    }
} 