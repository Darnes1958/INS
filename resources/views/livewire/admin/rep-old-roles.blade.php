<div x-data x-show="$wire.Show" class="col-md-9">
   <div class="row">
     <div class="col-3">
         <div class="card">
             <div class="card-header " style="background: #0e8cdb;color: white">System Root</div>
             <div class="card-body" >
                 <table class="table table-sm table-bordered table-striped"   >
                     <thead >
                     <tr style="background: royalblue; color: white"><th  >role_root_no</th><th >role_root_name</th></tr>
                     </thead>
                     <tbody >
                     @foreach($RootTable as $key=>$item)
                      <tr class="font-size-12">

                      <td> <a wire:click="selectItem({{ $item->role_root_name }})" href="#">{{$item->role_root_no}}</a> </td>
                      <td> <a wire:click="$emit('TakeOldRole',{{ $item->role_root_name }})" href="#">{{ $item->role_root_name }}</a> </td>
                      </tr>
                     @endforeach
                     </tbody>
                 </table>
                 {{ $RootTable->links() }}
             </div>
         </div>
     </div>
       <div class="col-3">
           <div class="card">
               <div class="card-header " style="background: #0e8cdb;color: white">System Root</div>
               <div class="card-body" >
                   <table class="table table-sm table-bordered table-striped"   >
                       <thead >
                       <tr style="background: royalblue; color: white"><th  >role_root_no</th><th >role_root_name</th></tr>
                       </thead>
                       <tbody >
                       @foreach($OldRoleTable as $key=>$item)
                           <tr class="font-size-12">

                               <td> <a wire:click="selectItem({{ $item->role }})" href="#">{{$item->role_root}}</a> </td>
                               <td> <a wire:click="$emit('TakeOldRole',{{ $item->role }})" href="#">{{ $item->role }}</a> </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
                   {{ $OldRoleTable->links() }}
               </div>
           </div>
       </div>
     <div class="col-3">
           <div class="card">
               <div class="card-header" style="background: #0e8cdb;color: white">Roles</div>
               <div class="card-body">
                   <table class="table table-sm table-bordered table-striped  "  >
                       <thead class="font-size-12 font-weight-bolder " >
                       <tr style="background: royalblue; color: white"><th  >id</th><th >name</th></tr>
                       </thead>
                       <tbody >
                       @foreach($RolesTable as $key=>$item)
                           <tr class="font-size-12"><td > {{ $item->id }} </td>
                               <td> {{ $item->name }} </td> </tr>
                       @endforeach
                       </tbody> </table>
                   {{ $RolesTable->links() }}
               </div>
           </div>
       </div>
     <div class="col-3">
           <div class="card">
               <div class="card-header" style="background: #0e8cdb;color: white">Permissions</div>
               <div class="card-body">
                   <table class="table table-sm table-bordered table-striped  "  >
                       <thead class="font-size-12 font-weight-bolder " >
                       <tr style="background: royalblue; color: white"><th  >id</th><th >name</th></tr>
                       </thead>
                       <tbody >
                       @foreach($PermissionTable as $key=>$item)
                           <tr class="font-size-12"><td > {{ $item->id }} </td> <td> {{ $item->name }} </td> </tr>
                       @endforeach
                       </tbody> </table>
                   {{ $PermissionTable->links() }}
               </div>
           </div>
       </div>
   </div>
</div>

