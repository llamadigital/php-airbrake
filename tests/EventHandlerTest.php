<?php

require_once __DIR__ . '/AirbrakeTestCase.php';

use Airbrake\EventFilter as Filter;
use Airbrake\Configuration as Configuration;

class EventHandlerTest extends AirbrakeTestCase
{
  public function testSendError()
  {
    $this->createHandler();
    $this->h->triggerWarning();
    $this->assertEquals(1, $this->connection->send_calls);
  }

  public function testErrorFilterApplied()
  {
    $config = array('errorReportingLevel' => E_WARNING | E_NOTICE);
    $this->createHandler($config);

    $this->h->triggerWarning();
    $this->h->triggerNotice();
    $this->h->triggerStrict();

    $this->assertEquals(2, $this->connection->send_calls);
  }

  public function testNotifyOnWarningMigration()
  {
    //Test that moving the notifyOnWarning behaviour to its own class hasn't 
    //introduced any problems
    $this->createHandler(array(), false);
    $this->h->triggerNotice();
    $this->h->triggerDeprecated();
    $this->h->triggerWarning();
    $this->h->triggerStrict();
    $this->h->triggerUserWarning();
    $this->h->triggerUserNotice();
    $this->h->triggerRecoverableError();
    $this->assertEquals(0, $this->connection->send_calls);
  }
}
