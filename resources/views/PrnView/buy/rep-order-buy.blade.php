<!doctype html>
<html lang="ar" dir="rtl">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
      @font-face {
          font-family: "Amiri1";
          src: url("public/fonts/Amiri-Regular.ttf") format('truetype');
          font-weight: normal;
          font-style: normal;
      }

      @font-face {
          font-family: "Amiri2";
          src: url("public/fonts/Amiri-Bold.ttf") format('truetype');
          font-weight: bold;
          font-style: normal;
      }
      body {
          direction: rtl;
          font-family: DejaVu Sans, sans-serif;
          font-size: 12px;
      }
  </style>
</head>
<body  >
<div class=" col-md-7" style="border:1px solid lightgray;background: white;" dir="rtl">
  <table class="table-sm table-bordered " width="100%"  id="orderlist" align="right">
    <thead class="font-size-10">
    <tr class="font-size-10" style="background: #9dc1d3" >
       <th width="18%">المجموع</th>
      <th width="15%">السعر </th>
      <th width="10%">الكمية</th>
      <th>اسم الصنف </th>
      <th width="15%">رقم الصنف</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($orderdetail as $key => $item)

      <tr class="font-size-10">
        <td style=" text-align: right"> {{ $item['sub_tot'] }}</td>
        <td style=" text-align: right"> {{ $item['price'] }} </td>
        <td style=" text-align: center"> {{ $item['quant'] }} </td>
        <td style=" text-align: right"> {{ $item['item_name'] }} </td>
        <td style="color: #0c63e4; text-align: center"> {{ $item['item_no'] }} </td>
      </tr>
    @endforeach
    </tbody>
    <tbody>
  </table><br>




</div>
</div>
</body>
</html>