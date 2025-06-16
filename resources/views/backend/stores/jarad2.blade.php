@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

          @livewire('stores.jarad-head2')

    </div>
  </div>

  @stack('scripts')
@endsection
