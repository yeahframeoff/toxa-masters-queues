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
        while (empty($attrs[0]))
            array_shift($attrs);
        $keys = self::getKeys();
        $size = min(count($attrs), count($keys));

        $attrs = array_slice($attrs, 0, $size);
        $keys = array_slice($keys, 0, $size);
        $this->_attrs = array_combine($keys, $attrs);
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

    public function __toString()
    {
        return
            sprintf('Id: %-20s Name: %-20s Email: %-20s %s',
                $this->id,
                $this->name,
                $this->email,
                isset($this->pictureUrl) ? 'Image is enclosed' : 'Image is NOT enclosed'
        );
    }
} 