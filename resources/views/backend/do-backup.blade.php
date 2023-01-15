@extends('admin.admin_master')

@section('admin')

    <div id="page-content" class="page-content" >
        <div class="container-fluid">
            <div class="row mb-3 ">
                @csrf
                <div  class="col-md-4 themed-grid-col">
                    @livewire('do-backup')

                </div>

            </div>
        </div>
    </div>

    @stack('scripts')
@endsection
