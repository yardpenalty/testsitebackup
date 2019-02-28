<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Notifiable;
    $this->command->info('Running Eloquent App\Models\Comment');
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id','user_id','bread_crumb','content'  
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       //'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
	
	 /**
     * Get the article
     */
    public function article()
    {
        return $this->hasOne('App\Article');
    }
	
	public function composer()
    {
        return $this->hasOne('App\User');
    }
}
