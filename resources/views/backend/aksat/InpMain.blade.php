@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-6 themed-grid-col">
            @if ($NewOld==1)
                @livewire('aksat.inp-main-head')
            @endif
            @if ($NewOld==2)
                @livewire('aksat.inp-main-two')
            @endif

        </div>

      </div>
    </div>
  </div>

  @stack('scripts')
@endsection
