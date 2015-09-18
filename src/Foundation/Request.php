<?php

namespace Fire\Foundation;

use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;
use Fire\Model\Post\PostPostType;
use Fire\Model\Page\PagePostType;
use Fire\Foundation\Collection;

class Request
{
    /**
     * @var Fire\Contracts\Model\Post\PostRepository
     */
    protected $postRepository;

    /**
     * @var Fire\Contracts\Model\Page\PageRepository
     */
    protected $pageRepository;

    /**
     * @var array
     */
    protected $errors404 = [];

    /**
     * @param Fire\Contracts\Model\Post\PostRepository $postRepository
     * @param Fire\Contracts\Model\Page\PageRepository $pageRepository
     */
    public function __construct(
        PostRepositoryContract $postRepository,
        PageRepositoryContract $pageRepository
    ) {
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;

        add_action('template_redirect', function () { $this->resolve404s(); });
        add_action('template_redirect', function () { $this->setCurrentEntities(); });
    }

    /**
     * Set WordPress conditionals that should resolve as 404s
     *
     * @param string|array  $param,...
     */
    public function resolveAs404()
    {
        foreach (func_get_args() as $arg) {
            if ( ! is_array($arg)) {
                $arg = [$arg];
            }

            $this->errors404[] = $arg;
        }
    }

    /**
     * Loop through all conditionals set and if any match the current request
     * then set a 404 response
     */
    protected function resolve404s()
    {
        global $wp_query;

        $error = false;

        foreach ($this->errors404 as $args) {
            $test = array_shift($args);

            if (call_user_func_array($test, $args)) {
                $error = true;
                break;
            }
        }

        if ($error) {
            http_response_code(404);
            $wp_query->init();
            $wp_query->parse_query(['post' => 0]);
            $wp_query->set_404();
        }
    }

    /**
     * Set the current entities for use in templates
     */
    protected function setCurrentEntities()
    {
        global $wp_query;

        if ($post = $wp_query->post) {
            if ($post->post_type === PagePostType::TYPE) {
                $this->pageRepository->setCurrentPage($this->pageRepository->pageOfId($post->ID));
            } elseif ($post->post_type === PostPostType::TYPE) {
                $this->postRepository->setCurrentPost($this->postRepository->postOfId($post->ID));
            }
        }

        $collection = new Collection;

        if ($posts = $wp_query->posts) {
            foreach ($posts as $post)
            {
                $collection->push($this->postRepository->postOfId($post->ID));
            }
        }

        $this->postRepository->setCurrentPosts($collection);
    }
}
