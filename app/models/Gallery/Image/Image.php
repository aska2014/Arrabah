<?php namespace Gallery\Image;

use Eloquent;
use Gallery\Version\Version;
use Gallery\Gallery\Gallery;

use Membership\User\User;
use Membership\Admin\Admin;

use AcceptableInterface;
use OwnedByUserInterface;

class Image extends Eloquent implements AcceptableInterface, OwnedByUserInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('id', 'imageable_id', 'imageable_type');

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
     * Accept current object.
     *
     * @return void
     */
    public function accept()
    {
        $this->accepted = true;

        $this->save();
    }

    /**
     * Unaccept current object.
     *
     * @return void
     */
    public function unaccept()
    {
        $this->accepted = false;

        $this->save();
    }

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     * @return void
     */
    public function failIfNotAccepted()
    {
        if(! $this->accepted)

            throw new \NotAcceptedException;
    }

    /**
     * Get user for this object.
     *
     * @return MemberInterface
     */
    public function getUser()
    {
        return $this->user ?: Admin::instance();
    }

    /**
     * Get all images attached to galleries only
     *
     * @return Query
     */
    public static function getAttachedToGallery()
    {
        return static::where('imageable_type', 'Gallery\Gallery\Gallery');
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function getAttached()
    {
        return $this->imageable;
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function attachedToUser()
    {
        return $this->imageable_type && $this->imageable instanceof User;
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function attachedToGallery()
    {
        return $this->imageable_type && $this->imageable instanceof Gallery;
    }

    /**
     * Update image
     *
     * @param  array $versions
     * @return void
     */
    public function replace( $versions )
    {
        // Delete all versions first
        $this->versions()->delete();

        // Now upload all versions.
        $this->upload( $versions );
    }
    
    /**
     * Upload versions.
     *
     * @param  array|Version $versions
     * @return void
     */
    public function upload( $versions )
    {
        return is_array($versions) ? $this->uploadMany( $versions ) : $this->uploadOne( $versions );
    }

    /**
     * Determines if there's an image for this image
     *
     * @return boolean
     */
    public function hasImage()
    {
        return ! $this->versions()->get(array('id'))->isEmpty();
    }

    /**
     * Upload one version
     *
     * @param  Version $versions
     * @return Image (fluent interface)
     */
    private function uploadOne( Version $version )
    {
        // First upload version image.
        $version->upload();

        // Now save this version and attach it to this image.
        $this->versions()->save( $version );

        return $this;
    }

    /**
     * Upload many version
     *
     * @param  array $versions
     * @return Image (fluent interface)
     */
    private function uploadMany( array $versions )
    {
        foreach ((array)$versions as $version)
        {
            // First upload version image.
            $version->upload();

            // Now save this version and attach it to this image.
            $this->versions()->save( $version );
        }

        return $this;
    }

    /**
     * Get url from given width and height by looping through all versions
     * and get the nearst one to the given width and height.
     *
     * @param  int $width
     * @param  int $height
     * @return string
     */
    public function getUrl( $width, $height )
    {
        $version = $this->version( $width, $height );

        return $version ? $version->url : '';
    }

    /**
     * Get url of the largest image by looping through all versions
     * and get the largest width and height.
     *
     * @return string
     */
    public function getLargestUrl()
    {
        $version = $this->versions->first();

        return $version ? $version->url : '';
    }

    /**
     * Get version from given width and height by looping through all versions
     * and get the nearst one to the given width and height.
     *
     * @param  int $width
     * @param  int $height
     * @return Version
     */
    public function version( $width, $height )
    {
        $version = null;

        foreach ($this->versions as $version)
        {
            if($version->width == $width && $version->height == $height)

                return $version;
        }  

        return $version;
    }

    /**
     * Delete image with deleting all it's versions
     *
     * @return void
     */
    public function delete()
    {
        foreach ($this->versions as $version)
        {
            $version->delete();
        }

        parent::delete();
    }

    /**
     * Get version array
     *
     * @return Query
     */
    public function versions()
    {
        return $this->hasMany('Gallery\Version\Version');
    }

    /**
     * Return a query with the model it's morphed to.
     *
     * @return Query
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Return a query with the user it belongs to.
     *
     * @return Query
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }

    /**
     * Histories for this model.
     *
     * @return Query
     */
    public function histories()
    {
        return $this->morphMany('Website\History\History', 'historable');
    }
}