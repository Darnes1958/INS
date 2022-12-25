

    <div class="row justify-content-center">

     <div class="row col-md-12 my-1 ">

             <button  wire:click="InpUser" class="col-md-2 mx-1 btn btn-primary">
                 Input New User
             </button>
             <button  wire:click="InpCompany" class="col-md-2 mx-1 btn btn-primary">
                 Input New Company
             </button>
           <button  wire:click="RepCompany" class="col-md-2 mx-1 btn btn-primary">
             Report about Company
           </button>
             <button  wire:click="RepUsers" class="col-md-2 mx-1 btn btn-primary">
                 Report Users
             </button>

     </div>
     @livewire('admin.inp-user')
     @livewire('admin.inp-company')
     @livewire('admin.rep-company')
     @livewire('admin.rep-users')
    </div>




