<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 3/19/15
 * Time: 1:33 PM
 */

namespace YGL\ReferralSource\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLCollectionRequest;

class YGLReferralSourceRequest extends YGLCollectionRequest {
  protected $collectionClass = 'YGL\ReferralSource\Collection\YGLReferralSourceCollection';
  protected $property;

  public function __construct($clientToken = null,
    YGLProperty $property = null, $id = null,
    ODataResourceInterface $query = null)
  {
    if (isset($property)) {
      $this->setProperty($property);
    }
    parent::__construct($clientToken, $id, $query);
  }

  public function refreshFunction()
  {
    if (isset($this->property)) {
      $function = isset($this->id)
        ? 'properties/' . $this->property->id . '/sources/' . $this->id
        : 'properties/' . $this->property->id . '/sources';
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