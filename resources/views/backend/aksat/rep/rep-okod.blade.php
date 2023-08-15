@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf
      @if ($rep=='kstgeted')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.kst-geted')
        </div>
      @endif
      @if ($rep=='aksatgeted')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.aksat-geted')
        </div>
      @endif

      @if ($rep=='before')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.before')
        </div>
      @endif

      @if ($rep=='haf')
        <div class=" themed-grid-col px-1">
          @livewire('haf.rep-haf')
        </div>
      @endif
      @if ($rep=='over')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.over')
        </div>
      @endif
      @if ($rep=='tar')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.tar')
        </div>
      @endif

      @if ($rep=='wrong')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.wrong')
        </div>
      @endif
      @if ($rep=='aksatdeffer')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.aksat-deffer')
        </div>
      @endif

      @if ($rep=='stop')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.stop')
        </div>
      @endif

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
      @if ($rep=='bankkstcount')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.bank-kst-count')
        </div>
      @endif
        @if ($rep=='placesum')
            <div class=" themed-grid-col px-1">
                @livewire('aksat.rep.okod.place-sum')
            </div>
        @endif
      @if ($rep=='ratiosum')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.ratio-sum')
        </div>
      @endif
      @if ($rep=='bankone')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.bank-one')
        </div>
      @endif
      @if ($rep=='kaema')
        <div class=" themed-grid-col px-1">
          @livewire('aksat.rep.okod.rep-kaema')
        </div>
      @endif
        @if ($rep=='mahjoza')
            <div class=" themed-grid-col px-1">
                @livewire('aksat.rep.okod.rep-mahjoza')
            </div>
        @endif
    </div>
  </div>

  @stack('scripts')
@endsection
