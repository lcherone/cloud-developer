PHP-petname
---

A utility to generate "pet names", consisting of a random combination of adverbs, an adjective, and an animal name.

Ported from: https://github.com/dustinkirkland/golang-petname to a static PHP class.

**Install with composer:**

 `composer require lcherone/php-petname`

**Usage like so:**

	<?php
	require 'vendor/autoload.php';

	use LCherone\PHPPetname as Petname;

	// werewolf
	echo Petname::Generate(1);

	// peacefull-werewolf
	echo Petname::Generate(2);

	// peacefull mighty werewolf
	echo Petname::Generate(3, ' ');

	// peacefull-mighty-tough-werewolf
	echo Petname::Generate(4);
