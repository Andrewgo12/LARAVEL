<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo "\nERROR: ",
	{{ $exception->getMessage() ?? "Error" }},
	"\n\n",
	{{ $exception->getMessage() ?? "Ha ocurrido un error" }},
	"\n\n";