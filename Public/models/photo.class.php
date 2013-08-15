<?php 

/**
* 
*/
class photo
{
	private $dao,
			$photo,
			$p_id,
			$width,
	 		$height,
			$owner,
			$album,
			$path,
			$file,
			$dirname,
			$filename,
			$fullname,
			$extension,
			$description,
			$upload_date;

	public function __construct($id)
	{
		$this->photo = Photos::find($id);
		$this->p_id = $id;
		$this->owner = $this->photo->owner;
		$this->album = $this->photo->album;
		$this->path = $this->photo->path;
		$this->file = pathinfo($this->path);
		$this->fullname = $this->file['basename'];
		$this->filename = $this->file['filename'];
		$this->extension = $this->file['extension'];
		$this->dirname = $this->file['dirname'];
		$this->description = $this->photo->description;
		$this->upload_date = $this->photo->upload_date;
		list($this->width,$this->height) = getimagesize($this->path);

		$this->dao = new photo_DAO($this);
	}

	public function __get($property) {
		if (property_exists($this, $property) ) {
			return $this->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the PHOTO CLASS does not exist", 1);
		}
	}
}

?>