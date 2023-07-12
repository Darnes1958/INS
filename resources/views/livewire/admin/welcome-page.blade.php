



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
    <div class="col-md-12">
      <br>
      <br>
     <h2 class="text-danger"> تحديثات جديدة :</h2>
      <h4 class="text-primary">تم إضافة تقرير يبين عدد الاٌقساط المتبقية علي المصارف</h4>
      <h4 class="text-primary">في بند "تقرير مصارف" قم باختيار "عدد الأقساط المتبقية"   </h4>

    </div>
      @role('admin')

      <div x-data class="row ">
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >

                  <div>
                      <canvas id="mychart"></canvas>
                  </div>
              </div>
          </div>
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >
                  <div>
                      <canvas id="sellcountchart"></canvas>
                  </div>
              </div>
          </div>
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >

                  <div>
                      <canvas id="maintotchart"></canvas>
                  </div>
              </div>
          </div>
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >

                  <div>
                      <canvas id="maincountchart"></canvas>
                  </div>
              </div>
          </div>
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >
                  <div>
                      <canvas id="ksttotchart"></canvas>
                  </div>
              </div>
          </div>
          <div class="card col-md-5 mx-1" >

              <div class="card-body" >
                  <div>
                      <canvas id="kstcountchart"></canvas>
                  </div>
              </div>
          </div>
        <div class="card col-md-5 mx-1" >
          <div class="card-body" >
            <div>
              <canvas id="rebhtotchart"></canvas>
            </div>
          </div>
        </div>

        <div class="card col-md-5 mx-1" >
          <div class="card-body" >
            <div>
              <canvas id="rebhyearchart"></canvas>
            </div>
          </div>
        </div>


        <div class="col-md-2 my-4">

        </div>
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


      @endrole

  </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('mychart');
    new Chart(ctx,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($dataset)

            },
            options: {

                plugins: {


                    tooltip: {
                        enabled: false
                    }
                }
            },
        }
    );
    const ctx2 = document.getElementById('sellcountchart');
    new Chart(ctx2,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($sellcount)
            },
            options: {

                plugins: {

                legend: {

                    labels: {

                        // This more specific font property overrides the global property
                        font: {
                            size: 12,


                        }
                    }
                }},
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    );
    const ctx3 = document.getElementById('maincountchart');
    new Chart(ctx3,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($maincount)
            },

        }
    );
    const ctx4 = document.getElementById('kstcountchart');
    new Chart(ctx4,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($kstcount)
            },

        }
    );
    const ctx5 = document.getElementById('maintotchart');
    new Chart(ctx5,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($maintot)
            },

        }
    );
    const ctx6 = document.getElementById('ksttotchart');
    new Chart(ctx6,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($ksttot)
            },

        }
    );
    const ctx7 = document.getElementById('rebhtotchart');
    new Chart(ctx7,
        {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($rebhtot)
            },

        }
    );
    const ctx8 = document.getElementById('rebhyearchart');
    new Chart(ctx8,
        {
            type: 'bar',
            data: {
                labels: @json($years),
                datasets: @json($rebhyear)
            },

        }
    );
</script>
@endpush
