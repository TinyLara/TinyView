<?php

namespace TinyLara\TinyView;

/**
* \View
*/
class TinyView {

  public $view;
  public $data;

  public function __construct($view)
  {
    $this->view = $view;
  }

  public static function make($viewName = null)
  {
    if ( !defined('VIEW_BASE_PATH') ) {
      throw new InvalidArgumentException("VIEW_BASE_PATH is undefined!");
    }
    if ( ! $viewName ) {
      throw new InvalidArgumentException("View name can not be empty!");
    } else {

      $viewFilePath = self::getFilePath($viewName);
      if ( is_file($viewFilePath) ) {
        return new View($viewFilePath);
      } else {
        throw new UnexpectedValueException("View file does not exist!");
      }
    }
  }

  public static function json($arr)
  {
    if ( !is_array($arr) ) {
      throw new UnexpectedValueException("View::json can only recieve Array!");
    } else {
      return new View($arr, true);
    }
  }

  public static function process($view)
  {
    if ( $view instanceof View ) {
      extract($view->data);
      require $view->view;
    } else {
      throw new UnexpectedValueException("\$view must be instance of View!");
    }
  }

  public function with($key, $value = null)
  {
    $this->data[$key] = $value;
    return $this;
  }

  private static function getFilePath($viewName)
  {
    $filePath = str_replace('.', '/', $viewName);
    return VIEW_BASE_PATH.$filePath.'.php';
  }

  public function __call($method, $parameters)
  {
    if (starts_with($method, 'with'))
    {
      return $this->with(snake_case(substr($method, 4)), $parameters[0]);
    }

    throw new BadMethodCallException("Function [$method] does not exist!");
  }
}