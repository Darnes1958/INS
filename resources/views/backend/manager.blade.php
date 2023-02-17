@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <div id="page-content" class="page-content" >
    <div class="container-fluid">

        @csrf

          @livewire('manager.manager-page')




    </div>
  </div>

  @stack('scripts')
@endsection
