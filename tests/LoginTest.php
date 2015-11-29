<?php

use App\User;

class LoginTest extends TestCase
{
    /**
     * Check if guest users are being redirected to login page
     *
     * @return void
     */
    public function testUrl()
    {
        $this->visit('/')
            ->seePageIs('/login');
    }

    /**
     * Check new user creation
     *
     * @return void
     */
    public function testUserCreation()
    {
        $testingMail = 'staticemail@test.com';
        $testingPass = '123123';

        $this->visit('/login')
            ->click('Sign Up')
            ->seePageIs('/signup');

        $this->type($testingMail, 'email');
        $this->type($testingPass, 'password');
        $this->type($testingPass, 'passwordConfirmation');

        $this->press('Sign up!');
        $this->see('Registration completed!');

        $user = User::where('email', $testingMail)->first();

        $this->assertNotNull($user, 'User not found');

        $user->delete();
    }
}
