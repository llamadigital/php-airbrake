<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/stubs/Client.php';
require_once __DIR__ . '/helpers/TriggerErrors.php';

class AirbrakeTestCase extends PHPUnit_Framework_TestCase
{
  protected $handler;
  protected $connection;
  protected $ini_setting;
  protected $h;

  public function setUp()
  {
    $this->ini_setting = ini_get('error_reporting');
    $this->h = new TriggerErrors();
    error_reporting(-1);
  }

  public function tearDown()
  {
    ini_set('error_reporting', $this->ini_setting);
  }

  protected function createHandler($options = array(), $notifyOnWarning = true)
  {
    Airbrake\EventHandler::reset();
    $this->connection = new TestConnection();
    $this->handler = Airbrake\EventHandler::start(1, $notifyOnWarning, $options);
    $this->handler->getClient()->setConnection($this->connection);
  }
}
