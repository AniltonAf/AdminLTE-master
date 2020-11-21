<?php 

	Class DbConnection
	{
		private $host = "127.0.0.1";

		private $port = "3306";

		private $database = "monogerador";

		private $username = "root";

		private $password = "";


		private $db;

		private function connect(){
			try{

				$options = [
		             PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        ];

		        $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->database,$this->username,$this->password,$options);

			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}

		protected function getConnection()
		{
			$this->connect();
			return $this->db;
		}

		
	}

?>