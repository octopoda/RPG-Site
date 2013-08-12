<?php
   	
	
    class Site extends databaseObject{

        public $table = "site";
        public $idfield = "site_id";

        public $site_id;
		public $siteName;
		public $siteDescription;
		public $googleCode;
		public $keywords;
		public $siteURL;
		public $configuration;


        public function __construct() {
            $result = $this->fetchById(1);
            $this->getSiteConfiguration();
        }


		public function createFromForm($post) {
			global $error;

			$this->fillFromForm($post);
			$this->siteDescription = strip_tags($this->siteDescription);

			if ($this->save($this->site_id)) {
				$error->addMessage('Your Site has been saved');
				return true;
			} else {
				$error->addError('The information did not save.', 'Site1248');
				return false;
			}


		}

		public function getSiteConfiguration() {
			global $db;

			$result = $db->queryFill("SELECT * FROM siteConfiguration");

			$this->configuration = array_shift($result);
			unset($this->configuration['site_id']);

		}

		public function changeSiteConfig($name, $value) {
			global $db;

			$result = $db->query("UPDATE siteConfiguration SET {$name} = ${value}");
		}


		public function reportError($postedError, $u_id) {
			global $db;
			global $error;

			usleep(1000);
			$user = new Users($u_id);

			$subject = $this->siteName . " - Report Error";
			$mailMessage =  $postedError;


			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->IsHTML();


			$mail->Host = EMAIL_HOST;
			$mail->Username = REPORT_USER;
			$mail->Password = REPORT_PASS;
			$mail->Port = EMAIL_PORT;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPAuth   = true;



			//$mail->SMTPDebug  = 2;
			$mail->AddReplyTo($user->email);
			$mail->AddAddress(REPORT_USER, $user->printName());
			$mail->SetFrom(REPORT_USER, $this->siteName.' - No Reply' );
			$mail->Subject = $subject;
			$mail->Body = $mailMessage;

			$sent = $mail->Send();

			//Mail Sent Change Password
			if ($sent) {
				$error->addMessage('The report has been sent. Octopoda will contact you soon. ');
			} else {
				$error->addMessage("There was a problem sending email.  Please try again or contact Zack.");
			}

		}




	}
?>