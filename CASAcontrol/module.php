<?

    // Klassendefinition
    class CASAcontrol extends IPSModule {


 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
			
			$this->RegisterPropertyString("IPAddr", "192.168.0.0");
			$this->RegisterPropertyString("Serial", "023100000000");
			$this->RegisterPropertyString("Kanal", "00");
			$this->RegisterPropertyString("Modul", 0);			
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
		
		public function send($id = null, String $Cmd)
		{
			$Sn = $this->ReadPropertyString("Serial");
			$Ip = $this->ReadPropertyString("IPAddr");
			$Chan = $this->ReadPropertyString("Kanal");
			$Mod = $this->ReadPropertyString("Modul");
	
			$url1 = "http://".$Ip."/txcomm.asp";

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

			$url2 = "http://".$Ip."/goform/commtx?command=:02:".$Chan.":00:".$Cmd."&serialn=".$Sn;

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
		
        public function on($id = null) 
		{
			
			$this->send($id, "11");

        }
		
		public function off($id = null) 
		{
		
			$this->send($id, "12");

        }
		public function pair($id = null) 
		{
			
			$this->send($id, "11");
			$this->send($id, "12");

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