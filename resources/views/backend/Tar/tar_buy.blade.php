@extends('admin.admin_master')

@section('admin')

 <div id="page-content" class="page-content" >
    <div class="container-fluid">
           @csrf
     @livewire('tar.tar-buy')

    </div>
 </div>

@stack('scripts')
@endsection












