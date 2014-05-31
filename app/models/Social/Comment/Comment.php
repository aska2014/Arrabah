<?php namespace Social\Comment;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $fillable = array('user_id', 'description');

    /**
     * Get date for this event
     *
     * @return string
     */
    public function getDate()
    {
        return $this->created_at;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }
}