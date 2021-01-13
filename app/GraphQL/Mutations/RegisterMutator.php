<?php

namespace App\GraphQL\Mutations;

use App\Events\OnRegister;
use App\Model\UserFile;
use App\Model\UserToken;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Str;
use JWTAuth;
use Kreait\Firebase\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterMutator
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
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver

        $token = Str::random(60) . uniqid();

        $user = new User();
        $user->role = $args['role'];
        $user->name = $args['name'];
        if (isset($args['email'])) {
            $user->email = $args['email'];
        }

        $user->phone = $args['phone'];
        $user->password = bcrypt($args['password']);
        $user->api_token = $token;
        if (isset($args['car_plate_number'])) {
            $user->car_plate_number = $args['car_plate_number'];
        }
        if (isset($args['latitude'])) {
            $user->latitude = $args['latitude'];
        }
        if (isset($args['longitude'])) {
            $user->longitude = $args['longitude'];
        }
        if (isset($args['formatted_address'])) {
            $user->formatted_address = $args['formatted_address'];
        }
        if (isset($args['national_id_url'])) {
            $user->national_id_url = $args['national_id_url'];
        }

        $user->save();
        $api_token = JWTAuth::fromUser($user);

        $factory = (new Factory)->withServiceAccount(public_path() . "/mirsal-c162c-firebase-adminsdk-65ru1-d51b1fe76d.json");
        $factory = $factory->withDatabaseUri('https://mirsal-c162c.firebaseio.com/');
        $authFirebase = $factory->createAuth();

        $uid = "" . $user->id;
        $customToken = $authFirebase->createCustomToken($uid);

        $token = new UserToken();
        $token->api_token = $api_token;
        $token->firebase_token = $customToken;
        $token->user_id = $user->id;

        $token->save();
        if (isset($args['avatar'])) {
            $file = $args['avatar'];
            if ($file) {
                $avatarName = $user->id . '_userAvatar' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('user_avatars', $avatarName);
                $user->avatar = $avatarName;
                $user->save();
            }
        }

        if (isset($args['user_file'])) {
            $file = $args['user_file'];
            if ($file) {
                $filename = $user->id . '_userFile' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('user_files', $filename);
                $userFile = new UserFile();
                $userFile->user_id = $user->id;
                $userFile->name = $filename;
                $userFile->save();
            }
        }

        event(new OnRegister($user));
        return [
            'user' => $user,
            'token' => $api_token,
            'fireBaseCustomToken' => $customToken,
        ];
    }
}