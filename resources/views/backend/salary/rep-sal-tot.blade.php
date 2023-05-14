@extends('admin.admin_master')

@section('admin')
   <div >
         @livewire('salary.rep-sal-tot')
   </div>


  @stack('scripts')
@endsection
