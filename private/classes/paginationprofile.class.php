<?php

class PaginationProfile extends Pagination {


  public function previous_link($url="") {
    $link = "";
    if($this->previous_page() != false) {
      $link .= "<li class=\"page-item \"><a class=\"page-link\" tabindex=\"-1\" href=\"{$url}&page={$this->previous_page()}\">";
      $link .= "&laquo; Previous</a></li>";
    }
    return $link;
  }

  public function next_link($url="") {
    $link = "";
    if($this->next_page() != false) {
      $link .= "<li class=\"page-item \"><a class=\"page-link\" tabindex=\"-1\" href=\"{$url}&page={$this->next_page()}\">";
      $link .= "Next &raquo;</a></li>";
    }
    return $link;
  }

  public function number_links($url="") {
    $output = "";
    for($i=1; $i <= $this->total_pages(); $i++) {
      if($i == $this->current_page) {
        $output .= "<li class=\"page-item active\">";
        $output .= "<a class=\"page-link\">{$i}<span class=\"sr-only\">(current)</span></a></li>";
      } else {
        $output .= "<li class=\"page-item\">";
        $output .= "<a class=\"page-link\" href=\"{$url}&page={$i}\">{$i}</a></li>";
      }
    }
    return $output;
  }


}

?>
