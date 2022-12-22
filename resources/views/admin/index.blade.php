@extends('admin.admin_master')

@section('admin')


<div  class="page-content" dir="rtl" >
  @php
    $id = Auth::user()->id;
info($id);
  @endphp
  @if ($id!=1)
   @livewire('admin.welcome-page')
  @endif
  @if ($id==1)
    @livewire('admin.admin-page')
  @endif

</div>
@endsection
