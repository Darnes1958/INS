<div x-data x-show="$wire.showtable" class=" col-md-12" style="border:1px solid lightgray;background: white;padding: 4px;">
    <table class="table-sm table-bordered " width="100%"  id="orderlist" >
        <thead>
        <tr>
            <th width="15%">رقم الصنف</th>
            <th>اسم الصنف </th>
            <th width="10%">الكمية</th>
            <th width="15%">السعر </th>
            <th width="18%">المجموع</th>
            <th width="12%"></th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @foreach($orderdetail as $key => $item)
            @php if ($key==0) {
             continue; }
            @endphp
            <tr>
                <td style="color: #0c63e4; text-align: center"> {{ $item['item_no'] }} </td>
                <td > {{ $item['item_name'] }} </td>
                <td> {{ $item['quant'] }} </td>
                <td> {{ $item['price'] }} </td>
                <td> <input value="{{ $item['subtot'] }}" type="text"
                             class="form-control estimated_amount" readonly style="background-color: #ddd;" ></td>
                <td style="padding-top: 2px;padding-bottom: 2px; ">
                    <i wire:click.prevent="edititem({{$key}})" class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                    <i wire:click.prevent="removeitem({{$key}},{{$item['item_no']}},{{$item['quant']}})" class="btn btn-outline-danger btn-sm fa fa-times "></i>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tbody>
        <tr>
            <td colspan="4"> إجمالي الفاتورة</td>
            <td>
                <input wire:model="tot1" type="text" name="tot1"  id="tot1" class="form-control estimated_amount" readonly style="background-color: #ddd;" >
            </td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4"> خصم (تخفيض)  @error('ksm') <span class="error">{{ $message }}</span> @enderror</td>
            <td>
                <input wire:model="ksm" wire:keydown.enter="$emit('gotonext','ksm')" type="text" name="ksm" id="ksm" class="form-control estimated_amount"   >

            </td>
        </tr>
        <tr>
            <td colspan="4">المدفـــــــوع  @error('madfooh') <span class="error">{{ $message }}</span> @enderror</td>
            <td>
                <input wire:model="madfooh" wire:keydown.enter="$emit('gotonext','madfooh')" type="text" name="madfooh" id="madfooh" class="form-control estimated_amount"   >
            </td>
        </tr>

        <tr>
            <td colspan="4" style="color: #0c63e4;"> إجمالي الفاتورة النهائي</td>
            <td>
                <input wire:model="tot" type="text" name="tot"  id="tot" class="form-control estimated_amount"
                       readonly style="background-color: #ddd; color: #0c63e4;font-weight: bold ;" >
            </td>
            <td></td>
        </tr>
        </tbody>
    </table><br>


    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="ntoes" class="form-label">ملاحظات</label>
            <textarea wire:model="notes" name="description" class="form-control" id="description" placeholder="ملاحظات"></textarea>
        </div>
    </div><br>
    <div class="row new_customer" style="display:none">
        <div class="form-group col-md-4">
            <input type="text" name="name" id="name" class="form-control" placeholder="Write Customer Name">
        </div>
        <div class="form-group col-md-4">
            <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Write Customer Mobile No">
        </div>
        <div class="form-group col-md-4">
            <input type="email" name="email" id="email" class="form-control" placeholder="Write Customer Email">
        </div>
    </div>
    <!-- End Hide Add Customer Form -->
    <div class="form-group" >
        <button wire:click.prevent="store()" class="btn btn-info" id="storeButton">تخزين الفاتورة</button>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        window.addEventListener('doitemdelete',function(e){
            MyConfirm.fire({
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('DoItemDelete');
                }
            })
        });
        Livewire.on('gotonext',postid=>  {
            if (postid=='ksm') {  $("#madfooh").focus();  $("#madfooh").select();};
            if (postid=='madfooh') {  $("#ksm").focus();  $("#ksm").select();};
        });
    </script>
@endpush


