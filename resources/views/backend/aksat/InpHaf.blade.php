@extends('admin.admin_master')

@section('admin')
  <
  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-6 themed-grid-col">
          @livewire('haf.haf-input-header')
          @livewire('haf.haf-input-detail')
        </div>
        <div class="col-md-6 themed-grid-col px-1">
          @livewire('haf.haf-input-table')
        </div>
      </div>
    </div>
  </div>

  @stack('scripts')
@endsection
