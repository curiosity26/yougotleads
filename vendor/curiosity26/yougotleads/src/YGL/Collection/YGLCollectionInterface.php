<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 12:55 PM
 */

namespace YGL\Collection;


interface YGLCollectionInterface
{
    public function clear();

    public function item($id);
}