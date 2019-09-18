<?php

class User extends DatabaseObject {

  static protected $table_name = "users";
  static protected $db_columns = ['id', 'email', 'username', 'hashed_password'];

  public $id;
  public $email;
  public $username;
  protected $hashed_password;
  public $password;
  public $confirm_password;
  protected $password_required = true;

  public function __construct($args=[]) {
    $this->email = $args['email'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
  }

  protected function set_hashed_password() {
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function verify_password($password) {
    return password_verify($password, $this->hashed_password);
  }

  protected function create() {
    $this->set_hashed_password();
    return parent::create();
  }

  protected function update() {
    if($this->password != '') {
      $this->set_hashed_password();
      // validate password
    } else {
      // password not being updated, skip hashing and validation
      $this->password_required = false;
    }
    return parent::update();
  }

  protected function validate() {
    $this->errors = [];

    if(is_blank($this->email)) {
      $this->errors["email_err"] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($this->email)) {
      $this->errors["email_err"] = "Email must be a valid format.";
    } elseif (!has_unique_email($this->email, $this->id ?? 0)) {
      $this->errors["email_err"] = "Email is taken. Please try another.";
    }

    if(is_blank($this->username)) {
      $this->errors["username_err"] = "Username cannot be blank.";
    } elseif (!has_length($this->username, array('min' => 8, 'max' => 255))) {
      $this->errors["username_err"] = "Username must be between 8 and 255 characters.";
    } elseif (!is_alphanumeric($this->username)) {
      $this->errors["username_err"] = "Username can only have numbers and letters with no spaces.";
    } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
      $this->errors["username_err"] = "Username is taken. Please try another.";
    }

    if($this->password_required) {
      if(is_blank($this->password)) {
        $this->errors["password_err"] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 6))) {
        $this->errors["password_err"] = "Password must contain 6 or more characters";
      }

      if(is_blank($this->confirm_password)) {
        $this->errors["pass_confirm_err"] = "Confirm password cannot be blank.";
      } elseif ($this->password !== $this->confirm_password) {
        $this->errors["pass_confirm_err"] = "Password and confirm password must match.";
      }
    }
    
    return $this->errors;
  }

  static public function find_by_username($username) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static public function find_by_email($email) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

}

?>
