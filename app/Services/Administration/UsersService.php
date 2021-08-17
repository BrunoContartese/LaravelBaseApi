<?php


namespace App\Services\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersService
{
    private $relations = [
        'destroyer',
    ];

    public function index($request)
    {
        $users = User::with($this->relations)
            ->withTrashed();

        if ($request->has('role_name')) {
            $users->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role_name);
            });
        }

        if ($request->has('query')) {
            $users->where(function ($q) use ($request) {
                $q->where('family_name', 'LIKE', "%{$request->query}%")
                    ->orWhere('email', 'LIKE', "%{$request->query}%")
                    ->orWhere('given_name', 'LIKE', "%{$request->query}%");
            });
        }

        if ($request->has('orderBy')) {
            $users->orderBy($request->orderBy, $request->orderType);
        }

        return $users->get();
    }

    public function paginated($request)
    {
        $users = User::with($this->relations)->withTrashed();

        if ($request->has('query')) {
            $users->where(function ($q) use ($request) {
                $q->where('family_name', 'LIKE', "%{$request->query}%")
                    ->orWhere('email', 'LIKE', "%{$request->query}%")
                    ->orWhere('given_name', 'LIKE', "%{$request->query}%");
            });
        }

        if ($request->has('role_name')) {
            $users->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role_name);
            });
        }

        if ($request->has('orderBy')) {
            $users->orderBy($request->orderBy, $request->orderType);
        }

        return $users->paginate($request->pageSize);
    }

    public function findById($id)
    {
        return User::with($this->relations)
            ->withTrashed()
            ->findOrFail($id);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'given_name' => $request->given_name,
                'family_name' => $request->family_name,
                'phone_number' => $request->phone_number,
                'birthdate' => Carbon::parse($request->birthdate)->format('Ymd'),
                'picture' => $request->picture,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            $user = User::create($data);
            $user->syncRoles($request->role);
            DB::commit();
            return $user;
        } catch (\Error $e) {
            DB::rollBack();
            Log::warning("Ha ocurrido un error (UsersService.store): {$e->getMessage()}");
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }
            $user = User::with($this->relations)->withTrashed()->findOrFail($id);
            $user->update($data);
            if ($request->has('role')) {
                $user->syncRoles($request->role);
            }
            DB::commit();
            return $user;
        } catch (\Error $e) {
            DB::rollBack();
            Log::warning("Ha ocurrido un error (UsersService.update): {$e->getMessage()}");
            throw $e;
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function restore($id)
    {
        $user = User::with($this->relations)
            ->withTrashed()
            ->findOrFail($id);
        $user->restore();
        return $user;
    }
}
