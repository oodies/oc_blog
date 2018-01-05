<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Lib;

/**
 * Class DIC
 *
 * EXAMPLE /
 *
 * $DIC = new DIC();
 * -- 1
 * $DIC->set('foo', function () { return new Foo() } );
 * -- 2
 * $foo = new Foo();
 * $DIC->setInstance('foo', $foo);
 * -- 3
 * $foo = new Foo();
 * $DIC->setFactories('foo', function () { return new Foo() } );
 *
 * Set method is not obligatory, the Get method automatically discovers the class,
 * with fully qualify name class.
 * $foo = $DIC->get('Foo')
 *
 * @package Lib
 */
class DIC
{

    /** *******************************
     *  PROPERTIES
     */

    /**
     * Container for function to be solved
     *
     * @var array
     */
    private $registry = [];

    /**
     * Container for instance
     *
     * @var array
     */
    private $instances = [];

    /**
     * Container for function that will always give a new instance
     *
     * @var array
     */
    private $factories = [];

    /** *******************************
     *  METHODS
     */

    /**
     * @param string   $key
     * @param callable $resolver
     */
    public function set(string $key, callable $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    /**
     * @param string   $key
     * @param callable $resolver
     */
    public function setFactory(string $key, callable $resolver)
    {
        $this->factories[$key] = $resolver;
    }

    /**
     * @param $instance
     */
    public function setInstance($instance)
    {
        $reflection = new \ReflectionClass($instance);
        $this->instances[$reflection->getName()] = $instance;
    }

    /**
     * Return the same instance for the defined key,
     * if the resolved function was provided by 'set' ou 'setInstance' methods
     *
     * Return a new instance for the defined key,
     * if the resolved function was provided by 'setFactories'
     *
     * @param string $key
     *
     * @throws \Exception $key. ' is not an instantiable Class'
     *
     * @return object
     */
    public function get(string $key)
    {
        if (isset ($this->factories[$key])) {
            return $this->factories[$key]();
        }

        if (!isset ($this->instances[$key])) {
            if (isset($this->registry[$key])) {
                $this->instances[$key] = $this->registry[$key]();
            } else {
                $reflectedClass = new \ReflectionClass($key);
                if ($reflectedClass->isInstantiable()) {
                    /** @var \ReflectionMethod $constructor */
                    $constructor = $reflectedClass->getConstructor();

                    /** @var \ReflectionParameter (an array of) $parameters */
                    $parameters = $constructor->getParameters();

                    $constructor_params = [];
                    foreach ($parameters as $parameter) {
                        /** @var \ReflectionParameter $parameter */
                        $reflectedClassOfParameter = $parameter->getClass();
                        if ($reflectedClassOfParameter) {
                            $constructor_params[] = $this->get($reflectedClassOfParameter->getName());
                        } else {
                            $constructor_params[] = $parameter->getDefaultValue();
                        }
                    }
                    $this->instances[$key] = $reflectedClass->newInstanceArgs($constructor_params);
                } else {
                    throw new \Exception($key . ' is not an instantiable Class');
                }
            }
        }

        return $this->instances[$key];
    }
}
