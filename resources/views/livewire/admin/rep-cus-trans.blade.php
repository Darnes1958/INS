<div x-data>
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

        <div class="col-md-2 my-2 ">
            <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="0">
                <label class="form-check-label" >الكل</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="1">
                <label class="form-check-label" >ترحيل أقساط</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio3" value="2">
                <label class="form-check-label" >إيجار سيرفر</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio4" value="3">
                <label class="form-check-label" >منظومة</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio2"  name="inlineRadioOptions2" id="inlineRadio6" value="0">
                <label class="form-check-label" >الكل</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio2" name="inlineRadioOptions2" id="inlineRadio7" value="1">
                <label class="form-check-label" >المحدد</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio3"  name="inlineRadioOptions3" id="inlineRadio8" value="0">
                <label class="form-check-label" >تقرير 1</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="RepRadio3" name="inlineRadioOptions3" id="inlineRadio9" value="1">
                <label class="form-check-label" >تقرير 2</label>
            </div>
        </div>
    </div>
    <div x-data class="row">
        @if($RepRadio3==0)
         <div class="col-md-5">

         <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                    <thead class="font-size-12">
                    <tr>

                        <th style="width: 10%;">DataBase</th>
                        <th >اسم الشركة</th>
                        <th style="width: 10%;">البيان</th>
                        <th style="width: 12%;">المحصل</th>
                        <th style="width: 12%;">القادم</th>

                    </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                    @php $Val=0;$ValNext=0; @endphp
                    @foreach($RepCusSum as $key=>$item)
                        <tr class="font-size-12">
                            <td ><a wire:click="selectItem({{ $item->CusNo }},{{$item->ValType}})" href="#">{{$item->Company  }}</a>   </td>
                            <td ><a wire:click="selectItem({{ $item->CusNo }},{{$item->ValType}})" href="#">{{$item->CompanyName  }}</a>   </td>
                            <td ><a wire:click="selectItem({{ $item->CusNo }},{{$item->ValType}})" href="#">{{$item->ValTypeName  }}</a>   </td>
                            <td ><a wire:click="selectItem({{ $item->CusNo }},{{$item->ValType}})" href="#">{{$item->Val  }}</a>   </td>
                            <td ><a wire:click="selectItem({{ $item->CusNo }},{{$item->ValType}})" href="#">{{$item->ValNext  }}</a>   </td>
                        </tr>
                        @php $Val+=$item->Val;$ValNext+=$item->ValNext; @endphp
                    @endforeach
                    <tr style="background: #9dc1d3;">
                        <td colspan="3" style="text-align: center;"> إجمالي الصفحة </td>
                        <td style="font-weight: bold"> {{ $Val }} </td>
                        <td style="font-weight: bold"> {{ $ValNext  }} </td>
                    </tr>
                    </tbody>
                </table>
          {{$RepCusSum->links()}}
        </div>
         <div class="col-md-7">
            <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                <thead class="font-size-12">
                <tr>
                    <th style="width: 10%;">التاريخ</th>

                    <th style="width: 10%;">المبلغ</th>
                    <th style="width: 10%;">التاريخ القادم</th>
                    <th style="width: 10%;">المبلغ القادم</th>
                    <th >ملاحظات</th>

                </tr>
                </thead>
                <tbody id="addRow" class="addRow">
                @php $Val=0;$ValNext=0; @endphp
                @if ($RepCusTrans )
                    @foreach($RepCusTrans as $key=>$item)
                        <tr class="font-size-12">
                            <td > {{ $item->TransDate }} </td>

                            <td> {{ $item->Val }} </td>

                            <td> {{ $item->DateNext }} </td>
                            <td> {{ $item->ValNext }} </td>

                            <td> {{ $item->Notes }} </td>
                        </tr>
                        @php $Val+=$item->Val;$ValNext+=$item->ValNext; @endphp
                    @endforeach
                @endif
                <tr style="background: #9dc1d3;">
                    <td  style="text-align: center;">الإجمالي</td>
                    <td style="font-weight: bold"> {{ $Val }} </td>
                    <td style="font-weight: bold">  </td>
                    <td style="font-weight: bold"> {{ $ValNext  }} </td>
                    <td style="font-weight: bold">  </td>
                </tr>

                </tbody>
            </table>

            @if ($RepCusTrans )
                {{ $RepCusTrans->links() }}
            @endif
        </div>
        @endif
        @if($RepRadio3==1)
          <div class="col-md-5">

                        <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                            <thead class="font-size-12">
                            <tr>

                                <th style="width: 10%;">DataBase</th>
                                <th >اسم الشركة</th>
                                <th style="width: 12%;">المحصل</th>
                                <th style="width: 12%;">القادم</th>

                            </tr>
                            </thead>
                            <tbody id="addRow" class="addRow">
                            @php $Val=0;$ValNext=0; @endphp
                            @foreach($RepCusAll as $key=>$item)
                                <tr class="font-size-12">
                                    <td ><a wire:click="selectItem2({{ $item->CusNo }})" href="#">{{$item->Company  }}</a>   </td>
                                    <td ><a wire:click="selectItem2({{ $item->CusNo }})" href="#">{{$item->CompanyName  }}</a>   </td>

                                    <td ><a wire:click="selectItem2({{ $item->CusNo }})" href="#">{{$item->Val  }}</a>   </td>
                                    <td ><a wire:click="selectItem2({{ $item->CusNo }})" href="#">{{$item->ValNext  }}</a>   </td>
                                </tr>
                                @php $Val+=$item->Val;$ValNext+=$item->ValNext; @endphp
                            @endforeach
                            <tr style="background: #9dc1d3;">
                                <td colspan="3" style="text-align: center;"> إجمالي الصفحة </td>
                                <td style="font-weight: bold"> {{ $Val }} </td>
                                <td style="font-weight: bold"> {{ $ValNext  }} </td>
                            </tr>
                            </tbody>
                        </table>
                        {{$RepCusAll->links()}}
                    </div>
          <div class="col-md-7">
                        <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
                            <thead class="font-size-12">
                            <tr>
                                <th  style="width: 20%;">البيان</th>
                                <th style="width: 20%;">المبلغ</th>
                                <th style="width: 20%;">المبلغ القادم</th>
                            </tr>
                            </thead>
                            <tbody id="addRow" class="addRow">
                            @php $Val=0;$ValNext=0; @endphp
                            @if ($RepCusAllDetail )
                                @foreach($RepCusAllDetail as $key=>$item)
                                    <tr class="font-size-12">
                                        <td > {{ $item->ValTypeName }} </td>
                                        <td> {{ $item->Val }} </td>
                                        <td> {{ $item->ValNext }} </td>
                                    </tr>
                                    @php $Val+=$item->Val;$ValNext+=$item->ValNext; @endphp
                                @endforeach
                            @endif
                            <tr style="background: #9dc1d3;">
                                <td  style="text-align: center;">الإجمالي</td>
                                <td style="font-weight: bold"> {{ $Val }} </td>

                                <td style="font-weight: bold"> {{ $ValNext  }} </td>

                            </tr>

                            </tbody>
                        </table>

                        @if ($RepCusAllDetail )
                            {{ $RepCusAllDetail->links() }}
                        @endif
                    </div>
        @endif

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

