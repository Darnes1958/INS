<div x-data="{xcharge_by:  @entangle('charge_by'),xcharge_type:  @entangle('charge_type'),
            xcharge_open:  @entangle('showcharge')}"
      style="border:1px solid lightgray;background: white; padding: 6px; margin-right: 2px;"
      x-show="xcharge_open" x-trap="xcharge_open">

<div class="d-inline-flex  w-100  " style="background: #1c6ca1;color: white; padding-top: 4px;">
    <h6 style="color: white ;width: 50%">ادخال تكاليف اضافية</h6>
    <h6 style="width: 30%">&nbsp;</h6>
    <a class="  fas fa-arrow-right " style="color: yellow;width: 20%" @click="xcharge_open=false" href="#">&nbsp;&nbsp;رجوع&nbsp;&nbsp;</a>
</div>
  <div class="row">

    <div  class="col-md-8  d-inline-flex my-2 " >
      <label  class="form-label-me w-sm">المنفذ</label>
      <select  x-model="xcharge_by"  @change="$refs.xchargebyid.focus()"
               class="form-control  form-select mx-1 text-center"
               style="vertical-align: middle ;font-size: 14px;height: 26px;padding-bottom:0;padding-top: 0;"  >
        <option value=""> اختيار </option>
        @foreach($charge_by_table as $key=>$s)
          <option value="{{ $s->no }}">{{ $s->name }}</option>
        @endforeach
      </select>
    </div>
    <div  class="col-md-4  d-inline-flex my-2 " >
      <input wire:model="charge_by" class="form-control mx-1 text-center" type="number"
             @keydown.enter="$refs.xchargetypeid.focus()"   x-ref="xchargebyid">

    </div>
    @error('charge_by') <span class="error">{{ $message }}</span> @enderror
    <div  class="col-md-8  d-inline-flex my-2 " >
      <label  class="form-label-me  w-sm">بيان التكلفة</label>
      <select x-model="xcharge_type"  @change="$refs.xchargetypeid.focus()"
               class="form-control  form-select mx-1 text-center"
              style="vertical-align: middle ;font-size: 14px;height: 26px;padding-bottom:0;padding-top: 0;"
      >
        <option value=""> اختيار </option>
        @foreach($charge_type_table as $key=>$s)
          <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
        @endforeach
      </select>
    </div>
      <div  class="col-md-4  d-inline-flex my-2 " >

      <input wire:model="charge_type" class="form-control mx-1 text-center" type="number"
             @keydown.enter="$refs.xval_input.focus()"  id="charge_type_input" x-ref="xchargetypeid">

    </div >

    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me w-sm">المبلغ</label>
      <input type="number" wire:model="val"
             @keydown.enter="$wire.Do; $nextTick(() => { $refs.xchargebyid.focus(); })"
             class="form-control text-center"  x-ref="xval_input">
    </div>

    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me w-sm">الاجمالي</label>
      <input type="number" wire:model="TotCharge"   class="form-control" id="totcharge" readonly>
    </div>
    @error('val') <span class="error">{{ $message }}</span> @enderror

  </div>




  <div style="border:1px solid lightgray;background: white;padding: 4px;">
    <table class="table-sm table-bordered " width="100%"  id="perlist" >
      <thead>
      <tr style="background: #1c6ca1;color: white;text-align: center">
        <th width="35%">البيان</th>
        <th width="35%">المنفذ</th>
        <th width="20%">المبلغ</th>
        <th width="5%"></th>
        <th width="5%"></th>

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($ChargeDetail as $key => $item)
        @php if ($key==0) {
             continue; }
        @endphp
        <tr>
          <td style="color: #0c63e4; "> {{ $item['type_name'] }} </td>
          <td > {{ $item['name'] }} </td>
          <td> {{ $item['val'] }} </td>
          <td style="padding-top: 2px;padding-bottom: 2px; ">
            <i wire:click.prevent="edititem({{$key}})" class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i></td>
          <td>
            <i  wire:click.prevent="removeitem({{$key}})" class="btn btn-outline-danger btn-sm fa fa-times "></i>
          </td>
        </tr>
      @endforeach
      </tbody>
      <br>
    </table>

</div>
</div>

@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush


