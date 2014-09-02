<?php namespace Tjbenator\Irc\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class Irc extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'irc'; }
 
}