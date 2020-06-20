(function($){

    let rates = getRatesOptions();

    let fieldRate = `<tr>
    <td><input type="text" name="rate[weight][]" placeholder="3" min="1" required></td>
        <td><input type="text" name="rate[nacional][]" class="wc_input_price" placeholder="10850" size="10" required></td>
        <td><input type="text" name="rate[zonal][]" class="wc_input_price" placeholder="7400" size="10" required></td>
        <td><input type="text" name="rate[urbano][]" class="wc_input_price" placeholder="6350" size="10" required></td>
        <td><input type="text" name="rate[especial][]" class="wc_input_price" placeholder="20000" size="10" required></td>
        <td class="remove"><span style="font-size:30px;color:red;cursor:pointer;" class="dashicons dashicons-minus"></span></td>
    </tr>`;

     rates.find('.add').click(function (){

        let lastNumber = rates.find('tr input[name="rate[weight][]"]').last().val();
        let lastNational = rates.find('tr input[name="rate[nacional][]"]').last().val();
        let lastZonal = rates.find('tr input[name="rate[zonal][]"]').last().val();
        let lastUrban = rates.find('tr input[name="rate[urbano][]"]').last().val();
        let lastSpecial = rates.find('tr input[name="rate[especial][]"]').last().val();

        if (lastNumber && lastNational && lastZonal && lastUrban && lastSpecial){

            rates = getRatesOptions();

            $(fieldRate).insertBefore(rates.find('tbody .additional'));
            if (lastNumber >= 1){
                lastNumber = parseInt(lastNumber) + 1;
                rates.find('tr input[name="rate[weight][]"]').last().attr('min', lastNumber);
                rates.find('tr input[name="rate[weight][]"]').last().attr('type', 'number');
            }
        }
     });

     rates.find('input[type=text]').not('input[name="rate[weight][]"]').focusout(function (){
         let el = $(this);
         let price =  el.val();
         price = formatPrice(price);
         el.val(price);
     });

    rates.on('click', '.remove', function (){
        $(this).parent('tr').remove();
    });


    function getRatesOptions(){
        return $('#rates_options');
    }

    function formatPrice(value) {

        let price = value;
        price = price.replace(/[^0-9.]+/g,'');
        let arr = price.split('.');

        if (arr.length > 1)
            price = arr[0] + arr[1];

        return price;

    }

    function isInt(number){
        return number >= 1
    }


    function uploadImage(fd){

        $.ajax({
            data: fd,
            type: 'POST',
            contentType: false,
            processData: false,
            url: ajaxurl,
            dataType: "json",
            beforeSend : () => {
                Swal.fire({
                    title: 'Subiendo información',
                    onOpen: () => {
                        Swal.showLoading()
                    },
                    allowOutsideClick: false
                });
            },
            success: (r) => {
                if (r.status){
                    Swal.fire({
                        title: '',
                        text: 'Información guardada exitosamente',
                        type: 'success',
                        showConfirmButton: false
                    });
                    window.location.reload();
                }else{
                    Swal.fire(
                        'Error',
                        r.message,
                        'error'
                    );
                }
            }
        });
    }

    $('button.generate_sticker').click(function (e) {
        e.preventDefault();

        $.ajax({
           data: {
               action: 'servientrega_generate_sticker',
               nonce: $(this).data("nonce"),
               guide_number: $(this).data("guide")
           },
           type: 'POST',
           url: ajaxurl,
           dataType: "json",
           beforeSend : () => {
               Swal.fire({
                    title: 'Generando stickers de la guía',
                    onOpen: () => {
                        Swal.showLoading()
                    },
                    allowOutsideClick: false
               });
           },
           success: (r) => {
               if (r.status){
                   Swal.close();
                   window.location.replace(r.url);
               }else{
                   Swal.fire(
                       'Error',
                       r.message,
                       'error'
                   );
               }
           }
        });
    })

})(jQuery);