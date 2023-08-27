<?php
class Pages extends Controller
{
  /**
   * Constructor for the class.
   */
  public function __construct()
  {
  }
  /**
   * Display the index page.
   */
  public function index()
  {
    // Define the data to be passed to the view
    $data = [
      'title' => 'TraversyMVC',
    ];
    // Load and render the view with the given data
    $this->view('pages/index', $data);
  }

  /**
   * Display the about page.
   *
   * @return void
   */
  public function about()
  {
    // Define the data to be passed to the view
    $data = [
      'title' => 'About Us'
    ];

    // Call the view method to render the about page
    $this->view('pages/about', $data);
  }
}
