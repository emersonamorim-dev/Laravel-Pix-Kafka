<?php
namespace App\Services;

use RdKafka\Conf;
use RdKafka\Producer;

class KafkaService
{
    protected $producer;
    protected $topic;

    public function __construct(array $config)
    {
        $conf = new Conf();
        $this->producer = new Producer($conf);
        $this->topic = $this->producer->newTopic($config['topic']);
    }

    public function send(string $message): void
    {
        $this->topic->produce(-1, 0, $message);
    }
}


