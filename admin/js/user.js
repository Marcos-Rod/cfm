$().ready(function () {

    inputEjecutivo = $('#user_id');

    $('.asignar').click(function(){
        user_id = $(this).attr("data-bs-user");
        inputEjecutivo.val(user_id);
    });

    $('.aprobar').click( function(e){
		if (confirm("La siguiente acción no puede deshacerse ¿Desea continuar?") == true) 
		{
			var url = $(this).attr("data-url");
			$(location).attr('href',url);
		} 
		else 
		{
			return false;
		}
	});

    let form = $('#eliminar');
    $('.delsec').click( function(e){
		e.preventDefault();
        if(confirm('¿Estas seguro que deseas eliminar al ejecutivo?')){
            form.submit();
        }
	});
    
});