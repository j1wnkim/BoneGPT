@extends('layout')

@section('content')
    <div class="container">
        <h2>Skeletal Biology Team</h2>
        <div class="row">
            @foreach ($teamMembers['skeletal_biology'] as $member)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">{{ $member['name'] }}</h3>
                            <p class="card-text"><strong>Institution:</strong> {{ $member['institution'] }}</p>
                            <p class="card-text"><strong>Department:</strong> {{ $member['department'] }}</p>
                            <p class="card-text"><strong>Location:</strong> {{ $member['location'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h2>Computer Science, Software and Infrastructure Team</h2>
        <div class="row">
            @foreach ($teamMembers['computer_science'] as $member)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">{{ $member['name'] }}</h3>
                            <p class="card-text"><strong>Institution:</strong> {{ $member['institution'] }}</p>
                            <p class="card-text"><strong>Department:</strong> {{ $member['department'] }}</p>
                            <p class="card-text"><strong>Location:</strong> {{ $member['location'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
