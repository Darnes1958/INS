@extends('admin.admin_master')

@section('admin')
   <div class="col-md-6">
         @livewire('salary.rep-salaries')
   </div>


  @stack('scripts')
@endsection
