<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\User;


class UserQuery
{
    public function getUsers($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $usersQuery = User::query();
        // role: Roles @eq
        // vet_status: VetStatuses @eq
        if(isset($args['role'])){
            $usersQuery = $usersQuery->where("role",$args['role']);
            if($args['role'] == "VETERINARIAN"){
                $userQuery = $usersQuery->where("consultation_price",">", 0);
                $userQuery = $usersQuery->where("visit_price",">", 0);
            }
        }
        if(isset($args['vet_status'])){
            $usersQuery = $usersQuery->where("vet_status",$args['vet_status']);
        }


        return $usersQuery;
    }

}