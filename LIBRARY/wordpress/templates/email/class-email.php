<?php


class WordPressEmail {

 	/**
 	 * Array or String of emails where to send
 	 * @var mixed
 	 */
 	protected $emails;

 	/**
 	 * Subject of email
 	 * @var string
 	 */
 	protected $title;

 	/**
 	 * Associative Array of dynamic data
 	 * @var array
 	 */
 	protected $dynamicData = array();

 	/**
 	 * Template used to send data
 	 * @var string
 	 */
 	protected $template;

 	/**
 	 * Prepared template with real data instead of placeholders
 	 * @var string
 	 */
 	protected $outputTemplate;


	public function __construct($emails, $title, $dynamicData, $template ){

		$this->emails = $emails;
		$this->title = $title;
		$this->dynamicData = $dynamicData;
		$this->template = $template;
		$this->prepareTemplate();
		$this->send();

	}

	private function prepareTemplate(){
		$template = $this->getTemplate();

		foreach ($this->dynamicData as $placeholder => $value) {

			// Ensure that the placeholder will be in uppercase
			$securePlaceholder = strtoupper( $placeholder );

			// Placeholder used in our template
			$preparedPlaceholder = "{{" . $securePlaceholder . "}}";

			// Template with real data
			$template = str_replace( $preparedPlaceholder, $value, $template );
		}

		$this->outputTemplate = $template;
	}

	private function getTemplate(){

	    	return get_option( $this->template );

	}

	private function send(){
        		
		wp_mail( $this->emails, $this->title, $this->outputTemplate );

	}

 }

 add_action( 'user_register', 'ibenic_email_template_on_register', 10, 1 );
