@extends('admin.admin_master')

@section('admin')

  <div id="page-content" class="page-content" >
    <div class="container-fluid">
      <div class="row mb-3 ">
        @csrf
          @if ($Proc=='tar_maksoom')
              <div  class="col-md-8 themed-grid-col">
               @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.tar2-detail','mainorarc'=>'main'])
               @livewire('over-tar.tar2-detail')
              </div>
          @endif
        @if ($Proc=='chk')
          <div  class="col-md-8 themed-grid-col">
          @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-chk','mainorarc'=>'main'])
          @livewire('over-tar.inp-chk',['MainOrArc'=>'main'])
          </div>
        @endif
          <div  class="col-md-6 themed-grid-col">

              @if ($Proc=='chk_a')
                @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-chk','mainorarc'=>'mainarc'])
                @livewire('over-tar.inp-chk',['MainOrArc'=>'MainArc'])
              @endif
          @if ($Proc=='over')
            @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-over','mainorarc'=>'main'])
            @livewire('over-tar.inp-over',['proc'=>'over_kst'])
          @endif
          @if ($Proc=='over_a')
              @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-over','mainorarc'=>'mainarc'])
            @livewire('over-tar.inp-over',['proc'=>'over_kst_a'])
          @endif
              @if ($Proc=='stop_kst')
                  @livewire('over-tar.get-no-and-acc',['towhome'=>'over-tar.inp-stop','mainorarc'=>'main'])
                  @livewire('over-tar.inp-stop')
              @endif
          @if ($Proc=='tar_list') @livewire('over-tar.inp-tar')  @endif
          @if ($Proc=='wrong') @livewire('over-tar.inp-wrong')  @endif


        </div>
        <div  class="col-md-6 themed-grid-col">
            @if ($Proc=='over')
                @livewire('over-tar.over-table',['proc'=>'over_kst'])
            @endif
            @if ($Proc=='over_a')
                @livewire('over-tar.over-table',['proc'=>'over_kst_a'])
            @endif
                @if ($Proc=='stop_kst')
                    @livewire('over-tar.stop-table')
                @endif
            @if ($Proc=='tar_list')  @livewire('over-tar.tar-table')  @endif
            @if ($Proc=='wrong')     @livewire('over-tar.wrong-table')  @endif



        </div>

      </div>
    </div>
  </div>

  @stack('scripts')
@endsection

