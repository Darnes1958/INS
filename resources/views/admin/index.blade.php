@extends('admin.admin_master')

@section('admin')


<div  class="page-content my-1 py-1" dir="rtl" >

  @auth

      @php
          $id = Auth::user()->id;
      @endphp

      @if ($id!=1)
       @livewire('admin.welcome-page')
      @endif
      @if ($id==1)
        @livewire('admin.admin-page')
      @endif
    @endauth

</div>
@endsection
