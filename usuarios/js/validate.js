$().ready(function () {

    $('#register').validate({
        rules: {
            name: {
                required: true,
                minlength: 5
            },
            mail: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                phoneUS: true
            },
            pass: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            name: {
                required: "Debe poner un nombre",
                minlength: "Escriba su nombre completo"
            },
            phone: {
                required: "El tel&eacute;fono es requerido",
                phoneUS: "Escriba un n&uacute;mero v&aacute;lido"
            },
            mail: {
                required: "Escriba un correo",
                email: "Escriba un correo v&aacute;lido"
            },
            pass: {
                required: "Escriba una contrase&ntilde;a",
                minlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)",
                maxlength: "Debe escribir correctamente tu contraseña (m&iacute;nimo 8 car&aacute;cteres)"
            }
        }
    });

    $('#login').validate({
        rules: {
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