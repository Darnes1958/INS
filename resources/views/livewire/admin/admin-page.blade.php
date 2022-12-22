

    <div class="row justify-content-center">

     <div class="row col-md-12">
         <div class="col-md-6 offset-md-4">
             <button  wire:click="InpUser" class="btn btn-primary">
                 Input New User
             </button>
             <button  wire:click="InpCompany" class="btn btn-primary">
                 Input New Company
             </button>
           <button  wire:click="RepCompany" class="btn btn-primary">
             Report about Company
           </button>
         </div>
     </div>
     @livewire('admin.inp-user')
     @livewire('admin.inp-company')
     @livewire('admin.rep-company')
    </div>


