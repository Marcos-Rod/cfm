<?
class generales{

    //Hash para pasword
    public function pwd_generate( $data = ''){
        $options = [
            $cost = 10,
        ];
        $password = password_hash($data, PASSWORD_DEFAULT);

        return $password;
    }

    //fecha actual
    public function hoy()
	{
		date_default_timezone_set('America/Mexico_City');
		return date( 'Y-m-d H:i:s',time() );
	}

    //Limpia una cadena
	public function limpia_string($string = "")
	{
		if ( $string == "" )
			return false;
		
		return mb_eregi_replace("[^ A-Za-z0-9_\.]", "", $string);
	}

    public function keys_to_works($array){
        $key_name = array_keys($array);
        
        for ($i = 0; $i < count($key_name); $i++) {
            $format_name = str_replace('_', ' ', $key_name[$i]);
            $nombres_label[] = ucfirst($format_name);
        }

        return $nombres_label;
    }

}