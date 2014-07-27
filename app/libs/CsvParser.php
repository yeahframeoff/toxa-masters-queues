<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 26.07.14
 * Time: 21:46
 */

namespace libs;


class CsvParser
{

    public function parse($csvData)
    {
        // TODO: add all checks for incorrect data and throw exceptions where necessary

        $rows = $this->explode($csvData, "\n");
        $users = array();
        foreach ($rows as $row)
            $users[] = $this->parseOne($row);

        return ['result' => $users, 'errors' => []];
    }

    public function __construct()
    {
        $this->keys = User::getKeys();
    }

    private $keys;

    public function parseOne($userData)
    {
        // TODO: add all checks for incorrect data and throw exceptions where necessary

        $attrs = $this->explode($userData, ';');
        $config = array_combine($this->keys, $attrs);
        return new User($config);
    }

    private function explode($data, $delim)
    {
        return explode ($data, $delim);
        // TODO: implement explode that respects quotes
    }
} 