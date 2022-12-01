@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf
      @if ($rep=='mosdada')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.mosdada-table')
        </div>
      @endif
      @if ($rep=='kamla')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.kamla')
        </div>
      @endif
      @if ($rep=='banksum')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.bank-sum')
        </div>
      @endif
      @if ($rep=='bankone')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.bank-one')
        </div>
      @endif

    </div>
  </div>

  @stack('scripts')
@endsection
