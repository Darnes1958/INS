<div   class="row gy-1 my-1" style="border:1px solid lightgray;background: #bfd1ec; " >

    <div x-data  class="col-md-12 my-1">
        <input  wire:model="search" wire:click="OpenTable" placeholder="ابحث هنا .... "
                class="form-control"   type="text"  >
        <div x-show="$wire.IsSearch">
            <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
                <thead class="font-size-12">
                <tr>
                    <th>رقم العقد</th>
                    <th>رقم الحساب</th>
                    <th>الاسم</th>
                    <th>اجمالي التقسيط</th>
                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @foreach($TableList as  $item)
                    <tr class="font-size-12">
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#">{{$item->no}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#">{{$item->acc}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#" >{{$item->name}}</a>
                        <td > <a wire:click="selectItem({{ $item->no }})" href="#" >{{$item->sul}}</a>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $TableList->links('custom-pagination-links-view') }}
        </div>
    </div>



</div>

@push('scripts')
    <script>
        window.addEventListener('CloseKstManyModal', event => {
            $("#ModalKstMany").modal('hide');
        })
        window.addEventListener('OpenKstManyModal', event => {
            $("#ModalKstMany").modal('show');
        })
    </script>
    <script type="text/javascript">
        Livewire.on('ksthead_goto',postid=>  {

            if (postid=='no') {  $("#no").focus();$("#no").select(); }
            if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
        })
    </script>

    <script>


        $(document).ready(function ()
        {
            $('#Main_L_All').select2({
                closeOnSelect: true
            });
            $('#Main_L_All').on('change', function (e) {
                var data = $('#Main_L_All').select2("val");
            @this.set('no', data);

            });
        });
        window.livewire.on('main-change-event',()=>{
            $('#Main_L_All').select2({
                closeOnSelect: true
            });

        });
    </script>
@endpush


