<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\ActionMaster;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sei', 'mei', 'sei_kana', 'mei_kana', 'gender_id', 'tel', 'email', 'password', 'zip_code', 'prefecture', 'prefecture_name', 'address1', 'address2', 'address3', 'birthday', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

   /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */

    public function sales()
    {
        return $this->hasMany(Team::class, 'sales_id');
    }

    public function hats()
    {
        return $this->hasMany(Team::class, 'hat_id');
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function userMaster()
    {
        return $this->belongsTo(UserMaster::class);
    }

    public function userAffiliation()
    {
        return $this->belongsTo(UserMaster::class, 'office_master_id');
    }


    public function favorites()
    {
        return $this->hasMany(ProspectFavorite::class);
    }

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }

    public function excavationBehaviorLogs()
    {
        return $this->hasMany(ExcavationBehaviorLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */

    /**
     * フルネーム取得
     * @return String
     */
    public function getFullNameAttribute()
    {
        $value = $this->sei . ' ' . $this->mei;
        return $value;
    }

    //id
    protected function getAreaIdSearchattribute()
    {
        if ($this->sales->isNotEmpty()){
            return $this->sales->first()->id;
        }elseif($this->hats->isNotEmpty()){
            return $this->hats->first()->id;
        }else{
            return Team::where('office_master_id',$this->office_master_id)->first()->id;
        }
    }

    //ids
    protected function getAreaIdsSearchattribute()
    {
        if ($this->sales->isNotEmpty()){
            return $this->sales->pluck('id');
        }elseif($this->hats->isNotEmpty()){
            return $this->hats->pluck('id');
        }else{
            return NULL;
        }
    }

    //担当エリア
    protected function getAreaSearchattribute()
    {
        if ($this->sales->isNotEmpty()){
            return $this->sales->first()->area_master_id;
        }elseif($this->hats->isNotEmpty()){
            return $this->hats->first()->area_master_id;
        }else{
            return ActionMaster::where('group_num', 7)->first()->id;
        }
    }

    //該当エリアを全て取得
    protected function getAllAreaSearchattribute()
    {
        if ($this->sales->isNotEmpty()){
            return $this->sales->pluck('area_master_id');
        }else{
            return $this->hats->pluck('area_master_id');
        }
    }

    //該当エリアを全て取得
    protected function getAllAreaSearchIdsAttribute()
    {
        if ($this->sales->isNotEmpty()){
            return $this->sales->sortBy('area_master_id')->pluck('id');
        }else{
            return $this->hats->sortBy('area_master_id')->pluck('id');
        }
    }

    //該当エリアを全て取得
    protected function getAllAreaSearchNameAttribute()
    {
        if ($this->sales->isNotEmpty()){
            return ActionMaster::whereIn('id', $this->sales->pluck('area_master_id'))->pluck('action_name');
        }else{
            return ActionMaster::whereIn('id', $this->hats->pluck('area_master_id'))->pluck('action_name');
        }
    }

    //担当エリアの名前を返却
    protected function getAreaNameSearchattribute()
    {
        if($this->sales->isEmpty() && $this->hats->isEmpty()){return '担当エリアなし';}
        if ($this->sales->isNotEmpty()){
            return ActionMaster::find($this->sales->first()->area_master_id)->action_name;
        }else{
            return ActionMaster::find($this->hats->first()->area_master_id)->action_name;
        }
    }

    //担当ポジション
    protected function getPositionSearchattribute()
    {
        if ($this->status_id === 1){
            return '営業';
        }elseif($this->status_id === 2){
            return 'hat';
        }elseif($this->status_id === 3){
            return 'その他';
        }
    }

    //セレクトリスト
    public function getNameArrayAttribute()
    {
        $userList = [];
        foreach (User::all() as $user){
            $userList += [
                $user->id => $user->FullName
            ];
        }
        return $userList;
    }

}
