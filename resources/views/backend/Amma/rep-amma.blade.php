@extends('admin.admin_master')

@section('admin')

<div id="page-content" class="page-content" >
  <div class="container-fluid">

    @csrf
    @if ($rep=='mak')
    <div class=" themed-grid-col px-1">
      @livewire('amma.mak.mak-rep')
    </div>
    @endif


  </div>
</div>

@stack('scripts')
@endsection
