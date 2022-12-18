@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
        <div  class="col-md-6 themed-grid-col">
          @if ($Proc=='over')
            @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-over','mainorarc'=>'main'])
            @livewire('over-tar.inp-over',['proc'=>'over_kst'])
          @endif
          @if ($Proc=='over_a')
              @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-over','mainorarc'=>'mainarc'])
            @livewire('over-tar.inp-over',['proc'=>'over_kst_a'])
          @endif
          @if ($Proc=='tar_list') @livewire('over-tar.inp-tar')  @endif

        </div>
        <div  class="col-md-6 themed-grid-col">
            @if ($Proc=='over')
                @livewire('over-tar.over-table',['proc'=>'over_kst'])
            @endif
            @if ($Proc=='over_a')
                @livewire('over-tar.over-table',['proc'=>'over_kst_a'])
            @endif
            @if ($Proc=='tar_list')  @livewire('over-tar.tar-table')  @endif

        </div>

      </div>
    </div>
  </div>

  @stack('scripts')
@endsection

