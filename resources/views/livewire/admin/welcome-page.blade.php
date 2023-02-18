<div>
  @php
    $id = Auth::user()->id;
    $admindata = App\Models\User::find($id);
  @endphp

  <div class="row my-4 mx-4">
    <div class="col-md-8">
      <h1 style="color: #0a53be">مرحبا بكم</h1>

      <br>
      <h1 style="color: #7a5a21">{{$CompanyName}}</h1>
      <h3>{{$CompanyNameSuffix}}</h3>
    </div>
    <div class="col-md-4 ">
            <img id="showimage" class="rounded-circle avatar-xl mt-0 pt-0" src="{{
                      (!empty($admindata->profile_image))? url('upload/admin_images/'.$admindata->profile_image):
                      url('upload/no_image.jpg')}}" alt="Card image cap">
    </div>
      @role('admin')

      <div x-data class="row ">
        <div class="col-md-2 my-4">
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="repchk" type="checkbox" wire:model="ShowUsers"  >
            <label class="form-check-label" for="inlineRadio2">عرض االمستخدمين</label>
          </div>

          <div class="form-check form-check-inline">
            <input class="form-check-input" name="repchk" type="checkbox" wire:model="ShowDailyTot"  >
            <label class="form-check-label" for="inlineRadio2">عرض عمليات اليوم</label>
          </div>
          <div wire:loading wire:target="ShowDailyTot" style="color: red;">
            يرجي الانتظار...
          </div>
        </div>
        <div x-show="$wire.ShowUsers" class="col-md-6">

          <table class="table table-sm table-bordered table-striped  w-100" >
            <caption class="caption-top text-center">المستخدمين</caption>
            <thead>
            <tr style="background: #1c6ca1;color: white;text-align: center">
              <th>الاسم</th>
              <th>الحالة</th>
              <th>بواسطة</th>
              <th>اخر ظهور</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{$user->name}}</td>
                <td>
                  @if(Cache::has('user-is-online-' . $user->id))
                    <span class="text-success">متصل</span>
                  @else
                    <span class="text-secondary">غير متصل</span>
                  @endif
                </td>
                <td>{{$user->DevType}}</td>
                <td>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                <td><img class="rounded-circle header-profile-user mt-0 pt-0" src="{{
                                      (!empty($user->profile_image))? url('upload/admin_images/'.$user->profile_image):
                                      url('upload/no_image.jpg')}}" ></td>
              </tr>
            @endforeach
            </tbody>
          </table>


          {{ $users->links() }}

        </div>
        <div x-show="$wire.ShowDailyTot" class="col-md-4">

          <table class="table table-sm table-bordered table-striped  w-100" >
            <caption class="caption-top text-center">عمليات اليوم</caption>
            <thead>
            <tr style="background: #1c6ca1;color: white;text-align: center">
              <th>البيان</th>
              <th>العدد</th>
            </tr>
            </thead>
            <tbody>
            @if (count($DailyTot)>0)
            @foreach($DailyTot as $item)
              <tr>
                <td>{{$item->data}}</td>
                <td>{{$item->val}}</td>
              </tr>
            @endforeach
            @else
              <tr>
                <td colspan="2" style="text-align: center">لم يتم ادخال عمليات بتاريخ اليوم</td>

              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
      @endrole

  </div>
</div>
