<?php
$className = 'Hangman';
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

Layout::addPageTitle("Hangman");

//decide how to make/start the game
if(isset($_GET['LINK'])){
    unset($_REQUEST['letter']);
    $game->makeGame();
    $game->initial();
    unset($_GET['LINK']);
}
else {
    $game = makeGame();
}

//decide whether to run the game or not
if(isset($_REQUEST['letter'])){
    $game->run_game();
}
else{
    $game->initital();
}
saveGame($game);
$game->render();

//makes the game
function makeGame(){
    if(!isset($_REQUEST['letter'])){
        $word = chooseWord();
        $_SESSION['word'] = $word;
        $_SESSION['wrongAttempts'] = 0;
        $wrongAttempts = $_SESSION['wrongAttempts'];
        $_SESSION['usedLetters'] = array();
        $usedLetters = $_SESSION['usedLetters'];
        $_SESSION['places'] = [];
        $place_holder = $_SESSION['places'];
        $_SESSION['letter'] = [];
        $letterLinks = $_SESSION['letter'];
    }
    else if(isset($_SESSION['word'])){
        $word = $_SESSION['word'];
        $wrongAttempts = $_SESSION['wrongAttempts'];
        $usedLetters = $_SESSION['usedLetters'];
        $place_holder = $_SESSION['places'];
        $letterLinks = $_SESSION['letter'];
    }
    else{
        $word = chooseWord();
        $_SESSION['word'] = $word;
        $_SESSION['wrongAttempts'] = 0;
        $wrongAttempts = $_SESSION['wrongAttempts'];
        $_SESSION['usedLetters'] = array();
        $usedLetters = $_SESSION['usedLetters'];
        $_SESSION['places'] = [];
        $place_holder = $_SESSION['places'];
        $_SESSION['letter'] = [];
        $letterLinks = $_SESSION['letter'];
    }
    return new Hangman($word, $wrongAttempts, $usedLetters, $place_holder, $letterLinks);

}

//saves the game
function saveGame(Hangman $obj){
    $_SESSION['word'] = $obj->getWord();
    $_SESSION['wrongAttempts'] = $obj->getWrongAttempts();
    $_SESSION['usedLetters'] = $obj->getUsedLetters();
    $_SESSION['places'] = $obj->getPlaces();

}

//chooses a word from the txt file
function chooseWord(){
    $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
    $word = $word_list[array_rand($word_list, 1)];
    $word = strtolower($word);
    $word = preg_replace('/[^a-z]/', '', $word);

    return $word;
}
