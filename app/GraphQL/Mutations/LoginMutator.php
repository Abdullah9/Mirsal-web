<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use App\Model\UserToken;
use App\User;
use Auth;
// use JWTAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Kreait\Firebase\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LoginMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $userData = array(
            'phone' => $args['phone'],
            'password' => $args['password'],
        );

        $logged = Auth::guard('api')->attempt($userData);

        $user = User::where('phone', $args['phone'])->first();

        if ($logged) {

            $token = new UserToken();
            $token->user_id = $user->id;
            $token->api_token = $logged;
            $token->save();

            $factory = (new Factory)->withServiceAccount(public_path() . "/mirsal-c162c-firebase-adminsdk-65ru1-d51b1fe76d.json");
            $factory = $factory->withDatabaseUri('https://mirsal-c162c.firebaseio.com/');
            $authFirebase = $factory->createAuth();

            $uid = "" . $user->id;
            $customToken = $authFirebase->createCustomToken($uid);

            return [
                'user' => $user,
                'token' => $logged,
                'fireBaseCustomToken' => $customToken,
            ];
        } else {
            throw new GraphqlException(
                'Invalid Credentials',
                'Please check your phone and password'
            );
        }

    }
}