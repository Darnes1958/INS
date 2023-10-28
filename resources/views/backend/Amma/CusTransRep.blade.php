@extends('admin.admin_master')

@section('admin')

<div id="page-content" class="page-content" >
  <div class="container-fluid">
      <div class=" themed-grid-col px-1">
        @livewire('admin.rep-cus-trans')
      </div>


  </div>
</div>

@stack('scripts')
@endsection
