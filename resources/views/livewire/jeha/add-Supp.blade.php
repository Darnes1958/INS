<div class="col-md-10 col-lg-12">

    <form >
        <div class="row mb-3">
         <label for="jeha_name" class="col-sm-2 g-2">اسم الزبون</label>
         <div wire:model="jeha_name"  wire:keydown.enter="$emit('gotonext','address')" class="col-sm-10 form-group">
            <input name="jeha_name" class="form-control" type="text"   >
             @error('jeha_name') <span class="error">{{ $message }}</span> @enderror
         </div>
        </div>
        <div class="row mb-3">
            <label for="address" class="col-sm-2 g-2">العنوان</label>
            <div wire:model="address"  wire:keydown.enter="$emit('gotonext','libyana')" class="col-sm-10 form-group">
                <input name="address" class="form-control" type="text"  >
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="libyana" class="col-sm-2 g-2">لبيانا</label>
            <div wire:model="libyana"  wire:keydown.enter="$emit('gotonext','mdar')" class="col-sm-10 form-group">
                <input name="libyana" class="form-control" type="text"  >
                @error('libyana') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="mdar" class="col-sm-2 g-2">المدار</label>
            <div wire:model="mdar"  wire:keydown.enter="$emit('gotonext','others')" class="col-sm-10 form-group">
                <input name="mdar" class="form-control" type="text"  >
                @error('mdar') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3 g-2">
            <label for="others" class="col-sm-2">رقم الهوية</label>
            <div wire:model="others"  wire:keydown.enter="$emit('gotonext','others')" class="col-sm-10 form-group">
                <input name="others" class="form-control" type="text"  >
                @error('others') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col text-center">
            <button wire:click.prevent="SaveJeha" class="w-100 btn btn-primary btn-lg" type="submit">تخزين بيانات الصنف</button>
        </div>

    </form> <!-- end col -->
</div>
