<?php

class Comment
{
	public $id;
	public $name;
	public $email;
	public $website;
	public $comment;
	public $datePosted;
	public $postId;

	function __construct($inId=null, $inName=null, $inEmail=null, $inWebsite=null, $inComment=null, $inDatePosted=null, $inPostId=null)
	{
		if (!empty($inId)) {
			$this->id = $inId;
		}
		if (!empty($inName)) {
			$this->name = $inName;
		}
		if (!empty($inEmail)) {
			$this->email = $inEmail;
		}
		if (!empty($inWebsite)) {
			$this->website = $inWebsite;
		}
		if (!empty($inComment)) {
			$this->comment = $inComment;
		}
		if (!empty($inDatePosted)) {
			$splitDate = explode("-", $inDatePosted);
			$this->datePosted = $splitDate[1] . "/" . $splitDate[2] . "/" . $splitDate[0];
		}
		if (!empty($inPostId)) {
			$this->postId = $inPostId;
		}
	}
	
	function update(){
	}
}

?>