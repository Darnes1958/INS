@extends('admin.admin_master')

@section('admin')

    <div id="page-content" class="page-content" >
        <div class="container-fluid">
            <div class="row mb-3 ">
                @csrf
                <div  class="col-md-6 themed-grid-col">
                    @livewire('aksat.rep.rep-main-head')
                    @livewire('aksat.rep.rep-main-data')
                </div>
                <div class="col-md-6 themed-grid-col px-1">
                    @livewire('aksat.rep.rep-main-trans')
                </div>

            </div>
        </div>
    </div>

    @stack('scripts')
@endsection
