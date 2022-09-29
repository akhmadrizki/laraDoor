<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?User $user, Post $post, ?string $password)
    {
        if (optional($user)->id !== $post->user_id) {
            return Response::deny("This post it's not yours 😂");
        }

        if (!$post->isTheOwner(optional($user))) {
            return Response::deny("This post can't be updated because it's not yours 😂");
        }

        if (!$post->hasPassword() && $post->user_id == null) {
            return Response::deny("This post can’t edit, because this post has not been set password. 😜");
        }

        if (!$post->isValidPassword($password, $post->password) && $post->user_id == null) {
            return Response::deny("The passwords you entered do not match. Please try again. 😢");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?User $user, Post $post, ?string $password)
    {
        if (optional($user)->id !== $post->user_id) {
            return Response::deny("This post it's not yours 😂");
        }

        if (!$post->isTheOwner(optional($user))) {
            return Response::deny("This post can't be deleted because it's not yours 😂");
        }

        if (!$post->hasPassword() && $post->user_id == null) {
            return Response::deny("This post can’t delete, because this post has not been set password. 😜");
        }

        if (!$post->isValidPassword($password, $post->password) && $post->user_id == null) {
            return Response::deny("The passwords you entered do not match. Please try again. 😢");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
