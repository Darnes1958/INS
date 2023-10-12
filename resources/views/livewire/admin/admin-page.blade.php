

    <div class="row justify-content-center">

     <div class="row col-md-12 my-1 ">
       <div class="col-md-2">
         @livewire('admin.database-select')
       </div>

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
         <button  wire:click="LogUser" class="col-md-1 mx-1 btn btn-primary">
             Connected Users
         </button>
       <button  wire:click="FromExcel" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
         From Excell
       </button>
       <button  wire:click="ToHafitha" class="col-md-1 mx-1 btn btn-danger fas fa fa-table">
         Excell To Hafitha
       </button>
       <button  wire:click="FromExcel2" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
         From Excell2
       </button>
         <div class="col-md-1">
             <a  href="{{route('sendmail')}}"
                 class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;send email&nbsp;&nbsp;</i></a>
         </div>
       <button  wire:click="BuyPrice" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
             buy price
       </button>
         <div wire:loading wire:target="BuyPrice">
             Please Wait...
         </div>

       <div class="col-md-1">
         <a  href="{{route('SeeWelcomePage')}}"
             class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;Welcome Page&nbsp;&nbsp;</i></a>
       </div>
       <button  wire:click="Kaema" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
         Kaema
       </button>
         <button  wire:click="Mahjoza" class="col-md-1 mx-1 btn btn-danger fas fa fa-file-excel">
             Mahjoza
         </button>




     </div>
        @livewire('admin.rep-log-user')
     @livewire('admin.inp-user')
     @livewire('admin.inp-company')
     @livewire('admin.rep-company')
     @livewire('admin.rep-users')
     @livewire('admin.manage-roles')

     @livewire('admin.rep-roles')
     @livewire('admin.kaema')
     @livewire('admin.mahjoza')
     @livewire('admin.from-excel')

     @livewire('admin.to-hafitha')
     @livewire('admin.from-excel2')

    </div>

    @push('scripts')

      <script>

          $(document).ready(function ()
          {
              $('#Database_L').select2({
                  closeOnSelect: true
              });
              $('#Database_L').on('change', function (e) {
                  var data = $('#Database_L').select2("val");
              @this.set('database', data);

              @this.set('ThedatabaseListIsSelectd', 1);

              });
          });
          window.livewire.on('database-change-event',()=>{
              $('#Database_L').select2({
                  closeOnSelect: true
              });

          });
      </script>
    @endpush





