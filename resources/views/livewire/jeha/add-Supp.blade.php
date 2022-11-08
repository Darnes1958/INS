<div class="col-md-10 col-lg-12">

    <form >
        <div class="row mb-3">
         <label for="jeha_name" class="col-sm-2 g-2">اسم الزبون</label>
         <div class="col-sm-10 form-group">
            <input wire:model="jehaname"  wire:keydown.enter="$emit('gotonext','address')"  name="jeha_name" class="form-control" type="text"   >
             @error('jehaname') <span class="error">{{ $message }}</span> @enderror
         </div>
        </div>
        <div class="row mb-3">
            <label for="address" class="col-sm-2 g-2">العنوان</label>
            <div  class="col-sm-10 form-group">
                <input wire:model="address"  wire:keydown.enter="$emit('gotonext','libyana')" id="address" class="form-control" type="text"  >
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="libyana" class="col-sm-2 g-2">لبيانا</label>
            <div  class="col-sm-10 form-group">
                <input wire:model="libyana"  wire:keydown.enter="$emit('gotonext','mdar')" id="libyana" class="form-control" type="text"  >
                @error('libyana') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="mdar" class="col-sm-2 g-2">المدار</label>
            <div  class="col-sm-10 form-group">
                <input wire:model="mdar"  wire:keydown.enter="$emit('gotonext','others')" id="mdar" class="form-control" type="text"  >
                @error('mdar') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3 g-2">
            <label for="others" class="col-sm-2">رقم الهوية</label>
            <div  class="col-sm-10 form-group">
                <input wire:model="others"  wire:keydown.enter="$emit('gotonext','save-supp')" id="others" class="form-control" type="text"  >
                @error('others') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col text-center">
            <input type="button" id="save-supp"
                   class="w-100 btn btn-primary btn-lg"
                   wire:click.prevent="SaveJeha" wire:keydown.enter="SaveJeha"    value="تخزين بيانات الصنف"/>



        </div>

    </form> <!-- end col -->
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {

            if (postid=='address') {  $("#address").focus(); $("#address").select();};
            if (postid=='libyana') {  $("#libyana").focus(); $("#libyana").select();};
            if (postid=='mdar') {  $("#mdar").focus(); $("#mdar").select();};
            if (postid=='others') {  $("#others").focus(); $("#others").select();};

            if (postid=='save-supp') {
                setTimeout(function() { document.getElementById('save-supp').focus(); },100);};
        })

    </script>
@endpush
