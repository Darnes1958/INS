<div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-3 my-1 d-inline-flex align-items-center">
        <label for="date" class="form-label mx-1 my-1" >التاريخ</label>
        <input wire:model="DateVal" wire:keydown.enter="ChkDateAndGo"
               class="form-control"
                type="date"  id="date" >
        @error('tran_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-9 my-2">
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
    <div>
        @livewire('amma.daily-rep-table',['tablename'=>$RepRadio,'inpdate'=>$RepDate,'searachfield1'=>$RepSearch1 ])
    </div>

</div>

@push('scripts')
    <script>

    </script>
@endpush
