@extends('admin.admin_master')

@section('admin')
    <link href="{{asset('backend/assets/js/printPage')}}" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

