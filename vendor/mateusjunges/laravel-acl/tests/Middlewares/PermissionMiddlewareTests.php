<?php

namespace Junges\ACL\Tests\Middlewares;

use Illuminate\Support\Facades\Auth;
use Junges\ACL\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class PermissionMiddlewareTests extends MiddlewareTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_if_a_guest_can_not_access_routes_protected_with_permission_middleware()
    {
        $this->assertEquals(
            $this->execMiddleware(
                $this->permissionMiddleware, $this->testUserPermission->slug),
            ResponseCode::HTTP_FORBIDDEN
        );
    }

    public function test_if_a_logged_in_user_can_access_routes_protected_with_two_permissions_if_has_at_least_one_of_those_permissions()
    {
        Auth::login($this->testUser);

        Auth::user()->assignPermissions($this->testUserPermission);

        $this->assertEquals(
            $this->execMiddleware(
                $this->permissionMiddleware,
                [$this->testUserPermission->slug, $this->testUserPermission2->slug]
            ),
            ResponseCode::HTTP_OK
        );
    }

    public function test_if_a_logged_in_user_can_not_access_routes_protected_by_permissions_middleware_if_have_a_different_permission()
    {
        Auth::login($this->testUser);

        Auth::user()->assignPermissions($this->testUserPermission);

        $this->assertEquals(
            $this->execMiddleware(
                $this->permissionMiddleware,
                $this->testUserPermission2->slug
            ),
            ResponseCode::HTTP_FORBIDDEN
        );
    }

    public function test_if_the_logged_in_user_can_access_routes_protected_with_permission_group_if_has_the_specified_permission()
    {
        Auth::login($this->testUser);

        Auth::user()->assignPermissions($this->testUserPermission);

        $this->assertEquals(
            $this->execMiddleware(
                $this->permissionMiddleware,
                $this->testUserPermission->slug
            ),
            ResponseCode::HTTP_OK
        );
    }

    public function test_it_throws_unauthorized_exception()
    {
        Auth::login($this->testUser);

        $this->expectException(UnauthorizedException::class);

        $this->execMiddlewareWithException(
            $this->permissionMiddleware,
            $this->testUserPermission->slug
        );
    }

    public function test_it_can_catch_denied_permissions()
    {
        Auth::login($this->testUser);

        $slug = $this->testUserPermission->slug;

        $headers = $this->execMiddlewareReturningExceptionHeaders(
            $this->permissionMiddleware,
            $slug
        );

        $this->assertCount(1, $headers);
        $this->assertEquals($slug, $headers[0]);
    }
}
