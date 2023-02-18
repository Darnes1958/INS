@extends('admin.admin_master')

@section('admin')

    <div id="page-content" class="page-content" >
        <div class="container-fluid">
            <div class="row mb-3 ">
                @csrf
                <div  class="col-md-7 themed-grid-col">
                    @livewire('aksat.rep.okod.rep-main-all-head')
                    @livewire('aksat.rep.okod.rep-main-all-data')
                </div>
                <div class="col-md-5 themed-grid-col px-1">
                    @livewire('aksat.rep.okod.rep-main-all-trans')
                </div>

            </div>
        </div>
    </div>

    @stack('scripts')
@endsection

