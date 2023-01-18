

<div class=" justify-content-center">



   <div class="row my-1">
     <div class="col-md-2">
       <button  wire:click="InpUser" class=" mx-1 btn btn-primary">
         ادخال مستخدم جديد
       </button>
     </div>
     <div class="col-md-2">
       <button  wire:click="InpRole" class=" mx-1 btn btn-primary">
         منح وحجب الصلاحيات
       </button>
     </div>
       <div class="col-md-2">
           <button  wire:click="RepRole" class=" mx-1 btn btn-primary">
               استفسار عن الباقات و الصلاحيات
           </button>
       </div>
   </div>

    @livewire('manager.inp-userm')
    @livewire('manager.inp-rolem')
    @livewire('admin.rep-old-roles')



</div>

@push('scripts')

  <script>


  </script>
@endpush





