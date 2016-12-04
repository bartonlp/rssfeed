<?php
// Get Information from an RSS feed
// BLP 2016-06-06 -- This is used in the news.php file to get the SkiHi rss feed.

namespace bartonlp;

use Exception;

class RssFeed {
  private $tdb;
  private $rawdata;
  private $values;
  private $tags;
  
  public function __construct($data, $isfile=true, $savedata=false) {
    $this->tdb = array();
    
    if($isfile) {
      try {
        $data = @file_get_contents($data);
        if($data === false) {
          throw new Exception("file_get_contents() failed", 5001);
        }
      } catch(Exception $e) {
        throw new Exception("file_get_contents() failed", 5001);
      }
      if($savedata) {
        $this->rawdata = $data;
      }
    }
  
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    // $values and $tags are references and return data.
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    $this->values = $values;
    $this->tags = $tags;
    
    foreach($tags as $key=>$val) {
      if($key == "item") {
        // each contiguous pair of array entries are the 
        // lower and upper range for each item definition
        for($i=0; $i < count($val); $i+=2) {
          $offset = $val[$i] + 1;
          $len = $val[$i + 1] - $offset;
          $tdb[] = $this->parseVal(array_slice($values, $offset, $len));
        }
      } else {
        continue;
      }
    }
    $this->tdb = $tdb;
  }

  private function parseVal($vals) {
    for ($i=0; $i < count($vals); $i++) {
      $val[$vals[$i]["tag"]] = $vals[$i]["value"];
    }
    return $val;
  }

  public function getDb() {
    return $this->tdb;
  }

  public function getItem($inx) {
    return $this->tdb[$inx];
  }

  public function getRawData() {
    return $this->rawdata;
  }

  public function getValues() {
    return $this->values;
  }

  public function getTags() {
    return $this->tags;
  }
}
