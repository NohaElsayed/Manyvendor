<?php

namespace Junges\ACL\Tests\Middlewares;

use Illuminate\Support\Facades\Auth;
use Junges\ACL\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class GroupMiddlewareTests extends MiddlewareTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_if_a_guest_can_not_access_routes_protected_with_group_middleware()
    {
        $this->assertEquals(
            $this->execMiddleware(
                $this->groupMiddleware,
                $this->testUserGroup->slug
            ),
            ResponseCode::HTTP_FORBIDDEN
        );
    }

    public function test_if_the_logged_in_user_can_access_routes_protected_with_group_middleware_if_has_the_specified_group()
    {
        Auth::login($this->testUser);

        Auth::user()->assignGroup($this->testUserGroup);

        $this->assertEquals(
            $this->execMiddleware(
                $this->groupMiddleware,
                [$this->testUserGroup->slug]
            ),
            ResponseCode::HTTP_OK
        );
    }

    public function test_if_the_logged_in_user_can_not_access_routes_protected_by_group_middleware_if_have_a_different_group()
    {
        Auth::login($this->testUser);

        Auth::user()->assignGroup($this->testUserGroup);

        $this->assertEquals(
            $this->execMiddleware(
                $this->groupMiddleware,
                [$this->testAdminGroup->slug]
            ),
            ResponseCode::HTTP_FORBIDDEN
        );
    }

    public function test_it_throws_unauthorized_exception()
    {
        Auth::login($this->testUser);

        $this->expectException(UnauthorizedException::class);

        $this->execMiddlewareWithException(
            $this->groupMiddleware,
            $this->testUserGroup->slug
        );
    }

    public function test_it_can_catch_denied_permissions()
    {
        Auth::login($this->testUser);

        $slug = $this->testUserGroup->slug;

        $headers = $this->execMiddlewareReturningExceptionHeaders(
            $this->groupMiddleware,
            $slug
        );

        $this->assertCount(1, $headers);
        $this->assertEquals($slug, $headers[0]);
    }
}
