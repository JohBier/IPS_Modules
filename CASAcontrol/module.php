<?

    // Klassendefinition
    class CASAcontrol extends IPSModule {


 
        // �berschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht l�schen.
            parent::Create();
			
			$this->RegisterPropertyString("IPAddr", "192.168.0.0");
			$this->RegisterPropertyString("Serial", "0231330c160c");
			$this->RegisterPropertyString("Kanal", "00");
			$this->RegisterPropertyString("Modul", 0);			
 
        }
 
        // �berschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht l�schen
            parent::ApplyChanges();
			
			$sn = $this->ReadPropertyString("Serial");
			$Ip = $this->ReadPropertyString("IPAddr");
			$Chan = $this->ReadPropertyString("Kanal");
			$Mod = $this->ReadPropertyString("Modul");
        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verf�gung, wenn das Modul �ber die "Module Control" eingef�gt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verf�gung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function on($Ip, $Sn, $Chan) 
		{
			
            $url1 = "http://" . $Ip . "/txcomm.asp";

			// create curl resource
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $url1);

			//return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$response1 = curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);

			$url2 = "http://192.168.178.123/goform/commtx?command=:02:01:00:11&serialn=0231330c160c";

			// create curl resource
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $url2);

			//return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$response2 = curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);
        }
    }



	/*	$sn_id = IPS_GetVariableIDByName("Seriennummer", 57518);
		print_r(IPS_GetVariable($sn_id));
		$sn_value = IPS_GetVariable($sn_id)["VariableValue"];
		print "array Eintrag (serial): " . $sn_value . "\n";

		$sn_id = IPS_GetVariableIDByName("IP_Addr", 57518);
		print_r(IPS_GetVariable($sn_id));
		$sn_value = IPS_GetVariable($sn_id)["VariableValue"];
		print "array Eintrag (IP): " . $sn_value . "\n";
	*/	

?>