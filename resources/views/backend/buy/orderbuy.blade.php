@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">


          @livewire('buy.order-buy')


    </div>
  </div>

  @stack('scripts')
@endsection

