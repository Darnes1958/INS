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
      @if ($rep=='itemrep')
          <div class="row g-3 ">
              @livewire('amma.mak.item-rep')
          </div>
      @endif
      @if ($rep=='daily')
          <div class=" themed-grid-col px-1">
              @livewire('amma.daily-rep')
          </div>
      @endif


  </div>
</div>

@stack('scripts')
@endsection
