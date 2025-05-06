@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Select Your Preferred LLM</h1>
    <form action="{{ route('settings.select-llm') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="llm">Choose an LLM:</label>
            <select name="llm" id="llm" class="form-control">
                @foreach ($llms as $llm)
                    <option value="{{ $llm }}" {{ session('selected_llm') == $llm ? 'selected' : '' }}>
                        {{ $llm }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
