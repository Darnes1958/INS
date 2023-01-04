<div x-data x-show="$wire.Show" class="col-md-3">
    <div class="card">
        <div class="card-header">Add Roles</div>
        <div class="card-body">
            <div class="row mb-3">
                <label  class="col-md-4 col-form-label text-md-end">Role Name</label>
                <div class="col-md-6">
                    <input wire:model="newRole"  type="text" class="form-control"    autofocus>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button  wire:click="SaveRole" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Add Permission</div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="DataBase" class="col-md-4 col-form-label text-md-end">Permission Name</label>
                <div class="col-md-6">
                    <input wire:model="newPermission"  type="text" class="form-control"    autofocus>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button  wire:click="SavePermission" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
