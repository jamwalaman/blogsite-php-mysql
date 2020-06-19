<?php

class Blog extends DatabaseObject {

  static protected $table_name = "blogs";
  static protected $db_columns = ['id', 'user_id', 'title', 'content', 'create_date', 'update_date', 'image'];

  public $id;
  public $user_id;
  public $title;
  public $content;
  public $file_info;
  public $image;
  public $create_date;
  public $update_date;

  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->title = $args['title'] ?? '';
    $this->content = $args['content'] ?? '';
    $this->image = $args['image'] ?? '';
  }

  public function file($img) {
    $this->file_info = $img;
    return $this->file_info;
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

    if (!is_blank($this->image)) {

      $upload_err = "Upload failed. Error code: " . $this->file_info['error'];

      if (!isset($this->id) && $this->file_info['error'] !== 0) {
        // When a blog is being created with an img, upload error must be 0 (file uploaded with success)
        $this->errors["image_err"] = $upload_err;
      } elseif (isset($this->id) && empty($this->file_info['name']) && $this->file_info['error'] !== 4) {
        // When updating a blog with same img, upload error must be 4 (No file was uploaded)
        $this->errors["image_err"] = $upload_err;
      } elseif (isset($this->id) && !empty($this->file_info['name']) && $this->file_info['error'] !== 0) {
        // When updating a blog with new img, upload error must be 0 (file uploaded with success)
        $this->errors["image_err"] = $upload_err;
      } else {
        // Get image file type
        $imgFileType = strtolower(pathinfo($this->image,PATHINFO_EXTENSION));
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png");
        if( !in_array($imgFileType,$extensions_arr) ) {
          // check img extension
          $this->errors["image_err"] = "$imgFileType is an invalide file type. Only jpg, jpeg and png are allowed";
        } elseif($this->file_info['size'] > 1000000) {
          // check img size
          $this->errors["image_err"] = "File size is too big";
        } elseif(file_exists("../uploads/" . upld_img_name($this->file_info['name']))) {
          // check if file exists
          $this->errors["image_err"] = "Image with the name '$this->image' already exists. Choose a different name.";
        }
      }

    }

    return $this->errors;
  }

  static public function find_blog_by_id($id) {
    $sql = "SELECT users.username, user_id, blogs.id, title, content, create_date, update_date, image FROM users ";
    $sql .= "INNER JOIN blogs ON users.id = blogs.user_id ";
    $sql .= "WHERE blogs.id='" . self::$database->escape_string($id) . "'";
    $result = static::sql_result($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  static public function find_all() {
    $sql = "SELECT blogs.id, user_id, username, title, content, image, create_date FROM users, blogs ";
    $sql .= "WHERE users.id = blogs.user_id ";
    $sql .= "ORDER BY create_date DESC";
    $result = static::sql_result($sql);
    $blogs_list = [];
    while ($blog = $result->fetch_assoc()) {
      $blogs_list[] = $blog;
    }
    $result->free();
    return $blogs_list;
  }

}

?>
