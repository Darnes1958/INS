

    <div class="row justify-content-center">

     <div class="row col-md-12 my-1 ">

             <button  wire:click="InpUser" class="col-md-1 mx-1 btn btn-primary">
                 Input New User
             </button>
             <button  wire:click="InpCompany" class="col-md-1 mx-1 btn btn-primary">
                 Input New Company
             </button>
           <button  wire:click="RepCompany" class="col-md-1 mx-1 btn btn-primary">
             Report about Company
           </button>
             <button  wire:click="RepUsers" class="col-md-1 mx-1 btn btn-primary">
                 Report Users
             </button>
         <button  wire:click="InpRole" class="col-md-1 mx-1 btn btn-primary">
             Add Roles
         </button>
         <button  wire:click="RepRole" class="col-md-1 mx-1 btn btn-primary">
             Rep Roles
         </button>
         <button  wire:click="Clickme" class="col-md-1 mx-1 btn btn-primary">
             {{$text}}
         </button>
       <button  wire:click="FromExcel" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
         From Excell
       </button>
       <button  wire:click="ToHafitha" class="col-md-1 mx-1 btn btn-danger fas fa fa-table">
         Excell To Hafitha
       </button>


     </div>
     @livewire('admin.inp-user')
     @livewire('admin.inp-company')
     @livewire('admin.rep-company')
     @livewire('admin.rep-users')
     @livewire('admin.manage-roles')
     @livewire('admin.rep-old-roles')
     @livewire('admin.rep-roles')
     @livewire('admin.from-excel')
      @livewire('admin.to-hafitha')
    </div>




