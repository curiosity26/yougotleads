<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 5:16 PM
 */

namespace YGL\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Collection\YGLCollection;
use YGL\YGLClient;

abstract class YGLCollectionRequest extends YGLRequest {

    protected $collectionClass = '\YGL\Collection\YGLCollection';
    protected $id;

    public function __construct(YGLClient $client = NULL, $id = NULL, ODataResourceInterface $query = NULL) {
        parent::__construct($client, $query);
        $this->id($id);
    }

    protected function getCollectionClass() {
        return $this->collectionClass;
    }

    public function id($id = NULL) {
        $this->id = $id;
        $this->refreshFunction();
        return $this;
    }

    public function send() {
        $response = parent::send();
        if ($response->isSuccess()) {
            $body = $response->getResponseCode() != 201
                ?   json_decode($response->getBody())
                :   json_decode($response->getResponse()->getRawResponse());
            if (is_object($body)) {
                $body = array((array)$body);
            }
            $class = $this->getCollectionClass();
            $collection = new $class() instanceof YGLCollection
                ? new $class($this->getClient(), $body)
                : new YGLCollection($this->getClient(), $body);
            return $collection->count() > 1 ? $collection->rewind() : $collection->rewind()->current();
        }
        return $response;
    }
}