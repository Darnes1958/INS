@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-6 themed-grid-col">
          @livewire('aksat.rep.okod.rep-main-head-arc2')
          @livewire('aksat.rep.okod.rep-main-data-arc2')
        </div>
        <div class="col-md-6 themed-grid-col px-1">
          @livewire('aksat.rep.okod.rep-main-trans-arc2')
        </div>

      </div>
    </div>
  </div>

  @stack('scripts')
@endsection