<?php

class Blog extends DatabaseObject {

  static protected $table_name = "blogs";
  static protected $db_columns = ['id', 'user_id', 'title', 'content', 'create_date', 'update_date'];

  public $id;
  public $user_id;
  public $title;
  public $content;
  public $create_date;
  public $update_date;

  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->title = $args['title'] ?? '';
    $this->content = $args['content'] ?? '';
  }

  protected function validate() {
    $this->errors = [];

    if(is_blank($this->title)) {
      $this->errors["title_err"] = "Title cannot be blank.";
    }

    if(is_blank($this->content)) {
      $this->errors["content_err"] = "Content cannot be blank.";
    }

    if($this->user_id !== $_SESSION['user_id']) {
      /*
      This will give an error if the user tries to change the value of user_id and username fields
      They are hidden fields but users can still see the values in the source code
      */
      $this->errors["user_session_err"] = "user_id doesn't match the logged in user's user_id";
    }

    return $this->errors;
  }

  static public function find_blog_by_id($id) {
    $sql = "SELECT users.username, user_id, blogs.id, title, content, create_date, update_date FROM users ";
    $sql .= "INNER JOIN blogs ON users.id = blogs.user_id ";
    $sql .= "WHERE blogs.id='" . self::$database->escape_string($id) . "'";
    $result = static::sql_result($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

}

?>
