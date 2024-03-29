@extends('admin.admin_master')

@section('admin')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-6 themed-grid-col">
          @livewire('aksat.inp-kst-head2')
          @livewire('aksat.inp-kst-detail')
        </div>
        <div class="col-md-6 themed-grid-col px-1">
          @livewire('aksat.inp-kst-table')
        </div>
      </div>
    </div>
  </div>

  @stack('scripts')
@endsection
