<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Property extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'user_id', 'office_master_id','area_master_id','client_id','management_company_master_id', 'construction_company_master_id', 'client_company_master_id', 'structure_property_master_id', 'right_property_master_id', 'classification_property_master_id', 'pet_property_master_id',
        'code', 'property_name', 'prefecture_master_id', 'address1', 'address2', 'parcel_number', 'nearest_station', 'nearest_station_walk_time', 'bus_stop', 'bus_stop_walk_time', 'number_building', 'number_unit', 'total_unit', 'number_floor',
        'date_completion', 'date_completion_japan', 'customer_list_flg', 'Pamphlet_flg', 'liquidity_judgment', 'property_judgment', 'approach_judgment', 'posting_flg', 'warning_flg', 'remark',
        'created_at', 'updated_at'
    ];
    protected $dates = ['date_completion'];

    public $sortable = ['property_name'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function propertyRooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\PropertyRoom');
    }

    public function caretakers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Caretaker');
    }

    public function companyMasters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\CompanyMaster');
    }

    public function propertyStructure(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\PropertyMaster', 'structure_property_master_id');
    }

    public function propertyRight(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\PropertyMaster', 'right_property_master_id');
    }

    public function propertyEarthquake(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\PropertyMaster', 'earthquake_property_master_id');
    }

    public function propertyPet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\PropertyMaster', 'pet_property_master_id');
    }

    public function prefectureMaster(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PrefectureMaster::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function propertyExcavationBehaviorLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyExcavationBehaviorLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */

    //住所
    public function getAddressAttribute()
    {
        $address_name =  $this->prefectureMaster->name . $this->address1 . $this->address2;
        return $address_name;
    }

    public function getPropertyNameListAttribute()
    {
        if (Auth::user()->sales->isNotEmpty()){
            $area_id = Auth::user()->sales->pluck('area_master_id');
        }else{
            $area_id = Auth::user()->hats->pluck('area_master_id');
        }

        $properties = $this->query()
            ->where('office_master_id', Auth::user()->office_master_id)
            ->whereIn('area_master_id', $area_id)
            ->get()->toArray();
        $propertyList = [];
        foreach ($properties as $property){
            $propertyList += [$property['id'] => $property['property_name']];
        }
        return $propertyList;
    }

    public function getPropertyNameListSelect2Attribute()
    {
        if (Auth::user()->sales->isNotEmpty()){
            $area_id = Auth::user()->sales->pluck('area_master_id');
        }else{
            $area_id = Auth::user()->hats->pluck('area_master_id');
        }

        return self::query()
            ->where('office_master_id', Auth::user()->office_master_id)
            ->whereIn('area_master_id', $area_id)
            ->select('id', 'property_name as text')
            ->get()->toArray();
    }

    public function getPropertyCodeListAttribute()
    {
        if (Auth::user()->sales->isNotEmpty()){
            $area_id = Auth::user()->sales->pluck('area_master_id');
        }else{
            $area_id = Auth::user()->hats->pluck('area_master_id');
        }

        $properties = $this->query()
            ->where('office_master_id', Auth::user()->office_master_id)
            ->whereIn('area_master_id', $area_id)
            ->get()->toArray();
        $propertyList = [];
        foreach ($properties as $property){
            $propertyList += [$property['id'] => $property['code']];
        }
        return $propertyList;
    }

    public function getPropertyCodeListSelect2Attribute()
    {
        if (Auth::user()->sales->isNotEmpty()){
            $area_id = Auth::user()->sales->pluck('area_master_id');
        }else{
            $area_id = Auth::user()->hats->pluck('area_master_id');
        }

        return self::query()
            ->where('office_master_id', Auth::user()->office_master_id)
            ->whereIn('area_master_id', $area_id)
            ->select('id', 'code as text', 'property_name')
            ->get()->toArray();
    }

    public function getRoomCountAttribute(): int
    {
        if ($this->propertyRooms->isEmpty()){
            return 0;
        }
        return $this->propertyRooms->count();
    }

    public function getDiscriminationCountAttribute(): int
    {
        if ($this->propertyRooms->isEmpty()){
            return 0;
        }
        $count = 0;

        foreach ($this->propertyRooms as $propertyRoom){
            if ($propertyRoom?->prospect?->prospectActionLogs?->last()?->stage_action_master_id === 1)
                ++$count;
        }
        return $count;
    }

    public function getLatentCountAttribute(): int
    {
        if ($this->propertyRooms->isEmpty()){
            return 0;
        }
        $count = 0;

        foreach ($this->propertyRooms as $propertyRoom){
            if ($propertyRoom->prospect?->prospectActionLogs->last()?->stage_action_master_id === 2)
            ++$count;
        }
        return $count;
    }

    public function getOvertCountAttribute(): int
    {
        if ($this->propertyRooms->isEmpty()){
            return 0;
        }
        $count = 0;

        foreach ($this->propertyRooms as $propertyRoom){
            if ($propertyRoom->prospect?->prospectActionLogs->last()?->stage_action_master_id === 3)
                ++$count;
        }
        return $count;
    }

    public function getCaretakerVisitCountAttribute(): bool
    {
        if ($this->propertyExcavationBehaviorLogs->isEmpty())return false;

        $acted = 1;
        if ($this->propertyExcavationBehaviorLogs->first()?->manager_visit_count == $acted){
            return true;
        }else{
            return false;
        }
    }

    public function getCaretakerTelCountAttribute(): bool
    {
        if ($this->propertyExcavationBehaviorLogs->isEmpty())return false;

        $acted = 1;
        if ($this->propertyExcavationBehaviorLogs->first()->manager_TEL_count == $acted){
            return true;
        }else{
            return false;
        }
    }

    public function getOnSiteCheckCountAttribute()
    {
        if ($this->propertyExcavationBehaviorLogs->isEmpty())return false;

        $acted = 1;
        if ($this->propertyExcavationBehaviorLogs->first()->check_building_count == $acted){
            return true;
        }else{
            return false;
        }
    }

}
