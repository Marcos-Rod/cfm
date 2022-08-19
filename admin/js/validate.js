$().ready(function () {

    $('#login').validate({
        rules: {
            password: {
                required: true,
                minlength: 8,
                maxlength: 40
            },
            mail: {
                required: true,
                email: true
            }
        },
        messages: {
            password: {
                required: "Escriba una contrase&ntilde;a",
                minlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)",
                maxlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)"
            },
            mail: {
                required: "Escriba su correo",
                email: "Escriba un correo v&aacute;lido"
            }
        }
    });

    $('#ejecutivos').validate({
        rules: {
            name: {
                required: true,
            },
            pass: {
                required: true,
                minlength: 8,
                maxlength: 40
            },
            mail: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: "Debe escribir un nombre",
            },
            pass: {
                required: "Escriba una contrase&ntilde;a",
                minlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)",
                maxlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)"
            },
            mail: {
                required: "Escriba su correo",
                email: "Escriba un correo v&aacute;lido"
            }
        }
    });

});