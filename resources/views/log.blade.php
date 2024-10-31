
@extends('_layout.main')
@section('title', 'Performance - KKPI')
@section('content')
    <div class="container mt-5">
        <h1>Application Logs</h1>

        @if (empty($logs))
            <div class="alert alert-info">
                No logs found.
            </div>
        @else
            <div class="log-container" style="height: 400px; overflow-y: auto; background-color: #f8f9fa; padding: 10px;">
                <pre style="font-size: 14px;">
                    @foreach ($logs as $log)
                    {{ $log }}
                    @endforeach
                </pre>
            </div>
        @endif
    </div>
@endsection