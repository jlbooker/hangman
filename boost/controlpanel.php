<?php

  /**
   * @version $Id: controlpanel.php 5472 2007-12-11 16:13:40Z jtickle $
   * @author Jeff Tickle <jtickle at tux dot appstate dot edu>
   */

$link[] = array('label'       => 'Hangman',
		'restricted'  => TRUE,
		'url'         => 'index.php?module=hangman',
		'description' => dgettext('hangman', 'Play hangman.'),
		'image'       => 'analytics.png',
		'tab'         => 'admin'
		);
