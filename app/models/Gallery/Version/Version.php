<?php namespace Gallery\Version;

use Eloquent;
use Path;
use Intervention\Image\Image as ImageUploader;

/**
 * This class depends on Interverntion image and Path classes
 */
class Version extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'versions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('id');

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * Image uploader to upload this version
     *
     * @var ImageUpload
     */
    protected $imageUploader = null;

    /**
     * Path for this version
     *
     * @var Path
     */
    protected $path = null;

    /**
     * Upload completed listener
     *
     * @var Closure
     */
    protected $uploadCompleted = null;


    /**
     * Register an uploadCompleted event event
     *
     * @param  Closure $method
     * @return void
     */
    public function registerUploadCompleted( $method )
    {
        $this->uploadCompleted = $method;
    }

    /**
     * Set image uploader.
     *
     * @param  Imageuploader $imageUploader
     * @return void
     */
    public function setImageUploader( $imageUploader )
    {
    	$this->imageUploader = $imageUploader;
    }

    /**
     * unset Image uploader
     *
     * @return void
     */
    public function unsetImageUploader()
    {
        $this->imageUploader = null;
    }

    /**
     * Create version from url which means it is already been uploaded
     *
     * @param  string  $url     
     * @param  integer $width
     * @param  integer $height
     * @return Version
     */
    public static function makeFromUrl( $url, $width = 0, $height = 0 )
    {
        return new Version(array(
            'url'    => $url,
            'width'  => $width,
            'height' => $height
        ));
    }

    /**
     * Create version from the given parameters
     *
	 * @param  string $url    
     * @param  ImageUploader $imageUploader
     * @return Version
     */
    public static function makeFromFile( $sourcePath, $destinationUrl )
    {
    	$version = new static;

    	$version->url = $destinationUrl;
    	$version->setImageUploader(ImageUploader::make($sourcePath));

    	return $version;
    }

    /**
     * Manipulate imageuploader
     *
     * @param  Closure $closure
     * @return Version fluent interface
     */
    public function manipulate( $closure )
    {
        if(is_callable($closure))
    
            call_user_func_array($closure, array($this->imageUploader));

        return $this;
    }

    /**
     * Upload current version of image.
     *
     * @return void
     */
    public function upload()
    {
        if($this->imageUploader)
        {
            $path = Path::makeFromUrl( $this->getUrl() );
            
            $path->makeSureItExists();

            $this->width  = $this->imageUploader->width;
            $this->height = $this->imageUploader->height;

        	$this->imageUploader->save($path->getFull());
        }

        if(is_callable($this->uploadCompleted))
            call_user_func_array($this->uploadCompleted, array());
    }

    /**
     * Delete version
     *
     * @return void
     */
    public function delete()
    {
        if($path = Path::makeFromUrl($this->url))
        {
            $path->delete();
        }

        parent::delete();
    }

    /**
     * Get url for this image
     *
     * @return string
     */
    public function getUrl()
    {
    	return $this->url;
    }

    /**
     * Get image for this image.
     *
     * @return Query
     */
    public function image()
    {
    	return $this->belongsTo( 'Gallery\Image\Image' );
    }

}