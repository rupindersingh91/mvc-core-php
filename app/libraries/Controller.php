<?php
/*
   * Base Controller
   * Loads the models and views
   */
class Controller
{
  /**
   * Load model
   *
   * @param string $model The name of the model file to load
   * @return object An instance of the loaded model
   */
  public function model($model)
  {
    // Require model file
    require_once '../app/models/' . $model . '.php';

    // Instantiate model
    return new $model();
  }

  /**
   * Load a view
   *
   * @param string $view The name of the view file to load
   * @param array $data An optional array of data to pass to the view file
   *
   * @return void
   */
  public function view($view, $data = [])
  {
    // Define the path to the view file
    $viewPath = '../app/views/' . $view . '.php';

    // Check if the view file exists
    if (file_exists($viewPath)) {
      // Load the view file
      require_once $viewPath;
    } else {
      // View file does not exist, throw an error
      die('View does not exist');
    }
  }
}
