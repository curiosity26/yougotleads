<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 12:16 AM
 */

namespace YGL;


use YGL\Leads\Address\YGLAddress;
use YGL\Leads\Contact\YGLContact;
use YGL\Leads\Notes\YGLLeadNotes;
use YGL\ReferralSource\Collection\YGLReferralSourceCollection;
use YGL\Leads\Resident\YGLLeadResident;
use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\Tasks\YGLTask;
use YGL\Users\YGLUser;

class YGLJsonObject implements \JsonSerializable
{
    protected $_properties = array();
    protected $client;
    protected $uniqueId;

    public function __construct(array $values = null, YGLClient $client = null)
    {
        if (isset($client)) {
            $this->setClient($client);
        }

        if (isset($values)) {
            foreach ($values as $key => $value) {
                $this->__set($key, $value);
            }
        }
    }

    static protected function integerProperty($default = null)
    {
        return array(
            'type' => 'int',
            'value' => $default
        );
    }

    static protected function booleanProperty($default = null)
    {
        return array(
            'type' => 'boolean',
            'value' => $default
        );
    }

    static protected function stringProperty($length = 50, $default = null)
    {
        return array(
            'type' => 'string',
            'length' => $length,
            'value' => $default
        );
    }

    static protected function customProperty(
        $className,
        $default = null,
        array $extra = array()
    ) {
        return array(
            'type' => '\\' . $className,
            'value' => $default
        ) + $extra;
    }

    static protected function datetimeProperty($default = null)
    {
        if (isset($default) && is_string($default)) {
            $default = new \DateTime($default);
        }

        return self::customProperty('DateTime', $default);
    }

    static protected function propertyProperty(YGLProperty $default = null)
    {
        return self::customProperty('YGL\Properties\YGLProperty', $default);
    }

    static protected function leadProperty(YGLLead $default = null)
    {
        return self::customProperty('YGL\Leads\YGLLead', $default);
    }

    static protected function addressProperty(YGLAddress $default = null)
    {
        return self::customProperty('YGL\Leads\Address\YGLAddress', $default);
    }

    static protected function contactProperty(YGLContact $default = null)
    {
        return self::customProperty('YGL\Leads\Contact\YGLContact', $default);
    }

    static protected function residentProperty(YGLLeadResident $default = null)
    {
        return self::customProperty('YGL\Leads\Resident\YGLLeadResident', $default);
    }

    static protected function referralSourceCollectionProperty(
        YGLReferralSourceCollection $default = null
    ) {
        return self::customProperty(
            'YGL\ReferralSource\Collection\YGLReferralSourceCollection',
            $default
        );
    }

    static protected function notesProperty(YGLLeadNotes $default = null)
    {
        return self::customProperty('YGL\Leads\Notes\YGLLeadNotes', $default);
    }

    static protected function taskProperty(YGLTask $default = null)
    {
        return self::customProperty('YGL\Tasks\YGLTask', $default);
    }

    static protected function userProperty(YGLUser $default = null)
    {
        return self::customProperty('YGL\Users\YGLUser', $default);
    }

    public function getType($propertyName)
    {
        if (isset($this->_properties[$propertyName])) {
            return $this->_properties[$propertyName]['type'];
        }

        return null;
    }

    public function setClient(YGLClient $client)
    {
        $this->client = $client;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function JsonSerialize()
    {
        $data = array();

        foreach ($this->_properties as $name => $property) {
            if ($property['value'] == null) {
                continue;
            }
            if ($property['value'] instanceof \DateTime) {
                $data[ucfirst($name)] = $property['value']->format('c');
            }
            else {
                $data[ucfirst($name)] = $property['value'];
            }
        }

        return $data;
    }

    public function __set($name, $value)
    {
        $name = lcfirst($name);
        if (!empty($this->_properties[$name])) {
            $type = $this->_properties[$name]['type'];

            switch ($type) {
                case 'int':
                    $this->_properties[$name]['value'] = (int)$value;
                    break;
                case 'boolean':
                    $this->_properties[$name]['value'] = $value == true;
                    break;
                case 'string':
                    $this->_properties[$name]['value'] = substr(
                        $value,
                        0,
                        $this->_properties[$name]['length']
                    );
                    break;
                default:
                    if (is_string($value) && strlen($value) < 1) {
                        $value = null;
                    }

                    $this->_properties[$name]['value'] = $value instanceof $type
                        ? $value : new $type($value);
                    break;
            }
        }
    }

    public function __get($name)
    {
        $name = lcfirst($name);
        if ($name == 'id') {
            return isset($this->_properties[$this->uniqueId]) ? $this->_properties[$this->uniqueId]['value'] : null;
        }

        if (!empty($this->_properties[$name])) {
            return $this->_properties[$name]['value'];
        }

        return null;
    }
} 
