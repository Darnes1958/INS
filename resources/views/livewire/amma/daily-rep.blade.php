<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-2 my-1 ml-0 pl-0 d-inline-flex align-items-center">
        <label for="date" class="form-label mx-1 my-1" >التاريخ</label>
        <input wire:model="DateVal" wire:keydown.enter="ChkDateAndGo"
               class="form-control mx-0 px-1"
                type="date"  id="date" >
        @error('tran_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-7 my-2 mx-0 px-0" style="font-size: 10pt;">
       @role('مشتريات')
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="buys_view">
            <label class="form-check-label" >مشتريات</label>
        </div>
        @endrole
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"  value="sells_view">
            <label class="form-check-label" >مبيعات</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="tran_view">
            <label class="form-check-label" >ايصالات</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="Aksat">
            <label class="form-check-label" >أقساط</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" value="over_view">
            <label class="form-check-label" >فائض</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="wrong_view">
            <label class="form-check-label" >بالخطأ</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="tar_view">
            <label class="form-check-label" >ترجيع</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="main_view">
            <label class="form-check-label" >عقود</label>
        </div>


    </div>
    <div class="col-md-3 my-1 ml-0 pl-0 d-inline-flex align-items-center">
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
        @livewire('amma.daily-rep-table',['tablename'=>$RepRadio,'inpdate'=>$RepDate,'searachfield1'=>$RepSearch1 ])
    </div>

</div>

@push('scripts')
    <script>

    </script>
@endpush
