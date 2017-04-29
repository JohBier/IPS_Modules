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
			
			
			
			$VarID_Switch = @IPS_GetVariableIDByName("Switch", $this->InstanceID);
			if ($VarID_Switch === false){
				$VarID_Switch = @IPS_CreateVariable(0);
				IPS_SetName($VarID_Switch, "Switch");
				IPS_SetParent($VarID_Switch, $this->InstanceID);
			}
			$eid_on = @IPS_GetObjectIDByIdent("SwitchON", $this->InstanceID);
			if ($eid_on === false){ 
				$eid_on = IPS_CreateEvent(0);
				IPS_SetParent($eid_on, $this->InstanceID);
				IPS_SetName($eid_on, "On");
				IPS_SetIdent($eid_on, "SwitchON");
				IPS_SetEventActive($eid_on, true);
				IPS_SetEventTriggerValue($eid_on, true);
				IPS_SetEventScript($eid_on, "CASA_on(\$_IPS['TARGET']);");
			}
				
			IPS_SetEventTrigger($eid_on, 4, $VarID_Switch);
			
			$eid_off = @IPS_GetObjectIDByIdent("SwitchOFF", $this->InstanceID);
			if ($eid_off === false){ 
				$eid_off = IPS_CreateEvent(0);
				IPS_SetParent($eid_off, $this->InstanceID);
				IPS_SetName($eid_off, "Off");
				IPS_SetIdent($eid_off, "SwitchOFF");
				IPS_SetEventActive($eid_off, true);
				IPS_SetEventTriggerValue($eid_off, false);
				IPS_SetEventScript($eid_off, "CASA_off(\$_IPS['TARGET']);");
			}
				
			IPS_SetEventTrigger($eid_off, 4, $VarID_Switch);
			
        }
 
        /*
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
		
		public function send(String $Cmd)
		{
			
			$Sn = $this->ReadPropertyString("Serial");
			$Ip = $this->ReadPropertyString("IPAddr");
			$Chan = $this->ReadPropertyString("Kanal");
			$Mod = $this->ReadPropertyString("Modul");
	
			$url1 = "http://".$Ip."/txcomm.asp";
			
			$ch = curl_init();								// create curl resource
			curl_setopt($ch, CURLOPT_URL, $url1); 			// set url
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	// return the transfer as a string 
			$response1 = curl_exec($ch);					// $output contains the output string
			curl_close($ch);								// close curl resource to free up system resources

			$url2 = "http://".$Ip."/goform/commtx?command=:02:".$Chan.":00:".$Cmd."&serialn=".$Sn;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response2 = curl_exec($ch);
			curl_close($ch);
			
			print $response2;
		}
		
        public function on($id) 
		{
			
			$this->send("11");
			
        }
		
		public function off($id) 
		{
		
			$this->send("12");

        }
		public function pair($id) 
		{
			
			$this->send("11");
			$this->send("12");
			
        }
		
    }