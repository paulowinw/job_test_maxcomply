<?php

namespace App\Tests\Security;

use App\Security\ApiTokenAuthenticator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticatorTest extends TestCase
{
    /**
     * @var ApiTokenAuthenticator
     */
    private $authenticator;

    protected function setUp(): void
    {
        // Create a new instance of the authenticator before each test
        $this->authenticator = new ApiTokenAuthenticator();
    }

    /**
     * Tests that the authenticator supports a request with the X-AUTH-TOKEN header.
     */
    public function testSupportsRequestWithToken(): void
    {
        $request = new Request([], [], [], [], [], ['HTTP_X_AUTH_TOKEN' => 'my-secret-token']);

        $this->assertTrue($this->authenticator->supports($request));
    }

    /**
     * Tests that the authenticator does not support a request without the X-AUTH-TOKEN header.
     */
    public function testDoesNotSupportRequestWithoutToken(): void
    {
        $request = new Request();

        $this->assertFalse($this->authenticator->supports($request));
    }

    /**
     * Tests that a valid API token successfully authenticates.
     */
    public function testAuthenticateWithValidToken(): void
    {
        $request = new Request([], [], [], [], [], ['HTTP_X_AUTH_TOKEN' => 'my-secret-token']);

        $passport = $this->authenticator->authenticate($request);

        // Assert that the returned object is the correct type
        $this->assertInstanceOf(SelfValidatingPassport::class, $passport);

        // Assert that the user badge exists and contains the correct user identifier
        $this->assertTrue($passport->hasBadge(UserBadge::class));
        /** @var UserBadge $userBadge */
        $userBadge = $passport->getBadge(UserBadge::class);
        $this->assertSame('admin', $userBadge->getUserIdentifier());
    }

    /**
     * Tests that an invalid API token throws an AuthenticationException.
     */
    public function testAuthenticateWithInvalidTokenThrowsException(): void
    {
        $request = new Request([], [], [], [], [], ['HTTP_X_AUTH_TOKEN' => 'wrong-token']);

        // Expect the method to throw an AuthenticationException
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Invalid API token.');

        $this->authenticator->authenticate($request);
    }

    /**
     * Tests that a missing API token throws an AuthenticationException.
     */
    public function testAuthenticateWithMissingTokenThrowsException(): void
    {
        $request = new Request([], [], [], [], [], ['HTTP_X_AUTH_TOKEN' => null]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('No API token provided.');

        $this->authenticator->authenticate($request);
    }

    /**
     * Tests that onAuthenticationSuccess returns null to allow the request to continue.
     */
    public function testOnAuthenticationSuccess(): void
    {
        $request = new Request();
        $token = $this->createMock(TokenInterface::class);

        $response = $this->authenticator->onAuthenticationSuccess($request, $token, 'main');

        $this->assertNull($response);
    }

    /**
     * Tests that onAuthenticationFailure returns a 401 JsonResponse with the exception message.
     */
    public function testOnAuthenticationFailure(): void
    {
        $request = new Request();
        $exception = new AuthenticationException('Access Denied.');

        $response = $this->authenticator->onAuthenticationFailure($request, $exception);

        // Check the response type and status code
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());

        // Check the content of the JSON response
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertSame('Authentication failed: Access Denied.', $content['message']);
    }

    /**
     * Tests that the start method returns a 401 JsonResponse.
     */
    public function testStart(): void
    {
        $request = new Request();
        $response = $this->authenticator->start($request);

        // Check the response type and status code
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());

        // Check the content of the JSON response
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertSame('Authentication Required', $content['message']);
    }
}
