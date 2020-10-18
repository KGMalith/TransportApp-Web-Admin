$.validate();



$('.btn-del').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href')


    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
        confirmButtonColor: 'green',
        cancelButtonText: 'No, Cancel!',
        cancelButtonColor: '#d33',
        reverseButtons: true

    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        } else if (

            result.dismiss === Swal.DismissReason.cancel
        ) {
            swal.fire({
                icon: 'error',
                title: 'Cancelled',
                text: 'Item Not Deleted',
                confirmButtonColor: 'green',

            })
        }
    })


})