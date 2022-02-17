document.addEventListener('DOMContentLoaded', () => {
    // 
    let checkInLen = false;
    let checkOutLen = false;

    let check_in = document.querySelector('#check-in-date');
    let check_out = document.querySelector('#check-out-date');
    let submit = document.querySelector('#submit-btn');

    var today = new Date().toISOString().split('T')[0];
    check_out.setAttribute('min', today);
    check_in.setAttribute('min', today);

    if (check_in.value == "" || check_out.value == "") {

        submit.classList.add('submit-disabled');

    }

    check_in.addEventListener('input', (e) => {

        if (check_in.value.length > 0) {
            checkInLen = true;
        } else {
            checkInLen = false;
        }

        verificationCheck();

    })

    check_out.addEventListener('input', (e) => {

        if (check_in.value.length > 0) {
            checkOutLen = true;
        } else {
            checkOutLen = false;
        }

        verificationCheck();

    })

    const verificationCheck = () => {
        if (checkInLen &&
            checkOutLen &&
            check_in.value < check_out.value) {
            submit.classList.remove('submit-disabled');
        } else {
            submit.classList.add('submit-disabled');
        };

    }

})