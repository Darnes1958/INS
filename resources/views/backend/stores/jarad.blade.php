@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

          @livewire('stores.jarad-head')

    </div>
  </div>

  @stack('scripts')
@endsection
