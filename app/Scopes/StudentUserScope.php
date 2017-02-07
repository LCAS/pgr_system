<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;

class StudentUserScope extends BaseUserScope implements ScopeInterface 
{

    protected $scope_filter = 'student';
    protected $scope_column = 'user_type';
}
