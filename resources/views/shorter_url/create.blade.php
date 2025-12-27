@extends('layouts.app')
@section('title', 'Shorter URL')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Generate Shorter URL</h2>
                <form action="{{ route('shorter.url.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="original_url">Original URL:</label>
                        <input type="url" name="original_url" id="original_url" class="form-control" placeholder="https://example.com" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Shorter URL</button>
                </form>
            </div>
        </div>
    </div>
@endsection