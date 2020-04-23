$('.confirm').click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Cette opération est inversible !',
        text: "Etes vous sûr de supprimer " + $(this).data('to-delete') + " ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Non'
    }).then((result) => {
        if (result.value) {
            document.location.href = $(this).attr('href');
        }
    });
});