<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testValidatePassword()
    {
        $userController = new UserController();
        $password = 'testPassword';
        $rePassword = 'testPassword';
        $result = $userController->validatePassword($password, $rePassword);

        $this->assertTrue($result);
    }
}
