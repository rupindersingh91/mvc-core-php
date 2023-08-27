<?php
/*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
class Core
{
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  /**
   * Initializes the class and processes the URL to determine the controller, method, and parameters.
   */
  public function __construct()
  {
    // Get the URL
    $url = $this->getUrl();

    // Look in controllers directory for the first value in the URL
    if (isset($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
      // If the controller file exists, set it as the current controller
      $this->currentController = ucwords($url[0]);
      // Remove the first value from the URL
      unset($url[0]);
    }

    // Require the controller file
    require_once '../app/controllers/' . $this->currentController . '.php';

    // Instantiate the current controller class
    $this->currentController = new $this->currentController;

    // Check if there is a second part in the URL
    if (isset($url) && isset($url[1])) {
      // Check if the method exists in the current controller
      if (method_exists($this->currentController, $url[1])) {
        // If the method exists, set it as the current method
        $this->currentMethod = $url[1];
        // Remove the second value from the URL
        unset($url[1]);
      }
    }

    // Get the remaining values in the URL as parameters
    $this->params = $url ? array_values($url) : [];

    // Call the current method of the current controller with the parameters
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  /**
   * Get the URL from the query parameters
   *
   * @return array|null The URL as an array of segments, or null if not set
   */
  public function getUrl()
  {
    // Check if the 'url' parameter is set in the query string
    if (isset($_GET['url'])) {
      // Remove trailing slashes from the URL
      $url = rtrim($_GET['url'], '/');

      // Sanitize the URL by removing any potentially malicious characters
      $url = filter_var($url, FILTER_SANITIZE_URL);

      // Split the URL into an array of segments
      $url = explode('/', $url);

      // Return the URL as an array
      return $url;
    }

    // Return null if the 'url' parameter is not set
    return null;
  }
}
