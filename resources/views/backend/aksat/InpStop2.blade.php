@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      @livewire('over-tar.inp-stop2')
    </div>
  </div>

  @stack('scripts')
@endsection

