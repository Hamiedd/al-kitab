<?php

namespace App\QueryFilter;

use App\Models\Category;
use App\Models\Section;
use App\Models\User;
use App\Models\Admin;

class Search extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if (empty($q)) {
            return $builder;
        }
        $model = $builder->getModel();

        if (is_array($q)) {
            return $builder;
        }

        if ($model instanceof Admin) {
            $builder->where('name', 'like', '%' . $q . '%')
                ->orWhere('email', 'like', '%' . $q . '%');
        }

        if ($model instanceof User) {
            $builder->where('name', 'like', '%' . $q . '%')
                ->orWhere('phone', 'like', '%' . $q . '%');
        }

        if ($model instanceof Section || $model instanceof Category) {
            $builder->where('name->en', 'like', '%' . $q . '%')
                    ->orWhere('name->ar', 'like', '%' . $q . '%')
                    ->orWhere('description->ar', 'like', '%' . $q . '%')
                ->orWhere('description->en', 'like', '%' . $q . '%');
        }

        return $builder;
    }
}
