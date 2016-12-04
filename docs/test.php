<?php
require '../../../../vendor/autoload.php';  
use bartonlp\RssFeed;

$rss = new RssFeed("testrss.xml", true, true);
$raw = escape($rss->getRawData());
echo "<pre>Raw:\n$raw";

$db = $rss->getDb();
echo "DB:\n";
var_dump($db);

$item = $rss->getItem(0);
echo "First Item:\n";
var_dump($item);

echo <<<EOF
</pre>
<p>Item title: {$item['title']}<br>
Item description: {$item['description']}</p>
EOF;

// Now iterate over the items

echo "<h1>Example of Iterating Over Entire Array of Items</h1>";

foreach($rss->getDb() as $val) {
  foreach($val as $key=>$v) {
    echo "$key: $v<br>";
  }
  echo "<hr>";
}

echo "DONE";

function escape($v) {
  return preg_replace(['~<~', '~>~'], ['&lt;', '&gt;'], $v);
}