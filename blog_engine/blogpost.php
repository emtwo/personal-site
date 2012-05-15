<?php

class BlogPost
{
	public $id;
	public $title;
	public $post;
	public $author;
	public $tags;
	public $datePosted;

	function __construct($inId=null, $inTitle=null, $inPost=null, $inAuthorId=null, $inDatePosted=null)
	{
		if (!empty($inId)) {
			$this->id = $inId;
		}
		if (!empty($inTitle)) {
			$this->title = $inTitle;
		}
		if (!empty($inPost)) {
			$this->post = $inPost;
		}

		if (!empty($inDatePosted)) {
			$splitDate = explode("-", $inDatePosted);
			$this->datePosted = $splitDate[1] . "/" . $splitDate[2] . "/" . $splitDate[0];
		}

		if (!empty($inAuthorId)) {
			$query = mysql_query("SELECT username FROM people WHERE id = " . $inAuthorId);
			$row = mysql_fetch_assoc($query);
			$this->author = $row["username"];
		}

		$postTags = "No Tags";
		if (!empty($inId)) {
			$query = mysql_query("SELECT tags.* FROM blog_post_tags LEFT JOIN (tags) ON (blog_post_tags.tag_id = tags.id) WHERE blog_post_tags.blog_post_id = " . $inId);
			$tagArray = array();
			$tagIDArray = array();
			
			while($row = mysql_fetch_assoc($query)) {
				array_push($tagArray, $row["name"]);
				array_push($tagIDArray, $row["id"]);
			}
			
			if (sizeof($tagArray) > 0) {
				foreach ($tagArray as $tag) {
					if ($postTags == "No Tags") {
						$postTags = $tag;
					} else {
						$postTags = $postTags . ", " . $tag;
					}
				}
			}
		}
		$this->tags = $postTags;
	}
	
	function update(){
	}
}

?>
