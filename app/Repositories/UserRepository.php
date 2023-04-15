<?php

namespace App\Repositories;

use App\Events\CRUDErrorOccurred;
use App\Events\UserWasCreated;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\NotifyUserOfPasswordHardReset;
use App\Traits\PhoneNumberFormatterTrait;
use Str;
use DB;
use Exception;
use Illuminate\Support\Carbon;

class UserRepository
{
    protected $model;

    /**
     * Constructor
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * get model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $idOrUsername
     * @param bool $returnModel
     *
     * @return UserResource|User
     */
    public function findByIdOrUsername($idOrUsername, $returnModel = false)
    {
        $user = is_numeric($idOrUsername)
            ? $this->model->where('id', $idOrUsername)->firstOrFail()
            : $this->model->where('name', $idOrUsername)->firstOrFail();

        return $returnModel ? $user : new UserResource($user);
    }

    /**
     * @param $username
     * @param bool $returnModel
     *
     * @return User|UserResource
     */
    public function findByUsername($username, $returnModel = false)
    {
        $user = $this->model->where('name', $username)->firstOrFail();

        return $returnModel ? $user : new UserResource($user);
    }

    /**
     * @param string $phone
     * @param bool $returnModel
     *
     * @return User|UserResource
     */
    public function findByPhoneNumber($phone, $returnModel = false, $useFirstOrFail = true)
    {
        // $phone = $this->formatPhoneNumber($phone);
        $user = $this->model->where('phone', $phone)->first();

        if(! $user) {
            if($useFirstOrFail)
                abort(404, "User not found!");
            else
                return null;
        }

        return $returnModel ? $user : new UserResource($user);
    }

    /**
     * create a new user
     * @param array $data
     * @param string $role
     */
    public function create(array $data, $role) : false|User
    {
        $data = collect($data)->filter(function ($value) {
            return ! empty($value);
        })->toArray();

        try {
            DB::beginTransaction();

            $role = User::ROLE_DEFAULT;
            $theRole = 'ROLE_' . strtoupper($role);
            $data['role'] = constant("App\Models\User::$theRole");

            isset($data['date_of_birth']) ? $data['date_of_birth'] = Carbon::parse(request('date_of_birth')) : '';
            $data['password'] = bcrypt($data['password']);

            // set an appropriate (user)name if not provided
            if (!isset($data['name']) || empty($data['name'])) {
                if (isset($data['first_name'])) {
                    $data['name'] = Str::slug($data['first_name']);
                } else if (isset($data['email'])) {
                    $data['name'] = Str::slug(explode('@', $data['email'])[0]);
                } else {
                    $data['name'] = Str::slug(Str::random(10));
                }

                // check if username exists. if exists, append random str
                $existingUsername = User::where('name', $data['name'])->first();
                if($existingUsername) {
                    $data['name'] = $data['name'] . '-' . Str::random(3);
                }
            }

            $user = User::create($data);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            ddOnError($e);

            event(new CRUDErrorOccurred($e->getMessage()));

            return false;
        }

        // event
        event(new UserWasCreated($user->fresh(), request()->ip(), doe()));

        return $user;
    }

    /**
     * hard reset a user's password
     *
     * @param $username
     *
     * @return mixed
     */
    public function hardResetPassword($username)
    {
        $user = $this->findByUsername($username, true);

        $user->update([
            'password' => bcrypt('12345678'),
        ]);

        $user->enforcePasswordReset();

        // notify user
        $user->notify(new NotifyUserOfPasswordHardReset('12345678'));

        return true;
    }

    /**
     * enforce password reset
     *
     * @param $username
     *
     * @return mixed
     */
    public function enforcePasswordReset($username)
    {
        $user = $this->findByUsername($username, true);
        return $user->enforcePasswordReset();
    }

    /**
     * get the admins roles for the system
     * @return mixed
     */
    public function getAdminUsers()
    {
        return User::admins()->get();
    }

}
