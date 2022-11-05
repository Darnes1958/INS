

    <div  wire:ignore  >

        <select  class="form-control" id="select2-dropdown" >
            <option value="2">مشتريات عامة</option>
            @foreach($select_name as $key => $item)
                <option value="{{ $item->jeha_no }}">{{ $item->jeha_name }}</option>
            @endforeach
        </select>
    </div>

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#select2-dropdown').select2();
            $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            var data2 =   $("#select2-dropdown option:selected").text();
            @this.set('select_no', data);
            $("#jehalabel").text(data2);
            Livewire.emit('jehachange', data);
            });
        });
    </script>
@endpush
