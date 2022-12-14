@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-8 themed-grid-col">
          @livewire('aksat.rep.okod.rep-main-head')

        </div>
        <div class="col-md-8 themed-grid-col ">
          @if ($EditDel==1)
           @livewire('aksat.edit-main-data',['edit'=>true,'del'=>false])
          @endif
          @if ($EditDel==2)
              @livewire('aksat.edit-main-data',['edit'=>false,'del'=>true])
          @endif

        </div>
      </div>
    </div>
  </div>

  @stack('scripts')
@endsection
