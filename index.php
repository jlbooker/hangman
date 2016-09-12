<?php
  \Layout::add("Hello World");
  ob_start();
  include "hangwords.txt";
  $words = ob_get_contents();
  ob_end_clean();
  $words = trim($words);
  $words = strtolower($words);
