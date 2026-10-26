<?php
namespace App\Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class IdentityService {
    /*
    Session keys are stored here; the keys are used to store identity data
    i made them centralized here
    */
    private const SESSION_USER_ID = 'identity.user_id';
    private const SESSION_DISPLAY_NAME = 'identity.display_name';

    public function ensureSessionIdentity(): array {

        if($this->hasIdentity()){
            return [
                'id' => $this->userId(),
                'name' => $this->displayName()
            ];
        }
        //else, if there is no hasIdentity, generate it then, for the user
        $id = $this->generateUserId();
        $name = $this->generateDisplayName();

        //store the above in the session constants
        Session::put(self::SESSION_USER_ID, $id);
        Session::put(self::SESSION_DISPLAY_NAME, $name);

        return [
            'id' => $id,
            'name' => $name
        ];
    }


    public function userId(): ?string {
        //get the current user id or null, if not set
        return Session::get(self::SESSION_USER_ID);
    }

    public function displayName(): ?string {
        //get the current display name or null, if not set
        return Session::get(self::SESSION_DISPLAY_NAME);
    }

    public function hasIdentity(): bool {
        return $this->userId() !== null && $this->displayName() !== null;
    }


    private function generateUserId(): string {
        return 'usr_' . Str::lower(Str::random(8));
    }

    private function generateDisplayName(): string {
        $adjectives = config('identity_words.adjectives');
        $nouns = config('identity_words.nouns');

        $adjective = $adjectives[array_rand($adjectives)];
        $noun = $nouns[array_rand($nouns)];

        return $adjective . '_' . $noun;
    }
}

?>