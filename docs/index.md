# RssFeed Class
[GitHub: https://github.com/bartonlp/rssfeed](https://github.com/bartonlp/rssfeed)

This is a PHP class that can read RSS feeds. A RSS file has an XML format with *item* as the main element. The XML file looks something like this:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
  <channel>
    <title>Main Title</title>
    <link>http://www.example.com</link>
    <description>Example description for channel</description>
    <lastBuildDate>Sat, 03 Dec 2016 19:31:18 +0000</lastBuildDate>
    <generator>Program Name if any</generator>
    <item>
      <title>Example of RSS Feed</title>
      <link>http://www.example.com/link/</link>
      <description>
        Description of this item. All entities should be escaped. Example &lt;test&gt; 
      </description>
      <pubDate>Sat, 16 May 2009 17:12:15 +0000</pubDate>
    </item>
    <item>
      <title>Another Example</title>
      <link>http://www.example.com/link2/>
      <description>Some more stuff</description>
      <pubDate>Sat, 16 May 2016 17:12:15 +0000</pubDate>
    </item>
  </channel>
</rss>
```

There is an XML header followed by the *rss* tag an optional *channel* tag and then the *item* tags. The *item* tags are what we are most interested in as they have the RSS feed information you will want to look at. Typical entries are *title*, *link*, *description* and *pubDate*. There may be other tags as well but these four are the most used. 

The methods of **RssFeed** are:

* public function __construct($data, $isfile=true, $savedata=false)
* public function getDb()
* public function getItem($inx)
* public function getRawData()

The 'constructor' takes up to three arguments. $data is a string, either a filename or raw data. $isfile is true if the string in $data is a filename and false if it is raw data (defaults to true). $savedata is true if you want to save the raw XML and false if you don't (defaults to false). 

The 'getDb' method takes not arguments, it returns the array of the *item* tags and their children. You can look at this array with `var_dump($returned)` to find the elements you want to look at.

The 'getItem' methode take one integer argument, the *item* index. It returns a sub-array of the elements under the *item* tab.

The 'getRawData' method returns the raw XML.

## Example Code

```php
<?php
requier_once($PATH_TO_VENDOR . "/vendor/autoload.php");
use bartonlp\RssFeed;
$rss = new RssFeed("docs/testrss.xml", true, true);
$raw = $rss->getRawData();

// This is the raw XML from the site.

echo "<pre>Raw:\n$raw";

// This is the item array. Array element '0' is the first <item> etc.

$db = $rss->getDb();
echo "DB:\n";
var_dump($db);

// This gets the first <item> as an associative array.

$item = $rss->getItem(0);
echo "First Item:\n";
var_dump($item);

// To display items just do $item['title'] etc.

echo <<<EOF
</pre>
<p>Item title: {$item['title']}<br>
Item description: {$item['description']}</p>

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
```

If you run this you will see:

![Image of screen](https://bartonlp.github.io/rssfeed/image.png)

---

## Contact me

Barton Phillips : [mailto://bartonphillips@gmail.com](mailto://bartonphillips@gmail.com)    
Copyright &copy; 2017 Barton Phillips  
Project maintained by [bartonlp](https://github.com/bartonlp)

