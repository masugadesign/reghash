<?php
/*
Ryan Masuga, ryan@masugadesign.com
http://masugadesign.com
Last Modified: Aug 28 2010
==========================================================
File: pi.reghash.php
-----------------------------------------------------------
Purpose: Generate hash for the 3rd segment of your member
registration template. Also generate the links and the check.
=========================================================== */
$plugin_info = array(
	'pi_name'        => 'RegHash',
	'pi_version'     => '0.5',
	'pi_author'      => 'Ryan Masuga',
	'pi_author_url'  => 'http://masugadesign.com/',
	'pi_description' => 'Member registration template hash creation and check',
	'pi_usage'       => Reghash::usage()
);


class Reghash
{

	var $return_data = "";

	public $member_tpl = 'members/register/'; // register template group/template
	public $salt = '1ofhd6vb'; // a string used to add extra randomness
	public $data_rand1 = ''; // Can be left blank; used to 'pad' the register hash
	public $data_rand2 = ''; // Can be left blank; used to 'pad' the register hash


  function link()
	{
		global $FNS;
		$site_index = $FNS->fetch_site_index(1,0);
		$this->return_data = $site_index.$this->member_tpl.$this->_encode();
		return $this->return_data;
	}
	// END function link()


  function hash()
	{
		$this->return_data = $this->_encode();
		return $this->return_data;
	}
	// END function hash()

		// Thanks to Chris Newton <cnewton@barrettnewton.com> for this function
		function _encode() { 
			
			$hour   = date("G"); // set to change every hour
			$month = date("n");
			$year  = date("Y"); 
			
			$data  = $hour.$this->data_rand1.$hour.$month.$this->data_rand2.$year;
			
			$base64 = base64_encode($this->rc4($this->salt,$data));
			$base64url = strtr($base64, '+/=', ',_-');
		    return $base64url;
		}

		/**
		 * Crypt/decrypt strings with RC4 stream cypher algorithm.
		 *
		 * @param string $key Key
		 * @param string $data Encripted/pure data
		 * @author Rafael M. Salvioni
		 * @see   http://pt.wikipedia.org/wiki/RC4
		 * @see http://us2.php.net/manual/en/ref.mcrypt.php
		 * @return string
		 */
		function rc4($key, $data)
		{
		    // Store the vectors "S" has calculated
		    static $SC;
		    // Function to swaps values of the vector "S"
		    $swap = create_function('&$v1, &$v2', '
		        $v1 = $v1 ^ $v2;
		        $v2 = $v1 ^ $v2;
		        $v1 = $v1 ^ $v2;
		    ');
		    $ikey = crc32($key);
		    if (!isset($SC[$ikey])) {
		        // Make the vector "S", basead in the key
		        $S    = range(0, 255);
		        $j    = 0;
		        $n    = strlen($key);
		        for ($i = 0; $i < 255; $i++) {
		            $char  = ord($key{$i % $n});
		            $j     = ($j + $S[$i] + $char) % 256;
		            $swap($S[$i], $S[$j]);
		        }
		        $SC[$ikey] = $S;
		    } else {
		        $S = $SC[$ikey];
		    }
		    // Crypt/decrypt the data
		    $n    = strlen($data);
		    $data = str_split($data, 1);
		    $i    = $j = 0;
		    for ($m = 0; $m < $n; $m++) {
		        $i        = ($i + 1) % 256;
		        $j        = ($j + $S[$i]) % 256;
		        $swap($S[$i], $S[$j]);
		        $char     = ord($data[$m]);
		        $char     = $S[($S[$i] + $S[$j]) % 256] ^ $char;
		        $data[$m] = chr($char);
		    }
		    return implode('', $data);
		}
		



function usage()
{
ob_start(); 
?>

:link (No parameters)
===========================================================
{exp:reghash:link}
	OUTPUT: /members/register/478gwfyufgs745fsiu56

:hash (Place at top of registration template; compare to segment_x)
===========================================================
{exp:reghash:hash}
	OUTPUT: 478gwfyufgs745fsiu56

<?php
$buffer = ob_get_contents();
ob_end_clean(); 
return $buffer;
}
// END


}
// end class