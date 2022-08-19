$().ready(function () {
    $('#tipo_de_credito').change(function () {
        let seleccion = $(this).children("option:selected").attr('id');

        switch (seleccion) {
            case '1':
                $("#documentacion").load('./template/inputs/mejoravit.php');
                break;
            case '2':
                $("#documentacion").load('./template/inputs/c_pensionados.php');
                break;
            case '3':
                $("#documentacion").load('./template/inputs/c_renova.php');
                break;
            case '4':
                $("#documentacion").load('./template/inputs/c_pyme.php');
                break;
            case '5':
                $("#documentacion").load('./template/inputs/c_nomina.php');
                break;
            case '6':
                $("#documentacion").load('./template/inputs/c_tradicional.php');
                break;
            case '7':
                $("#documentacion").load('./template/inputs/c_fovissste_infonavit_individual.php');
                break;
            case '8':
                $("#documentacion").load('./template/inputs/c_mancomunado.php');
                break;
            case '9':
                $("#documentacion").load('./template/inputs/c_hipotecario_conyugal_fovissste_infonavit.php');
                break;
        }
    });

    $("input.btn-form").click(function(){
        $("input.input_validate").each(function(){
            $(this).rules("add", {
                required: true,
                messages:{
                    required: "Por favor suba un archivo"
                }
            })
        });
    });

    $('#tipo_credito').validate({
        rules: {
            tipo_de_credito: {
                required: true
            }
        },
        messages: {
            tipo_de_credito: {
                required: "Debe seleccionar un opci&oacute;n",
            }
        }
    });
});