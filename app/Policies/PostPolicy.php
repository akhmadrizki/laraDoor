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
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?User $user, Post $post, ?string $secret)
    {
        // Check if there is a user
        if ($user) {
            return $user->id === $post->user_id ? Response::allow() : Response::deny("This post it's not yours 😂");
        }

        // Check if the post belongs to another user
        if ($post->user_id) {
            return Response::deny("This post it's not yours 😂");
        }

        /*
          In the logic below it's confirmed that the user is not 
          logged in and the post does not belong to another user
        */

        if (!$post->hasPassword()) {
            return Response::deny("This post can't edit, because this post has not been set password. 😜");
        }

        if (!$post->hasValidSecret($secret)) {
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
    public function delete(?User $user, Post $post, ?string $secret)
    {
        // Check if there is a user
        if ($user) {
            return $user->id === $post->user_id ? Response::allow() : Response::deny("This post it's not yours 😂");
        }

        // Check if the post belongs to another user
        if ($post->user_id) {
            return Response::deny("This post it's not yours 😂");
        }

        /*
          In the logic below it's confirmed that the user is not 
          logged in and the post does not belong to another user
        */

        if (!$post->hasPassword()) {
            return Response::deny("This post can't delete, because this post has not been set password. 😜");
        }

        if (!$post->hasValidSecret($secret)) {
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
