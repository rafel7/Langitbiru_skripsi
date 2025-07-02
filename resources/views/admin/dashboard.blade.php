@extends('admin.layout')

@section('title', '')

@section('content')
<div style="text-align: center; margin-top: 30px;">
    <a href="{{ route('admin.export') }}" class="btn btn-success" style="padding: 10px 20px; background-color: green; color: white; text-decoration: none; border-radius: 5px;">
        Download Excel
    </a>
</div>


@endsection