<?php namespace Website\Place;

use Eloquent;
use Website\Page\Page;
use Website\Content\Content;

class Place extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'places';

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
     * Create all places
     *
     * @return void
     */
    public static function createAll()
    {
        if(! static::where('identifier', 'home_welcome')->first())
            static::create(array(
                'identifier' => 'home_welcome',
                'name'       => 'رسالة ترحيبية > الصفحة الرئيسية '
            ));

        if(! static::where('identifier', 'register_email')->first())
            static::create(array(
                'identifier' => 'register_email',
                'name'       => 'الرسالة التى يتم إرسالها للعضو عند التسجيل'
            ));

        if(! static::where('identifier', 'accepted_email')->first())
            static::create(array(
                'identifier' => 'accepted_email',
                'name'       => 'الرسالة التى يتم إرسالها للعضو عند قبوله'
            ));

        if(! static::where('identifier', 'be_premium')->first())
            static::create(array(
                'identifier' => 'be_premium',
                'name'       => 'صفحة الإشتراك مع موقع عرابة'
            ));
    }

    /**
     * Check if the place is correct
     *
     * @return 
     */
    public function is( $identifier )
    {
    	return $this->identifier == $identifier;
    }

    /**
     * Attach content to this 
     *
     * @param  Website\Content\Content $content
     * @return Website\Content\Content
     */
    public function attachContent( Content $content )
    {
        $content->places()->save( $this );
    }

    /**
     * Attach page to this place
     *
     * @param  Website\Page\Page $page
     * @return Website\Page\Page
     */
    public function attachPage( Page $page )
    {
        $this->page()->associate( $page );

        $this->save();
    }

    /**
     * this place belongs to one either content or widget
     *
     * @return Query
     */
    public function placeable()
    {
    	return $this->morphTo();
    }

    /**
     * Get place by identifier
     *
     * @return Place
     */
    public static function getByIdentifier( $identifier )
    {
        return static::where('identifier', $identifier)->first();
    }

    /**
     * Get name which is actually the identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Check if something is attached to this place.
     *
     * @return bool
     */
    public function hasAttached()
    {
        return $this->placeable_type != '';
    }

    /**
     * Get page for this place if exists
     *
     * @return Query
     */
    public function page()
    {
    	return $this->belongsTo( 'Website\Page\Page' );
    }
}