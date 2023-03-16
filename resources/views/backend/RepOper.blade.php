@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
        @csrf
          @livewire('manager.rep-oper')
    </div>
  </div>

  @stack('scripts')
@endsection
