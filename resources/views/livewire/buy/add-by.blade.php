<div class="col-md-12 col-lg-12 ">


    <div class="col-md-12 my-2">
        <label for="name" class="form-label">الاســـم</label>
        <input wire:model="name"  wire:keydown.enter="SaveOne" type="text" class="form-control" id="name" placeholder="" autofocus>
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
            <th width="5%"> </th>
            <th width="5%"> </th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($items as $key => $item)
            <tr>
                <td style="color: #0c63e4; text-align: center"> {{ $item['no'] }} </td>
                <td > {{ $item['name'] }} </td>
                <td><i wire:click="EditOne({{ $item['no'] }},'{{$item['name']}}')"
                       class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i></td>
                <td><i wire:click="DeleteOne({{ $item['no'] }})"
                       class="btn btn-outline-danger btn-sm fa fa-times" style="margin-left: 2px;"></i></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}

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
