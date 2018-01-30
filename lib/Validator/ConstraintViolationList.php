<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib\Validator;

/**
 * Class ConstraintViolationList
 *
 * @package Lib\Validator
 */
class ConstraintViolationList implements \ArrayAccess, \Countable
{
    /** *******************************
     * PROPERTIES
     */

    /**
     * @var array
     */
    private $violations = [];

    /** *******************************
     * METHODS
     */

    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param $offset
     *
     * @return bool
     */
    public function has($offset)
    {
        return isset($this->violations[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param $offset
     *
     * @return mixed
     */
    public function get($offset)
    {
        if (!isset($this->violations[$offset])) {
            throw new \OutOfBoundsException(sprintf('The offset "%s" does not exist.', $offset));
        }

        return $this->violations[$offset];
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $violation
     */
    public function offsetSet($offset, $violation)
    {
        if (null === $offset) {
            $this->add($violation);
            return;
        }
        $this->set($offset, $violation);
    }

    /**
     * @param $violation
     */
    public function add($violation)
    {
        $this->violations[] = $violation;
    }

    /**
     * @param                              $offset
     * @param                              $violation
     */
    public function set($offset, $violation)
    {
        $this->violations[$offset] = $violation;
    }

    /**
     * Offset to unset
     *
     * @param mixed value $offset
     */
    public function offsetUnset($offset)
    {
        unset ($this->violations[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @return int
     */
    public function count()
    {
        return count($this->violations);
    }

    /**
     * @return array
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
