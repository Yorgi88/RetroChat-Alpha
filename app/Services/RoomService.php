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
        return (int) config('rooms.lifetime_seconds');
    }

    private function maxUsers(): int{
        return (int) config('rooms.max_users');
    }

    private function generateCode(): string {
        $length = (int) config('rooms.code_length');
        $charset = config('rooms.code_charset');
        $maxTries = (int) config('rooms.code_max_attempts');
        // tries for unique code up to 10 times to avoid collsion
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
        // creating a new room -- 
        $code = $this->generateCode();
        $keys = $this->keysFor($code);
        $ttl = $this->ttl();
        $now = time();

        // pipeline below sends all commands in one round trip
        Redis::pipeline(function ($pipe) use ($keys, $userId, $displayName, $ttl, $now){
            //1. who the host? the one that creates the room
            $pipe->hset($keys['meta'], 'host_id', $userId);
            $pipe->hset($keys['meta'], 'created_at', $now);

            //2. the users joining the room -- done in chronological order
            $pipe->zadd($keys['users'], $now, $userId);

            //3. names hash: user if => display_name
            $pipe->hset($keys['names'], $userId, $displayName);

            //4. ttl on all three keys in seconds
            $pipe->expire($keys['meta'], $ttl);
            $pipe->expire($keys['users'], $ttl);
            $pipe->expire($keys['names'], $ttl);
        });

        return $code;
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