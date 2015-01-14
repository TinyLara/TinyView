<?php

namespace TinyLara\TinyView;

/**
* \View
*/
class TinyView {

  public $view;
  public $data;
  public $isJson;

  public function __construct($view, $isJson = false)
  {
    $this->view = $view;
    $this->isJson = $isJson;
  }

  public static function make($viewName = null)
  {
    if ( !defined('VIEW_BASE_PATH') ) {
      throw new \InvalidArgumentException("VIEW_BASE_PATH is undefined!");
    }
    if ( ! $viewName ) {
      throw new \InvalidArgumentException("View name can not be empty!");
    } else {

      $viewFilePath = self::getFilePath($viewName);
      if ( is_file($viewFilePath) ) {
        return new TinyView($viewFilePath);
      } else {
        throw new \UnexpectedValueException("View file does not exist!");
      }
    }
  }

  public static function json($arr)
  {
    if ( !is_array($arr) ) {
      throw new \UnexpectedValueException("View::json can only recieve Array!");
    } else {
      return new TinyView($arr, true);
    }
  }

  public static function process($view = null)
  {
    if ( $view->isJson ) {
      echo json_encode($view->view);
    } else {
      if ( $view instanceof TinyView ) {
        extract($view->data);
        require $view->view;
      } else {
        echo $view;
      }
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

    throw new \BadMethodCallException("Function [$method] does not exist!");
  }
}