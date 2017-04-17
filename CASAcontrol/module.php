<?

    // Klassendefinition
    class CASAcontrol extends IPSModule {


 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
			
			$this->IPS_SetProperty("IPAddr", "192.168.0.0");
			$this->IPS_SetProperty("Serial", "0231330c160c");
			$this->IPS_SetProperty("Kanal", "00");
			$this->IPS_SetProperty("Modul", "PowerPlug");			
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			//$Sn = $this->ReadPropertyString("Serial");
			//$Ip = $this->ReadPropertyString("IPAddr");
        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function on($Ip, $Sn, $Kanal) 
		{
            $url1 = "http://192.168.178.123/txcomm.asp";

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