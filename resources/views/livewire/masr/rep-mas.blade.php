<div>
    <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

        <div class="col-md-3 my-2 d-inline-flex ">
            <label  class="form-label mx-0 text-left " style="width: 30%; ">من تاريخ</label>
            <input wire:model="date1"   class="form-control mr-0 text-center" type="date"  id="date1" style="width: 70%; ">
            @error('date1') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3 my-2 d-inline-flex ">
            <label  class="form-label  text-right " style="width: 30%; ">إلي تاريخ</label>
            <input wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mr-0 text-center" type="date"  id="date2" style="width: 70%; ">
            @error('date2') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="1">
                <label class="form-check-label" >انواع المصروفات</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                <label class="form-check-label" >جهة الصرف</label>
            </div>
        </div>
        <div class="col-md-2 my-2 ">
            <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
        </div>
    </div>
 <div x-data class="row">
     <div class="col-md-3">
      <div  x-show="$wire.RepRadio==1">
          <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
              <thead class="font-size-12">
              <tr>
                  <th >البيان</th>
                  <th style="width: 20%;">الاجمالي</th>
              </tr>
              </thead>
              <tbody id="addRow" class="addRow">

                  @foreach($DetailTable as $key=>$item)
                      <tr class="font-size-12">
                          <td ><a wire:click="selectItem({{ $item->MasType }})" href="#">{{$item->MasTypeName  }}</a>   </td>
                          <td> <a wire:click="selectItem({{ $item->MasType }})" href="#">{{number_format($item->Val, 2, '.', ',') }}</a> </td>
                       </tr>
                  @endforeach


              </tbody>
          </table>

      </div>

         <div x-show="$wire.RepRadio==2">
             <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                 <thead class="font-size-12">
                 <tr>
                     <th >البيان</th>
                     <th style="width: 20%;">الاجمالي</th>
                 </tr>
                 </thead>
                 <tbody id="addRow" class="addRow">

                 @foreach($CenterTable as $key=>$item)
                     <tr class="font-size-12">
                         <td ><a wire:click="selectItem2({{ $item->MasCenter }})" href="#">{{ $item->CenterName }}</a>   </td>
                         <td> <a wire:click="selectItem2({{ $item->MasCenter }})" href="#">{{ number_format($item->Val, 2, '.', ',') }}</a> </td>
                     </tr>
                 @endforeach

                 </tbody>
             </table>


         </div>
     </div>
     <div class="col-md-9">
         <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
             <thead class="font-size-12">
             <tr>
                 <th style="width: 8%;">الرقم الالي</th>
                 <th style="width: 18%;">البيان</th>
                 <th style="width: 20%;">تفاصيل المصروفات</th>
                 <th style="width: 11%;">التاريخ</th>
                 <th style="width: 8%;">المبلغ</th>
                 <th >ملاحظات</th>

             </tr>
             </thead>
             <tbody id="addRow" class="addRow">
             @if ($RepTable )
                 @foreach($RepTable as $key=>$item)
                     <tr class="font-size-12">
                         <td > {{ $item->MasNo }} </td>
                         <td> {{ $item->CenterName }} </td>
                         <td> {{ $item->DetailName }} </td>
                         <td> {{ $item->MasDate }} </td>
                         <td> {{  number_format($item->Val, 2, '.', ',') }} </td>
                         <td> {{ $item->Notes }} </td>
                     </tr>
                 @endforeach
             @endif
             </tbody>
         </table>

         @if ($RepTable )
             {{ $RepTable->links() }}
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
