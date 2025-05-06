@extends('layout')

@section('title', 'Study Summary')

@php
    use App\Models\ExperimentalGroup;
@endphp

@section('content')
<div class="container">
    <h1 class="mb-4">Gene Summary</h1>
    <div class="container">
        <h4>Gene Data</h4>
        <div id="geneDataContainer">
            @php
                $rawGeneData = request()->query('geneData', '{}'); // Get raw query parameter
                $decodedGeneData = urldecode($rawGeneData); // Decode URL-encoded string

                // Extract JSON part using regex
                preg_match('/\{.*\}/s', $decodedGeneData, $matches);
                $jsonPart = $matches[0] ?? '{}'; // Default to empty JSON if no match

                $fullData = json_decode($jsonPart, true); // Decode and parse JSON

                // Log debugging output
                if (!$fullData) {
                    \Log::debug('Gene Summary Debugging:', [
                        'rawGeneData' => $rawGeneData,
                        'decodedGeneData' => $decodedGeneData,
                        'jsonPart' => $jsonPart,
                        'jsonError' => json_last_error_msg(),
                    ]);
                }
            @endphp

            @if ($fullData)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fullData as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No gene data available.</p>
            @endif
        </div>
    </div>
</div>
@endsection