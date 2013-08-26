<?php namespace Website\Page;

use Eloquent;

class Page extends Eloquent {

    const ABOUT_TITLE = 'عرابة فى سطور';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

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
     * Get about page
     *
     * @return Page
     */
    public static function getAboutPage()
    {
        return static::where('title', static::ABOUT_TITLE)->first();
    }

    /**
     * Return places that point to this page
     *
     * @return Query
     */
    public function places()
    {
        return $this->hasMany('Website\Place\Place');
    }

    /**
     * Get children for this page
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->where('parent_id', $this->id)->where('id', '!=', $this->id)->get();
    }

    /**
     * Determine whether this page has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return ! $this->where('parent_id', $this->id)->get(array('id'))->isEmpty();
    }

    /**
     * Get parent for this page
     *
     * @return Page|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get paret for this page if exists
     *
     * @return Query
     */
    public function parent()
    {
    	return $this->belongsTo('Website\Page\Page', 'parent_id');
    }
}