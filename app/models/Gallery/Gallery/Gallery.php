<?php namespace Gallery\Gallery;

use Eloquent;
use Membership\User\User;
use Membership\Admin\Admin;

use Social\Event\Event;
use AcceptableInterface;
use OwnedByUserInterface;

class Gallery extends Eloquent implements AcceptableInterface, OwnedByUserInterface {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('id', 'gallerable_id', 'gallerable_type');

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
        $this->images()->update(array('accepted' => true));
        
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
     * Determine whether the gallery has next gallery
     *
     * @return boolean 
     */
    public function hasNext()
    {
        return $this->where('id', '>', $this->id)->first(array('id')) != null;
    }

    /**
     * Determine whether the gallery has previous gallery
     *
     * @return boolean 
     */
    public function hasPrevious()
    {
        return $this->where('id', '<', $this->id)->first(array('id')) != null;
    }

    /**
     * Get next gallery in the database.
     *
     * @return Gallery
     */
    public function next()
    {
        return $this->where('id', '>', $this->id)->orderBy('id', 'ASC');
    }

    /**
     * Get previous gallery in the database.
     *
     * @return Gallery
     */
    public function previous()
    {
        return $this->where('id', '<', $this->id)->orderBy('id', 'DESC');
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function getAttached()
    {
        return $this->gallerable;
    }

    /**
     * Get all images that have images.
     *
     * @param  int $limit
     * @return Query
     */
    public function getExistImages( $limit )
    {
        return $this->images->filter(function( $image ){ 

            return $image->hasImage();

        })->slice(0, $limit);
    }


    /**
     * Check if gallery has images
     *
     * @return boolean
     */
    public function hasImages()
    {
        return ! $this->images()->get(array('id'))->isEmpty();
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function attachedToUser()
    {
        return $this->gallerable_type && $this->gallerable instanceof User;
    }

    /**
     * Get object attached to this image
     *
     * @return Eloquent
     */
    public function attachedToEvent()
    {
        return $this->gallerable_type && $this->gallerable instanceof Event;
    }

    /**
     * Determine whether the gallery is owned by user or not
     *
     * @return Image
     */
    public function ownedBy( User $user )
    {
        return $this->gallerable && $this->gallerable->same( $user );
    }

    /**
     * Get main image
     *
     * @return Image
     */
    public function getMainImage()
    {
        foreach ($this->images as $image)
        {
            if($image->hasImage()) {
                return $image;
            }
        }
    }

    /**
     * Detele gallery and all images inside.
     *
     * @return void
     */
    public function delete()
    {
        $this->images()->delete();

        parent::delete();
    }

    /**
     * Return a query with the model it's morphed to.
     *
     * @return Query
     */
    public function gallerable()
    {
        return $this->morphTo();
    }

    /**
     * Has many images
     *
     * @return Query
     */
    public function images()
    {
        return $this->morphMany('Gallery\Image\Image', 'imageable')->where('accepted', true);
    }

    /**
     * Belongs to user
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