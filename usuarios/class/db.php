<?

class db{
    public $numfilas = 0;

    public $servername = 'localhost';
    public $namedatabase = '';
    public $username = '';
    public $pasword = '';

    function __construct()
    {
        if (!$this->dbconexion = new mysqli($this->servername, $this->username, $this->pasword, $this->namedatabase)) {
            echo '<div class="alert alert-danger" role="alert">
                    Ocurrio un error al conectarse.
                </div>';
        }
        if (!$this->dbconexion->set_charset("utf8")) {
            echo '<div class="alert alert-danger" role="alert">
                    Error cargando el conjunto de caracteres utf8: %s\n", ' . $this->dbconexion->error . '
                </div>';
        }
    }

    function db_query( $sql = "", $tipo_query = 0 )
	{
		if($sql == "")
			return false;
		
		if(intval($tipo_query) == 0)
			return false;
		
		if( !$resultado = $this->dbconexion->query($sql) )
				return false;  
		
		switch( $tipo_query )
		{
			case 1: //Select
				if ( !$this->numfilas = $resultado->num_rows ) //SI NO HAY REGISTROS MUESTRO ERROR
					return false;

				$arr_datos_consulta = array();
				while ( $row = $resultado->fetch_array(MYSQLI_ASSOC) )
				{
					array_push($arr_datos_consulta, $row);
				}
				
				$resultado->close();

				return $arr_datos_consulta;   
			break;
			case 2://Insert
				if(!$insert_id = $this->dbconexion->insert_id )
					return false;
				
				if( intval($insert_id) > 0 )
					return  $insert_id;  
				else
					return false;
					
			break;
			case 3: //Delete
				return $resultado;
			break;
		}
		
		return false;
	}

    function db_limpia_cadena_sql($string = ""){
        if ($string == "")
            return false;
        
        return $this->dbconexion->real_escape_string( $string );
    }
}