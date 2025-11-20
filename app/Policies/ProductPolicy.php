<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user) {
        return in_array($user->role, ['admin','employee']);
    }
    public function view(User $user, Product $product) {
        return in_array($user->role, ['admin','employee']);
    }
    public function create(User $user) {
        return $user->role === 'admin';
    }
    public function update(User $user, Product $product) {
        return $user->role === 'admin';
    }
    public function delete(User $user, Product $product) {
        return $user->role === 'admin';
    }
}
