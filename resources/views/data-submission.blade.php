@extends('layout')

@section('content')
<div class="py-5">
    <div class="container">
        <h1>Welcome to the ROSSA Data Submission Form</h1>

		<div class="mb-4">
			<p>
				Instructions: Based on your login, we will identify if you have any previous studies submitted. The table below shows the study status, study ID, and study title for each study. For studies that are "in progress", we offer the option to continue filling out the study form. You can also create a new study.
			</p>

            @if ( !Auth::check() )
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            @else
                <form action="{{ route('study.store') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Create Study</button>
                </form>
            @endif
		</div>

		<h2>Your Studies</h2>

        @if ( !Auth::check() )
            <div class="alert alert-info">
                Please login to view your studies.
            </div>
        @elseif($studies && $studies->count() > 0) 
            <table class="table">
                <thead>
                    <tr>
                        <th>Study Identifier</th>
                        <th>Study Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studies as $study)
                        <tr>
                            <td>{{ $study->identifier }}</td>
                            <td>{{ $study->title ?? '-' }}</td>
                            <td>{{ $study->status }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('study.study-information', ['study' => $study->id]) }}" 
                                    class="btn btn-warning btn-sm">
                                        Continue Study
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No studies found. Click "Create New Study" to get started.
            </div>
        @endif
    </div>
</div>
@endsection