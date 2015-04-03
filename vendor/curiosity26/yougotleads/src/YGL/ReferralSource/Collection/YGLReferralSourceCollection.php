<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\ReferralSource\Collection;


use YGL\Collection\YGLCollection;
use YGL\YGLClient;

class YGLReferralSourceCollection extends YGLCollection {
  protected $itemClass = 'YGL\ReferralSource\YGLReferralSource';

  public function __construct() {
    $args = func_get_args();

    if (empty($args[0]) || is_array($args[0])) {
      $client = isset($args[1]) && $args[1] instanceof YGLClient ? $args[1] : null;
      $values = !empty($args[0]) && is_array($args[0]) ? $args[0] : array();
    }
    else {
      $client = isset($args[0]) && $args[0] instanceof YGLClient ? $args[0] : null;
      $values = !empty($args[1]) && is_array($args[1]) ? $args[1] : array();
    }
    parent::__construct($client, $values);
  }
} 