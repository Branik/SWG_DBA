<?php
# DBException.class.php
# by Nicole Ward
# <http://snowwolfegames.com>
# <nikki@snowwolfegames.com>
#
# Copyright © 2013 - SnowWolfe Games, LLC

# This script extends php Exception class.

# properties:
# $Backtrace
# - public
# - array
# - holds the debug_backtrace output.
#
# methods:
# __construct
# -- calls:
# -- parent::__construct()

class DBException extends Exception {

	public $Backtrace;
	
	public function __construct($message = false, $code = false)
		{
			parent::__construct($message, $code);
			$this->Backtrace = var_export(debug_backtrace(), true);
		}
}
?>