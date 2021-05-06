<?php
/*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controler/method/params
   */
class Core
{
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct()
  {
    //print_r($this->getURL());

    $url = $this->getURL();

    //Look in controllers for value
    if (!empty($url) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) // because this will run in index.php not here
    {
      //If exists, set as a controller
      $this->currentController = ucfirst($url[0]);

      unset($url[0]);
    }

    require_once '../app/controllers/' . $this->currentController . '.php';

    //Instanciate controller class
    $this->currentController = new $this->currentController;

    //Check for the second part of url
    if(isset($url[1])) {
      //Check if the method exists in controller
      if (method_exists($this->currentController, $url[1])) 
      {
        $this-> currentMethod = $url[1];

        unset($url[1]);
      }
    }

    //Get params
    $this->params = $url ? array_values($url) : [];
    // Call the current method in the current controller and give it array of args
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getURL()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url']);
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
