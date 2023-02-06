@extends('admin.admin_master')

@section('admin')

    <h1>{{ $details['title'] }}</h1>
<p>{{ $details['body'] }}</p>

<p>Thank you</p>

    @stack('scripts')
@endsection
