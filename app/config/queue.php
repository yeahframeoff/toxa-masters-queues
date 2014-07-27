<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Queue Driver
	|--------------------------------------------------------------------------
	|
	| The Laravel queue API supports a variety of back-ends via an unified
	| API, giving you convenient access to each back-end using the same
	| syntax for each one. Here you may set the default queue driver.
	|
	| Supported: "sync", "beanstalkd", "sqs", "iron", "redis"
	|
	*/

	// 'default' => 'sync',
    // 'default' => 'beanstalkd',
    'default' => 'iron',
	/*
	|--------------------------------------------------------------------------
	| Queue Connections
	|--------------------------------------------------------------------------
	|
	| Here you may configure the connection information for each server that
	| is used by your application. A default configuration has been added
	| for each back-end shipped with Laravel. You are free to add more.
	|
	*/

	'connections' => array(

		'sync' => array(
			'driver' => 'sync',
		),

		'beanstalkd' => array(
			'driver' => 'beanstalkd',
			//'host'   => 'localhost',
            'host'    => 'mq-aws-us-east-1.iron.io',
            'token'   => 'iJn0g9S7cNA3YY5LOL4jfKbFxGs',
            'project' => '53d41188549c4f0005000077',
            'queue'   => 'user-process-queue',
            'encrypt' => false,
			//'queue'  => 'default',
			'ttr'    => 60,
		),

		'sqs' => array(
			'driver' => 'sqs',
			'key'    => 'your-public-key',
			'secret' => 'your-secret-key',
			'queue'  => 'your-queue-url',
			'region' => 'us-east-1',
		),

		'iron' => array(
			'driver'  => 'iron',
			'host'    => 'mq-aws-eu-west-1.iron.io',
			'token'   => 'iJn0g9S7cNA3YY5LOL4jfKbFxGs',
			'project' => '53d41188549c4f0005000077',
			'queue'   => '53d4315ccf6896147841622c',
			'encrypt' => false,
            'protocol' => 'http',
            'port' => 80,
            'ssl_verifypeer' => false,
		),

		'redis' => array(
			'driver' => 'redis',
			'queue'  => 'default',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Failed Queue Jobs
	|--------------------------------------------------------------------------
	|
	| These options configure the behavior of failed queue job logging so you
	| can control which database and table are used to store the jobs that
	| have failed. You may change them to any database / table you wish.
	|
	*/

	'failed' => array(

		'database' => 'mysql', 'table' => 'failed_jobs',

	),

);
