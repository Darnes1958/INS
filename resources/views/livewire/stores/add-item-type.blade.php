<div class="col-md-12 col-lg-12 ">


    <div class="col-md-12 my-2">
        <label for="name" class="form-label">الاســـم</label>
        <input wire:model="name"  wire:keydown.enter="SaveOne" type="text" class="form-control" id="name" placeholder="" autofocus>
        @error('name') <span class="error">{{ $message }}</span> @enderror
    </div>

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
                <td style="color: #0c63e4; text-align: center"> {{ $item['type_no'] }} </td>
                <td > {{ $item['type_name'] }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $itemtypes->links() }}

</div>

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function() {
            $.fn.DataTable.ext.pager.numbers_length = 10;
            $('#itemtype').DataTable( {
                "pagingType":"full_numbers",
            } );
        } );

    </script>
@endpush
