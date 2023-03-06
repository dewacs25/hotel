function errorValidate(message) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
    });
}

function Success(message) {
    Swal.fire({
        icon: 'success',
        title: 'Ok',
        text: message,
    });
}