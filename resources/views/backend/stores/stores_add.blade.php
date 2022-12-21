@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-4 themed-grid-col">
          @livewire('stores.store-head',['FromTo'=>$from_to])
          @livewire('stores.store-detail')
        </div>
        <div class="col-md-6 themed-grid-col px-1">
          @livewire('stores.store-table')
        </div>
      </div>
    </div>
  </div>

  @stack('scripts')
@endsection
