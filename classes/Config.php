<?php

/**
 * CONFIGURAÇÕES
 */
class Config {

  public static function get($path = null)
  {

    if ($path) {
      $config = $GLOBALS['config'];
      $path = explode('/', $path);
      // print_r($path);

      foreach ($path as $bit) {

        //echo $bit, ' ';

        // if (isset($config[$bit])) {
        //   echo 'Set';
        // }

          if (isset($config[$bit])) {
            $config = $config[$bit];
          }
      }

      return $config;
    }

    return false;

  }


}
