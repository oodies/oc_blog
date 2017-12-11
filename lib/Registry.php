<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Lib;

/**
 * Class Registry
 * a registry design pattern
 * @package Lib
 */
class Registry extends \ArrayObject
{

    /**
     * @var null
     */
    private static $registry = null;

    /**
     * Constructs a parent ArrayObject with default
     * ARRAY_AS_PROPS to allow access as an object
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iterator_class
     */
    public function __construct(
        $input = array(),
        int $flags = parent::ARRAY_AS_PROPS,
        string $iterator_class = "ArrayIterator"
    ) {
        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * Set the value at the specified index to value
     *
     * @param string $index
     * @param $value
     */
    public static function set($index, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($index, $value);
    }

    /**
     * Singleton design pattern
     * @return Registry|null
     */
    public static function getInstance()
    {
        if (self::$registry === null) {
            self::$registry = new self;
        }
        return self::$registry;
    }

    /**
     * Returns the value at the specified index
     *
     * @param $index
     *
     * @return mixed
     * @throws \Exception
     */
    public static function get($index)
    {
        $instance = self::getInstance();

        if (!$instance->offsetExists($index)) {
            throw new \Exception("No entry is registered for key '$index'");
        }

        return $instance->offsetGet($index);
    }

    /**
     * @param string $index
     *
     * @return mixed
     */
    public function offsetExists($index)
    {
        return array_key_exists($index, $this);
    }
}