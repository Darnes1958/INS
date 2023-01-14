@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf

            @if ($NewOld==1)
            <div class="row mb-3 ">
              <div  class="col-md-6 themed-grid-col">
                @livewire('aksat.inp-main-head')
              </div>
            </div>
            @endif
            @if ($NewOld==2)
                @livewire('aksat.inp-main-two')
            @endif




    </div>
  </div>

  @stack('scripts')
@endsection
