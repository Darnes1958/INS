<div class="col-md-12 col-lg-12 ">


    <div class="col-md-12 my-2">
        <label for="name" class="form-label">البيان</label>
        <input wire:model="DetailNameAdd"  wire:keydown.enter="SaveOne" type="text" class="form-control" id="name" placeholder="" autofocus>
        @error('name') <span class="error">{{ $message }}</span> @enderror
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table-sm table-bordered " width="100%"  id="itemtype" >
        <thead>
        <tr>
            <th width="30%">الرقم الألي</th>
            <th>البيان</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($itemtypes as $key => $item)
            <tr>
                <td style="color: #0c63e4; text-align: center"> {{ $item['DetailNo'] }} </td>
                <td > {{ $item['DetailName'] }} </td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->DetailNo }},'update')"
                       class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                </td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click="selectItem({{ $item->DetailNo }},'delete')"
                       class="btn btn-outline-danger btn-sm fa fa-times "></i>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $itemtypes->links() }}


</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('deldetail',function(e){
            MyConfirm.fire({
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('DoDeleteDetail');
                }
            })
        });
        window.addEventListener('mmsg',function(e){
            MyMsg.fire({
                confirmButtonText:  e.detail,
            })
        });
        $(document).ready(function() {
            $.fn.DataTable.ext.pager.numbers_length = 10;
            $('#itemtype').DataTable( {
                "pagingType":"full_numbers",
            } );
        } );
        Livewire.on('gotonext',postid=>  {

            if (postid=='DetailNameAdd') {  $("#name").focus();$("#name").select(); };

        })

    </script>
@endpush
