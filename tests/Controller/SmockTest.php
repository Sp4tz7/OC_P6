<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testPageAsUser($pageName, $url, $codeUser)
    {
        if($codeUser == 500) {
            $this->expectException(AccessDeniedException::class);
        }
        $client = self::createClient();
        $client->catchExceptions(false);
        $client->request('GET', $url);

        $response = $client->getResponse();

        self::assertEquals(
            $codeUser,
            $response->getStatusCode(),
            sprintf('%s should be %d but returned %d', $pageName, $codeUser, $response->getStatusCode())
        );
    }

    /**
     * @dataProvider provideUrls
     */
    public function testPageAsAdmin($pageName, $url, $codeUser, $codeAdmin)
    {
        $client = self::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('john.doe@example.com');
        $client->loginUser($testUser);

        $client->catchExceptions(false);
        $client->request('GET', $url);
        $response = $client->getResponse();

        self::assertEquals(
            $codeAdmin,
            $response->getStatusCode(),
            sprintf('%s should be %d but returned %d', $pageName, $codeAdmin, $response->getStatusCode())
        );
    }

    public function provideUrls()
    {
        return [
            'home' => ['Home', '/', 200, 200],
            //'app_login' => ['Login', '/login', 200, 302],
            'app_logout' => ['Logout', '/logout', 302, 302],
            'register' => ['Registration', '/register', 200, 302],
            'tricks' => ['Tricks list page', '/tricks', 200, 200],
            'admin-tricks' => ['Tricks admin list page', '/admin/tricks', 500, 200],
            'profile' => ['Profile', '/profile', 500, 200],
            'profile-password' => ['Profile change password', '/profile/password', 500, 200],
            'password-recovery' => ['Recover password', '/password/recovery', 200, 200],
        ];
    }
}
