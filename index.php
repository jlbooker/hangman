<html>
<head>
  <body>
    <img src="hang0.gif" />
    <form action="welcome.php" method="post">
Pick a letter: <input type="text" name="letter"><br>
<input type="submit">
    </form>
    <?php
      session_start(['cookie_lifetime' => 86400,]);
      ob_start();
      include "hangwords.txt";
      $words = ob_get_contents();
      ob_end_clean();
      $words = trim($words);
      $words = strtolower($words);
      $choice = $_GET["letter"];
      //echo '<img src="hang0.gif" />';//\

      //fxn to run game
      function run_game($words, $letter){
        
      }
    ?>
  </body>
</head>
</html>
