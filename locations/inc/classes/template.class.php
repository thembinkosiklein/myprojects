<?php 

/**
* Simple Template class
* @author Rodney Ncane
*/

class Template {

	public function string_replace($data, $object) {

		$returnData = '';
		$search 	= array();
		$replace 	= array();

		if ( $this->valid( $data, 'array' ) ) :

			foreach ($data as $key => $value) :
				$search[] 	= "{".$key."}";
				if ( !empty( $value ) && isset( $value ) ) :
					$replace[] 	= $value;
				else :
					$replace[] 	= '';
				endif;
			endforeach;
			$returnData = @str_replace($search, $replace, $object);
		else :
			$returnData = $object;
		endif;

		$returnData = @preg_replace("/{([a-zA-Z\_\-])*?}/i", "", $returnData);

		return $returnData;

	}

	public function valid($data, $type) {

		switch ( $type ) :
			case 'array':
				return isset( $data ) && is_array( $data ) && !empty( $data );
				break;

			case 'object':
				return isset( $data ) && is_object( $data ) && !empty( $data );
				break;
		endswitch;

	}

	public function print_out($var) {

		if ( $this->valid( $var, 'array' ) ) :
			echo "<pre>";
			print_r( $var );
			echo "<pre>";
		else :
			echo "<p>" . $var . "</p>";
		endif;

	}
	
}

?>