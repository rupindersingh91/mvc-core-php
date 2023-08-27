<?php
/*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  /**
   * Constructor for the class.
   * Initializes a new instance of the class and sets up the database connection.
   */
  public function __construct()
  {
    // Set DSN
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

    // Set options for the PDO instance
    $options = array(
      PDO::ATTR_PERSISTENT => true, // Enable persistent connections
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Enable exceptions for errors
    );

    // Create PDO instance and establish database connection
    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage(); // Store the error message
      echo $this->error; // Output the error message
    }
  }

  /**
   * Prepares a statement with the given SQL query.
   *
   * @param string $sql - The SQL query to prepare.
   * @return void
   */
  public function query(string $sql): void
  {
    $this->stmt = $this->dbh->prepare($sql);
  }

  /**
   * Binds a value to a parameter in the prepared statement.
   *
   * @param string $param The parameter to bind.
   * @param mixed $value The value to bind.
   * @param int|null $type The data type of the value.
   * @return void
   */
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  /**
   * Executes the prepared statement.
   *
   * @return bool Returns true if the statement was executed successfully, false otherwise.
   */
  public function execute()
  {
    return $this->stmt->execute();
  }

  /**
   * Fetches the result set as an array of objects.
   *
   * @return array The result set as an array of objects.
   */
  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Executes the query and returns a single record as an object.
   *
   * @return object|null The single record as an object, or null if no record found.
   */
  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get the number of rows affected by the last executed statement.
   *
   * @return int The number of rows affected.
   */
  public function rowCount()
  {
    return $this->stmt->rowCount();
  }
}
