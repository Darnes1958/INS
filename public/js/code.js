$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'هل انت متأكد ؟',
            text: "من إلغاء البيانات ؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم, أنا متأكد !' ,
            cancelButtonText: 'تراجع'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'تم!',
                    'تم الغاء البيانات.',
                    'بنجاح'
                )
            }
        })


    });

});
