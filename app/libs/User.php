<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 26.07.14
 * Time: 21:39
 */

namespace libs;


class User {
    private $_attrs;

    public function __construct(array $attrs)
    {
        $this->_attrs = $attrs;
    }

    public function __get($name)
    {
        return isset ($this->_attrs[$name]) ? $this->_attrs[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->_attrs[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->_attrs[$name]);
    }

    public static function getKeys()
    {
        return array(
            'id', 'name', 'email', 'pictureUrl'
        );
    }
} 