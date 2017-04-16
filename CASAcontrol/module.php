<?

    // Klassendefinition
    class CASAcontrol extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
			
			$Ip = $this->RegisterPropertyString("NEW_IPAddr", "");
			$Sn = $this->RegisterPropertyString("NEW_Serial", "");
			$this->RegisterPropertyString("NEW_Kanal", "00");
			$this->RegisterPropertyString("NEW_Modul", "PowerPlug");			
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			$Ip = $this->ReadPropertyString("NEW_IPAddr");
			$Sn = $this->ReadPropertyString("NEW_Serial");
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

			$url2 = "http://".$Ip."192.168.178.123/goform/commtx?command=:02:01:00:12&serialn=".$Sn;

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