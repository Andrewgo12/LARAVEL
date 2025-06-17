<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo "\nDatabase error: ",
	{{ $exception->getMessage() ?? "Error" }},
	"\n\n",
	{{ $exception->getMessage() ?? "Ha ocurrido un error" }},
	"\n\n";