<div x-data  class="row gy-1 my-1 w-50"  >
  <div class="col-md-6 my-1 ml-0 pl-0 d-inline-flex align-items-center">
    <div class=" form-check form-check-inline mx-1">
      <input class="form-check-input"  name="DateChk" type="checkbox" wire:model="DateChk"  >
      <label class="form-check-label" >التاريخ</label>
    </div>

    <input wire:model="created_at" wire:keydown.enter="ChkDateAndGo"
           class="form-control mx-0 px-1"
           type="date"  id="date" >

  </div>
  <div class="col-md-6 my-1 ml-0 pl-0 d-inline-flex align-items-center">
    <div class=" form-check form-check-inline mx-1">
      <input class="form-check-input"  name="ByChk" type="checkbox" wire:model="ByChk"  >
      <label class="form-check-label" >بواسطة</label>
    </div>
    <select  wire:model="By"  id="By" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;" >
      <option value="">اختيار</option>
      @foreach($UserName as $key=>$s)
        <option value="{{ $s->empno }}">{{ $s->name }}</option>
      @endforeach
    </select>

  </div>

  <div>
    <table class="table table-striped table-bordered table-sm ">
      <thead class="font-size-12">
      <tr class="bg-primary text-white">
        <th >الإجراء</th>
        <th >العملية</th>
        <th >التاريخ</th>
        <th >رقم المعاملة</th>
        <th >بواسطة</th>

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as $key=> $item)
        <tr class="font-size-12">
          <td> {{ $item->Proce }} </td>
          <td> {{$item->Oper }} </td>
          <td> {{$item->created_at }} </td>
          <td> {{$item->no }} </td>
          <td> {{$item->emp_name }} </td>
        </tr>
      @endforeach
      </tbody>
    </table>

  </div>
</div>
