<div>
    <div class="row  my-1" style="border:1px solid lightgray;background: white; " >
        <div class="col-md-5 my-2 ">
            <div class="row">
                <div class="col-md-6 my-2 d-inline-flex ">
                    <label  class="form-label mx-0 text-left " style="width: 30%; ">من تاريخ</label>
                    <input wire:model="date1"   class="form-control mr-0 text-center" type="date"  id="date1" style="width: 70%; ">
                    @error('date1') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 my-2 d-inline-flex ">
                    <label  class="form-label  text-right " style="width: 30%; ">إلي تاريخ</label>
                    <input wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mr-0 text-center" type="date"  id="date2" style="width: 70%; ">
                    @error('date2') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="col-md-2 my-2 mx-0 px-0" >
            <div class="form-check form-check-inline px-1">
                <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="1">
                <label class="form-check-label" >مرحلة</label>
            </div>
            <div class="form-check form-check-inline px-1">
                <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="0">
                <label class="form-check-label" >غير مرحلة</label>
            </div>
        </div>
        <div class="col-md-5 my-2 ">
         <div class="row">
             <div class="col-md-6  ">
                 <input wire:model="search"  type="search"   placeholder="بحث عن الحوافظ ....">
             </div>
             <div class="col-md-6 ">
                 <input wire:model="search2"  type="search"   placeholder="بحث عن تفاصيل الحافظة .......">
             </div>

         </div>
        </div>

    </div>
 <div x-data class="row">
     <div class="col-md-5 m-0 p-0">

          <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
              <thead class="font-size-12">
              <tr>
                  <th >المصرف</th>
                  <th style="width: 10%;">ر.الحافظة</th>
                  <th style="width: 20%;">تاريخ الحافظة</th>
                  <th style="width: 20%;">ج.الحافظة</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">

                  @foreach($HafTable as $item)
                      <tr class="font-size-12">
                          <td ><a wire:click="selectItem({{ $item->hafitha_no }},'{{ $item->bank_name }}')" href="#">{{ $item->bank_name }}</a>   </td>
                          <td ><a wire:click="selectItem({{ $item->hafitha_no }},'{{ $item->bank_name }}')" href="#">{{ $item->hafitha_no }}</a>   </td>
                          <td> <a wire:click="selectItem({{ $item->hafitha_no }},'{{ $item->bank_name }}')" href="#">{{ $item->hafitha_date }}</a> </td>
                          <td> <a wire:click="selectItem({{ $item->hafitha_no }},'{{ $item->bank_name }}')" href="#">{{ number_format($item->hafitha_tot,2, '.', ',') }}</a> </td>
                       </tr>
                  @endforeach


              </tbody>
          </table>
         {{ $HafTable->links() }}


     </div>
     <div class="col-md-7 m-0 p-0">
         <h3>{{$bank_name}}</h3>
         <h2>حافظة رقم {{$Haf_no}}</h2>
         <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
             <thead class="font-size-12">
             <tr>
                 <th style="width: 5%;">ت</th>
                 <th style="width: 8%;">رقم العقد</th>
                 <th style="width: 16%;">رقم الحساب</th>
                 <th >الاسم</th>
                 <th style="width: 14%;">تاريخ الخصم</th>
                 <th style="width: 8%;">المبلغ</th>
                 <th style="width: 8%;">الباقي</th>
                 <th style="width: 7%;">البيان</th>
             </tr>
             </thead>
             <tbody id="addRow" class="addRow">
             @if ($HafTranTable )
                 @foreach($HafTranTable as $key=>$item)
                     <tr class="font-size-12">
                         <td > {{ $item->ser_in_hafitha }} </td>
                         <td> {{ $item->no }} </td>
                         <td> {{ $item->acc }} </td>
                         <td> {{ $item->name }} </td>
                         <td> {{ $item->ksm_date }} </td>

                         <td> {{ $item->kst }} </td>
                         <td> {{ $item->baky}} </td>
                         @if ($item->kst_type==5)
                          <td> أرشيف </td>
                         @else
                         <td> {{ $item->kst_type_name }} </td>
                         @endif
                     </tr>
                 @endforeach
             @endif
             </tbody>
         </table>

         @if ($HafTranTable )
             {{ $HafTranTable->links() }}
         @endif
     </div>
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
