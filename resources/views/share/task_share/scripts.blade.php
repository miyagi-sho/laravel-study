<script>
    const shares = document.getElementsByClassName('shares');
    const shares_form = document.getElementsByClassName('shares-form');

    for(let i =0; i < shares.length; i++) {
        shares[i].addEventListener('click', function (event) {
            event.preventDefault();
            shares_form[i].submit();
        });
    }
</script>
