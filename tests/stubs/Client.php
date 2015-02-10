<?php

class TestConnection implements Airbrake\Connection\ConnectionInterface
{
  public $send_calls = 0;
  public $notice;

  public function send(Airbrake\Notice $notice)
  {
    $this->send_calls ++;
    $this->notice = $notice;
    return true;
  }
}
