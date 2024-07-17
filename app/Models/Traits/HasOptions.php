<?php

namespace App\Models\Traits;

use App\Models\Coverage;
use App\Models\NetworkSubtype;
use App\Models\NetworkType;
use App\Models\Option;
use App\Models\ServiceSubtype;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasOptions
{
    public function options(): MorphToMany
    {
        return $this->morphToMany(Option::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }

    public function networkTypes(): MorphToMany
    {
        return $this->morphToMany(NetworkType::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }

    public function networkSubtypes(): MorphToMany
    {
        return $this->morphToMany(NetworkSubtype::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }

    public function serviceTypes(): MorphToMany
    {
        return $this->morphToMany(ServiceType::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }


    public function serviceSubtypes(): MorphToMany
    {
        return $this->morphToMany(ServiceSubtype::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }

    public function coverages(): MorphToMany
    {
        return $this->morphToMany(Coverage::class, 'model', 'model_has_options', 'model_id', 'option_id');
    }
}