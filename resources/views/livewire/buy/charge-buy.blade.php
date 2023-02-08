<div x-data="{xcharge_by:  @entangle('charge_by'),xcharge_type:  @entangle('charge_type')}" class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

<div class="col-md-6">
  <div class="row">
    <div  class="col-md-12  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">المنفذ</label>
      <select  x-model="xcharge_by"  @change="$focus.focus(charge_by_input)" id="charge_by_l" class="form-control  form-select mx-1 text-center"
               style="vertical-align: middle ;font-size: 14px;height: 26px;padding-bottom:0;padding-top: 0;"  >
        <option value=""> اختيار </option>
        @foreach($charge_by_table as $key=>$s)
          <option value="{{ $s->no }}">{{ $s->name }}</option>
        @endforeach
      </select>
      <input wire:model="charge_by" class="form-control mx-1 text-center" type="number"  @keydown.enter="$focus.focus(charge_type_input)"  id="charge_by_input" >

    </div>
    @error('charge_by') <span class="error">{{ $message }}</span> @enderror
    <div  class="col-md-12  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">بيان التكلفة</label>
      <select x-model="xcharge_type"  @change="$focus.focus(charge_type_input)"  id="charge_type_l" class="form-control  form-select mx-1 text-center"
              style="vertical-align: middle ;font-size: 14px;height: 26px;padding-bottom:0;padding-top: 0;"
      >
        <option value=""> اختيار </option>
        @foreach($charge_type_table as $key=>$s)
          <option value="{{ $s->type_no }}">{{ $s->type_name }}</option>
        @endforeach
      </select>

      <input wire:model="charge_type" class="form-control mx-1 text-center" type="number"  @keydown.enter="$focus.focus(val)"  id="charge_type_input" >

    </div >

    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">المبلغ</label>
      <input type="number" wire:model="val" wire:keydown.enter="Do" @keydown.enter="$focus.focus(charge_by_input)" class="form-control" id="val">
    </div>

    <div  class="col-md-6  d-inline-flex my-2 " >
      <label  class="form-label-me mx-1">الاجمالي</label>
      <input type="number" wire:model="TotCharge"   class="form-control" id="totcharge" readonly>
    </div>
    @error('val') <span class="error">{{ $message }}</span> @enderror

  </div>

</div>


  <div class=" col-md-6" style="border:1px solid lightgray;background: white;padding: 4px;">
    <table class="table-sm table-bordered " width="100%"  id="perlist" >
      <thead>
      <tr>
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
          <td style="color: #0c63e4; text-align: center"> {{ $item['type_name'] }} </td>
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


