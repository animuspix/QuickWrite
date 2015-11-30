# QuickWrite
A simple markup language, inspired by MarkDown. Tired of writing angle brackets and long element titles? Now you can include quickWrite.php, and write everything in nice, clean text documents.

## How does it work?

* /'s are italic
* *'s bold text
* ~'s escape the following character
* -'s strike out text
* |'s insert line breaks
* _'s insert underlines

* Links are a bit more complicated - the url is embedded with a carat (^), and the link text is surrounded by backquotes (``).

## Example passage

`_`Hi!`_` `*/`this`/*` was `-`written`-` cobbled together in ~`*`QuickWrite~`*`,
|
a nice little language used on ^http:~/~/miettia.com [backquote]miettia.com[backquote]^ in my blog

Converts to:
<p><u>Hi! (underlined)</u> <strong><em>this</em></strong> was <strike>written</strike> cobbled together in *QuickWrite*, <br> a nice little language used on <a href="http://miettia.com">miettia.com</a> in my blog</p>

All tags have to be closed, unless their HTML equivalents close themselves. As you might have guessed, QuickWrite is much faster to write
than HTML - it takes 1/3rd as much text at the very most. Unlike markdown (a layout-focussed language), QuickWrite is designed for quick and easy formatting and may be extended towards layout later on.

To use QuickWrite, include it where you want the text to echo and define $file immediately beforehand, like this:

<?php
  $file = "filepath/file.txt";
  include 'quickWrite.php';
?>

QuickWrite will crawl the specified path (or the root if no path is given) for the specified file, read it into a string, and then read the string into an array while swapping out the QuickWrite particles for their HTML equivalents; then it crawls through the array and echoes each element to the body. Happy blogging!
