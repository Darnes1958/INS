@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf

            @if ($NewOld==1)

                @livewire('aksat.inp-main-head')

            </div>
            @endif
            @if ($NewOld==2)
                @livewire('aksat.inp-main-two')
            @endif




    </div>
  </div>

  @stack('scripts')
@endsection
