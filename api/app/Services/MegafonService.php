<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class MegafonService
{
    private string $api = 'https://b2blk.megafon.ru/ws/v1.0';

    protected Client $client;

    protected Carbon $ttl;

    public function __construct()
    {
        $this->client = Http::buildClient();
        $this->ttl = Carbon::now()->endOfHour();
    }

    public function balance(): float
    {
        $account = $this->login();

        $uid = (string)Arr::get($account, 'data.user.accountId');

        $user = $this->user($uid);

        return (float)Arr::get($user, 'data.currentBalance');
    }

    protected function checkError(array $array): void
    {
        $error = Arr::get($array, 'error');

        throw_if($error !== null, Exception::class, $error);
    }

    protected function login(): array
    {
        $data = cache()->remember('megafon.account', $this->ttl, function() {
            return Http::acceptJson()
                ->asForm()
                ->setClient($this->client)
                ->post("{$this->api}/auth/process", [
                    'username' => config('megafon.login'),
                    'password' => config('megafon.password'),
                    'captchaTime' => Carbon::now()->timestamp,
                ])
                ->json();
        });

        $this->checkError($data);

        return $data;
    }

    protected function user(string $uid): array
    {
        $data = cache()->remember("megafon.user.{$uid}", $this->ttl, function() use ($uid) {
            return Http::acceptJson()
                ->setClient($this->client)
                ->get("{$this->api}/widget/accounts/balance/{$uid}")
                ->json();
        });

        $this->checkError($data);

        return $data;
    }
}
