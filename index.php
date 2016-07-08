<?php
/**
*@author William Asciutto <wjasciutto at gmail dot com>
*/
  //Creates class Hangman
  $hangman = new Hangman();

  //Initializes a Hangman view, taking Hangman object
  //as a parameter
  $view = new HangView($hangman);

  //Calls Layout class add function
  Layout::add($view->display(),'hangman');
?>
