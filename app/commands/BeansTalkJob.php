<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 26.07.14
 * Time: 16:26
 */

class BeansTalkJob {
    public function fire($job, $data)
    {
        print_r($data);
    }
} 