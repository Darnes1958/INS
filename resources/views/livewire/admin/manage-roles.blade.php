<div x-data x-show="$wire.Show" class="col-md-4">
    <div class="card my-0">
        <div class="card-header" style="height: 28px;">Add Roles</div>
        <div class="card-body py-0">
            <select  wire:model="newRole"  id="role_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                @foreach($roleTable as $s)
                    <option value="{{ $s->role_root_name }}">{{ $s->role_root_name }}</option>
                @endforeach
            </select>
            <div class="row ">
                <div class="col-md-3 p-0 mx-2">
                <label  class=" col-form-label ">Role Name</label>
                </div>
                <div class="col-md-5 my-2 p-0">
                    <input wire:model="newRole"  type="text" class="form-control"    autofocus>
                </div>
                <div class="col-md-3 my-2 " style="height: 28px;">
                    <button  wire:click="SaveRole" class="btn btn-primary" style="height: 28px;">
                        Save
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="card my-0">
        <div class="card-header" style="height: 28px;">Add Permission</div>
        <div class="card-body py-0">
            <select  wire:model="newPermission"  id="permission_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                @foreach($permissionTable as $s)
                    <option value="{{ $s->role }}">{{ $s->role }}</option>
                @endforeach
            </select>
            <div class="row ">
                <div class="col-md-3 p-0 mx-2">
                    <label  class=" col-form-label ">Permission</label>
                </div>
                <div class="col-md-5 my-2 p-0">
                    <input wire:model="newPermission"  type="text" class="form-control"    autofocus>
                </div>
                <div class="col-md-3 my-2 " style="height: 28px;">
                    <button  wire:click="SavePermission" class="btn btn-primary " style="height: 28px;">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-0">
        <div class="card-header" style="height: 28px;">Permission To Role</div>
        <div class="card-body py-0">

            <div class="row  ">
                <div class="col-md-6">
                    <select  wire:model="TheRole"  id="role2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        @foreach($role2Table as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input wire:model="TheRole"  type="text" class="form-control"    autofocus>
                </div>
            </div>

            <div class="row  ">
                <div class="col-md-6  ">
                    <select  wire:model="ThePermission"  id="permission2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        @foreach($per2Table as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 ">
                    <input wire:model="ThePermission"  type="text" class="form-control"    autofocus>
                </div>
                <div class="col-md-3 my-2 " style="height: 28px;">
                    <button  wire:click="SaveRelation" class="btn btn-primary" style="height: 28px;">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-0">
        <div class="card-header" style="height: 28px;">Role To User</div>
        <div class="card-body py-0">
            <div class="row  ">
                <div class="col-md-6">
                    <select  wire:model="TheUser"  id="role2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        <option >اختيار</option>
                        @foreach($users as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input wire:model="TheUser"  type="text" class="form-control"    autofocus>
                </div>
            </div>

            <div class="row  ">
                <div class="col-md-6  ">
                    <select  wire:model="TheRole"  id="roleuser2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        <option >اختيار</option>
                        @foreach($role2Table as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 ">
                    <input wire:model="TheRole"  type="text" class="form-control"    autofocus>
                </div>
                <div class="col-md-3 my-2 d-flex " style="height: 28px;">
                    <button  wire:click="SaveUserRole" class="btn btn-primary mx-4" style="height: 28px;">
                        Save
                    </button>
                    <button  wire:click="RemoveUserRole" class="btn btn-danger" style="height: 28px;">
                        Remove
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div class="card my-0">
        <div class="card-header" style="height: 28px;">Permission To User</div>
        <div class="card-body py-0">
            <div class="row  ">
                <div class="col-md-6">
                    <select  wire:model="TheUser"  id="per2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        <option >اختيار</option>
                        @foreach($users as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input wire:model="TheUser"  type="text" class="form-control"    autofocus>
                </div>
            </div>

            <div class="row  ">
                <div class="col-md-6  ">
                    <select  wire:model="ThePermission"  id="peruser2_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                        <option >اختيار</option>
                        @foreach($per2Table as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 ">
                    <input wire:model="ThePermission"  type="text" class="form-control"    autofocus>
                </div>
                <div class="col-md-3 my-2 d-flex" style="height: 28px;">
                    <button  wire:click="SaveUserPermission" class="btn btn-primary mx-4" style="height: 28px;">
                        Save
                    </button>
                    <button  wire:click="RemoveUserPermission" class="btn btn-danger" style="height: 28px;">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">


        Livewire.on('gotonext',postid=>  {


            if (postid=='ThePermission') {  $("#ThePermission").focus(); $("#ThePermission").select();};
            if (postid=='editksm') { $("#editksm").focus();  $("#editksm").select(); };
            if (postid=='editksmnotes') {  $("#editnotes").focus(); $("#editnotes").select();};

            if (postid=='edit-save-ksm') { setTimeout(function() { document.getElementById('edit-save-ksm').focus(); },100);};

        })

    </script>
@endpush
