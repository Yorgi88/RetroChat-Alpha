<?php
namespace App\Services;
use Illuminate\Support\Facades\Redis;

class RoomService {
    private function keysFor(string $code): array{
        return [
            'meta' => "room:{$code}:meta",
            'users' => "room:{$code}:users",
            'names' => "room:{$code}:names",
        ];
    }

    private function ttl(): int{
        return (int) config(rooms.lifetime_seconds);
    }

    private function maxUsers(): int{
        return (int) config('rooms.max_users');
    }

    private function generateCode(): string {
        $length = (int) config('rooms.code_length');
        $charset = config('rooms.code_charset');
        $maxTries = (int) config('rooms.code_max_attempts');

        for($attempt = 0; $attempt < $maxTries; $attempt++){
            $code = $this->randomCode($length, $charset);

            if(! $this->roomExists($code)){
                return $code;
            }
        }
        throw new \RuntimeException("Failed to generate code after {$maxTries} attempts");
    }

    private function randomCode(int $length, string $charset): string {
        $code = '';
        $max = strlen($charset) -1;
        for($i = 0; $i < $length; $i++){
            $code .= $charset[random_int(0, $max)];
        }
        return $code;
    }





    public function create(string $userId, string $displayName): string {

    }

    public function roomExists(string $code): bool {
        $keys = $this->keysFor($code);
        return (bool) Redis::exists($keys['meta']);
    }

    public function roomIsFull(string $code): bool{
        $keys = $this->keysFor($code);
        return Redis::zcard($keys['users']) >= $this->maxUsers();
    }
}


?>