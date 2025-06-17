A PHP Error was encountered

Severity:    {{ $severity ?? 'Unknown' }}
Message:     {{ $exception->getMessage() ?? "Ha ocurrido un error" }}
Filename:    {{ $filepath ?? 'Unknown' }}
Line Number: {{ $line ?? 'Unknown' }}

@if(defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)

Backtrace:
@foreach(debug_backtrace() as $error)
    @if(isset($error['file']) && strpos($error['file'], base_path()) !== 0)
	File: {{ $error['file'] }}
	Line: {{ $error['line'] }}
	Function: {{ $error['function'] }}

    @endif
@endforeach

@endif
