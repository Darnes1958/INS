@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">

        <div  class="col-md-12 themed-grid-col">

          @livewire('buy.rep-order-buy')
        </div>

      </div>
    </div>
  </div>

  @stack('scripts')
@endsection

