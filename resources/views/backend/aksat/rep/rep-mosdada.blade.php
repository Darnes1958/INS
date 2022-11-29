@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf

        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.mosdada-table')
        </div>


    </div>
  </div>

  @stack('scripts')
@endsection
