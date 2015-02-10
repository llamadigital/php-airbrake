<?php

require_once __DIR__ . '/AirbrakeTestCase.php';

class StackTraceTest extends AirbrakeTestCase
{
  //Tests are in their own files so that line numbers don't get screwed up
  public function testObjectAccessOfArrayError()
  {
    $this->createHandler();
    $test_case_fp = '/includes/object-access-of-array.php';
    require __DIR__ . $test_case_fp;

    $frame = $this->connection->notice->backtrace[0];
    $this->assertRegExp('#' . $test_case_fp . '$#', $frame['file']);
    $this->assertEquals(4, $frame['line']);
  }

  public function testException()
  {
    $this->createHandler();
    $test_case_fp = '/includes/thrown-exception.php';
    try{
      require __DIR__ . $test_case_fp;
    }catch(Exception $e){
      $this->handler->onException($e);
      $frame = $this->connection->notice->backtrace[0];
      $this->assertRegExp('#' . $test_case_fp . '$#', $frame['file']);
      $this->assertEquals(3, $frame['line']);
    }
  }
}
