@extends('layout')

@section('title')
    Upload a file
@stop

@section('content')
    <form method="POST" action="/" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Upload</span>
            </div>
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" onchange="this.form.submit()">
                <label class="custom-file-label">Choose file</label>
            </div>
        </div>
    </form>
@stop

