<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Post;

class ImportUserData extends Command
{
    protected $signature = 'import:users-posts';
    protected $description = 'Import users and posts from an external API';

    public function handle()
    {
        // Fetch Users
        $userResponse = Http::get('https://jsonplaceholder.typicode.com/users');
        $users = $userResponse->json();

        // Map to store userId from API to the actual user model ID in the database
        $userMap = [];

        foreach ($users as $userData) {
            // Create or update the user based on email
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['username'],
                    'password' => bcrypt('password'), // You might want to use a more secure password here
                ]
            );

            // Store the mapping from API userId to local user id
            $userMap[$userData['id']] = $user->id;
        }

        // Fetch Posts
        $postResponse = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = $postResponse->json();

        foreach ($posts as $postData) {
            // Get the correct local user_id using the $userMap
            $localUserId = $userMap[$postData['userId']] ?? null;

            if ($localUserId) {
                // Create or update posts with the correct user_id
                Post::updateOrCreate(
                    ['id' => $postData['id']],
                    [
                        'title' => $postData['title'],
                        'content' => $postData['body'],
                        'user_id' => $localUserId // Use the correct local user_id
                    ]
                );
            } else {
                $this->error("User ID {$postData['userId']} does not exist in the system.");
            }
        }

        $this->info('Users and posts have been successfully imported.');
    }
}
