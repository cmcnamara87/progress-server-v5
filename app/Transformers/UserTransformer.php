<?php
/**
 * Created by PhpStorm.
 * User: craig
 * Date: 5/04/16
 * Time: 9:12 PM
 */
namespace App\Transformers;

use League\Fractal;
use App\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'                => (int) $user->id,
            'name'              => $user->name,
            'updatedAt'         => $user->updated_at->timestamp,
            'time'              => $user->time
        ];
    }
}