<?php

namespace App\tests\Functional;

use App\Controller\DefaultMoviesPageController;
use App\Handler\GetListOfGenreByMoviesHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class ControllerTest extends TestCase
{
    private $security;
    private $getListOfGenreByMoviesHandler;
    private $controller;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->getListOfGenreByMoviesHandler = $this->createMock(GetListOfGenreByMoviesHandler::class);
        $this->controller = new DefaultMoviesPageController($this->getListOfGenreByMoviesHandler);
        $this->controller->setSecurity($this->security);
    }

    public function handleRedirectsToLoginPageWhenUserIsNotAuthenticated()
    {
        $this->security->method('getToken')->willReturn(null);
        $response = $this->controller->index();
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('app_login_page', $response->getTargetUrl());
    }

    public function handleReturnsGenresWhenUserIsAuthenticated()
    {
        $token = $this->createMock(TokenInterface::class);
        $this->security->method('getToken')->willReturn($token);
        $this->getListOfGenreByMoviesHandler->method('handle')->willReturn([]);
        $response = $this->controller->index();
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testSearchMovieReturnsMovies()
    {
        $request = new Request();
        $this->requestStack->method('getCurrentRequest')->willReturn($request);
        $fakeMovies = [
            [
                'id' => 1,
                'title' => 'Fake Movie 1',
                'overview' => 'This is a fake movie for testing.',
                'poster_path' => '/path/to/fake/poster1',
                'release_date' => '2022-01-01',
                'vote_count' => 100,
                'vote_average' => 7.5,
                'video' => [
                    'key' => 'video_key1',
                    'name' => 'video_name1',
                    'type' => 'video_type1',
                    'site' => 'video_site1',
                ],
            ],
            [
                'id' => 2,
                'title' => 'Fake Movie 2',
                'overview' => 'This is another fake movie for testing.',
                'poster_path' => '/path/to/fake/poster2',
                'release_date' => '2022-02-02',
                'vote_count' => 200,
                'vote_average' => 8.0,
                'video' => [
                    'key' => 'video_key2',
                    'name' => 'video_name2',
                    'type' => 'video_type2',
                    'site' => 'video_site2',
                ],
            ],
            // Add more fake movies as needed...
        ];
        $this->getSearchMovieHandler
            ->method('handle')
            ->willReturn($fakeMovies);
        $response = $this->controller->searchMovie();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals($fakeMovies, $content);
    }
}
