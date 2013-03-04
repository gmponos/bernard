<?php

namespace Raekke\Message;

use JMS\Serializer\AbstractVisitor;
use JMS\Serializer\Context;

/**
 * @package Raekke
 */
class DefaultMessage extends Message
{
    protected $name;

    /**
     * @param string $string
     * @param array
     */
    public function __construct($name, array $parameters = array())
    {
        foreach ($parameters as $k => $v) {
            $this->$k = $v;
        }

        $this->name = preg_replace('/(^([0-9]+))|([^[:alnum:]-_+])/i', '', $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  AbstractVisitor $visitor
     * @param  null            $data
     * @param  Context         $context
     * @return array
     */
    public function serializeToJson(AbstractVisitor $visitor, $data, Context $context)
    {
        $data = get_object_vars($this);

        unset($data['name']);

        return $data ?: new \ArrayObject();
    }

    /**
     * @param AbstractVisitor $visitor
     * @param array           $data
     */
    public function deserializeFromJson(AbstractVisitor $visitor, array $data)
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
}
