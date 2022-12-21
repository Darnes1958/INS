<div class=" col-md-12" style="border:1px solid lightgray;background: white;padding: 4px;">
  <table class="table-sm table-bordered " width="100%"  id="perlist" >
    <thead>
    <tr>
      <th width="15%">رقم الصنف</th>
      <th>اسم الصنف </th>
      <th width="15%">الكمية</th>
      <th width="12%"></th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($perdetail as $key => $item)
      @php if ($key==0) {
             continue; }
      @endphp
      <tr>
        <td style="color: #0c63e4; text-align: center"> {{ $item['item_no'] }} </td>
        <td > {{ $item['item_name'] }} </td>
        <td> {{ $item['quant'] }} </td>
        <td style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click.prevent="edititem({{$key}})" class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
          <i  wire:click.prevent="removeitem({{$key}})" class="btn btn-outline-danger btn-sm fa fa-times "></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  <br>
  </table>

  <div class="form-group my-2" >

    <button wire:click.prevent="store()" class="btn btn-info" id="storeButton">تخزين اذن الصرف</button>

    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif


  </div>

</div>



