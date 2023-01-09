<div x-data x-show="$wire.Show" class="col-md-8">
    <div class="row">

        <div class="col-4">
            <div class="card">
                <div class="card-header" style="background: #0e8cdb;color: white">Roles</div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped  "  >
                        <thead class="font-size-12 font-weight-bolder " >
                        <tr style="background: royalblue; color: white"><th  >id</th><th >name</th></tr>
                        </thead>
                        <tbody >
                        @foreach($Users as $key=>$item)
                            <tr class="font-size-12">
                                <td ><a wire:click="selectUser({{ $item->id }})" href="#">{{ $item->id }}</a>  </td>
                                <td> {{ $item->name }} </td>
                            </tr>
                        @endforeach
                        </tbody> </table>
                    {{ $Users->links() }}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header" style="background: #0e8cdb;color: white">Roles</div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped  "  >
                        <thead class="font-size-12 font-weight-bolder " >
                        <tr style="background: royalblue; color: white"><th  >id</th><th >name</th></tr>
                        </thead>
                        <tbody >
                        @foreach($UserRole as $item)
                            <tr class="font-size-12">
                                <td ><a wire:click="selectRole({{ $item->id }})" href="#">{{ $item->id }}</a>  </td>
                                <td> {{ $item->name }} </td>
                            </tr>
                        @endforeach
                        </tbody> </table>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header" style="background: #0e8cdb;color: white">Permissions</div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped  "  >
                        <thead class="font-size-12 font-weight-bolder " >
                        <tr style="background: royalblue; color: white"><th  >id</th><th >name</th></tr>
                        </thead>
                        <tbody >
                        @foreach($UserPer as $key=>$item)
                            <tr class="font-size-12">
                                <td > {{ $item->id }} </td>
                                <td> {{ $item->name }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

